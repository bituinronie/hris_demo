<?php

namespace App\Http\Controllers\Api;

use App\Models\Dtr;
use App\Models\User;
use App\Models\TimeLog;
use App\Models\Employee;
use App\Models\Security;
use Carbon\CarbonPeriod;
use App\Traits\CronTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ServiceRecord;
use App\Traits\ConstantTrait;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class KioskController extends Controller
{
    use CronTrait, ConstantTrait;

    public $USER = null;

    private $DEFAULT_SECURITY = null;

    public function __construct(
        public Request $REQUEST
    ){
        $this->middleware('auth:api', ['except' => ['getToken','testToken']]);
        $this->USER = auth()->user();
        $this->DEFAULT_SECURITY = (object)[
            'rfid' => '',
            'template1' => null,
            'template1_number' => -1,
            'template2' => null,
            'template2_number' => -1,
            'finger_mask' => -1,
            'face_template' => null,
        ];
    }

    public function getToken(){
        $credentials = $this->REQUEST->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials['isActive'] = true;

        if (!$token = auth()->setTTL(2147483647)->attempt($credentials)) { // 68 years token
            return response('password not match', 401);
        }

        $user = User::where('username', $credentials['username'])->first();
        if($user->role != 'Kiosk')
            return response('password not match', 401);

        return response($token, 200);
    }

    public function testToken(){
        if($this->USER == null)
            return response('invalid', 401);

        return response('valid', 200);
    }

    public function logoutToken(){
        auth()->logout();

        return response()->json(null, 204);
    }

    public function timeLogSave(){
        $this->checkKioskAccess($this->USER);

        $validateData = $this->REQUEST->validate([
            'employee_id' => 'required|exists:employees,id',
            'ref_date' => 'required|date_format:Y-m-d',
            'post_date' => 'required|date_format:Y-m-d H:i:s',
            'type' => 'required|in:1,2,3,4', // 1 = TIME_IN, 2 = LUNCH_OUT, 3 = LUNCH_IN, 4 = TIME_OUT
            'uploaded' => 'nullable|boolean'
        ]);

        $dtr = Dtr::getByRefDate($validateData['employee_id'], $validateData['ref_date']);

        // generate dtr
        if($dtr == null) {
            $this->generateDtr($validateData['employee_id'], null, null, $validateData['ref_date']);
            $dtr = Dtr::getByRefDate($validateData['employee_id'], $validateData['ref_date']);
        }
        // init postDate
        $postDate = Carbon::parse($validateData['post_date']);

        if ( ($dtr->time_in == null || $dtr->time_in?->timestamp > $postDate->timestamp) && $validateData['type'] == 1)
            $dtr->time_in = $postDate;
        elseif ( ($dtr->lunch_out== null  || $dtr->lunch_out?->timestamp < $postDate->timestamp) && $validateData['type'] == 2)
            $dtr->lunch_out = $postDate;
        elseif ( ($dtr->lunch_in == null || $dtr->lunch_in?->timestamp > $postDate->timestamp) && $validateData['type'] == 3)
            $dtr->lunch_in = $postDate;
        elseif ( ($dtr->time_out == null || $dtr->time_out?->timestamp < $postDate->timestamp) && $validateData['type'] == 4)
            $dtr->time_out = $postDate;

        $dtr->save();

        if(count($dtr->getChanges()) > 0)
            return response('Time Logs and DTR successfully saved!', 201);

        // save time log
        $body = [
            'employee_id' => $validateData['employee_id'],
            'ref_date' => $validateData['ref_date'],
            'post_date' => $validateData['post_date'],
            'type' => $validateData['type'],
            'uploaded' => $validateData['uploaded'] ?? true,
            'name' => $this->USER->username,
        ];

        $this->createRecord('TimeLog', $body);

        return response('Time Logs and DTR is already saved!', 202);
    }

    public function dtr($employeeId){
        $this->checkKioskAccess($this->USER);

        $employee = Employee::find($employeeId);
        if ($employee === null)
            return response('employee not found', 500);

        $dateFrom = Carbon::now()->subDays(30)->format('Y-m-d');
        $dateTo = Carbon::now()->format('Y-m-d');

        $dtrData = Dtr::miniSelect()
                    ->where('employee_id', $employeeId)
                    ->whereBetween('ref_date',[
                        $dateFrom, 
                        $dateTo
                    ])->orderBy('ref_date','DESC')
                    ->get();

        $timeLog = TimeLog::getLastLog($employeeId);

        return response([
            'dtr' => $dtrData,
            'event' => $timeLog?->type,
            'timeLog' => $timeLog?->post_date?->format('Y-m-d H:i:s')
        ], 200);
        
    }

    public function employeeSearch($employeeId){
        $this->checkKioskAccess($this->USER);

        // init variable
        $data = [];

        $employee = Employee::find($employeeId);
        if(!$employee)
            return response('employee not found',500);

        $data['employee'] = (object) [
            'id' => $employee->id,
            'employee_number' => $employee->employee_number,
            'first_name' => strtoupper($employee->first_name),
            'middle_name' => strtoupper($employee->middle_name),
            'last_name' => strtoupper($employee->last_name),
            'name_extension' => strtoupper($employee->name_extension)
        ];

        $data['security'] = $employee->security ?? $this->DEFAULT_SECURITY;

        $data['servicerecord']['division'] = $employee->division;
        $data['servicerecord']['date_hired'] = $employee->dateHired;

        $schedules = $employee->schedules()->orderBy('effective_date', 'asc')->get();

        $day = Str::lower((string) date('D'));
        $beforeDate = Carbon::parse(date('Y-m-d'))->subDay();
        $beforeDay =  Str::lower((string) Carbon::now()->subDay()->format('D'));

        $returnSchedule = [
            'before' => [],
            'today' => []
        ];

        foreach ($schedules as $employeSchedule) {
            $schedule = $employeSchedule->schedule;

            if($employeSchedule->effective_date->timestamp <=  $beforeDate->timestamp){
                $returnSchedule['before'] = [
                    'id' => $employeSchedule->id,
                    'schedule_id' => $schedule->id,
                    'code' => $schedule->code,
                    'effective_day' => Carbon::now()->subDay()->format('l'),
                    'time_in' => $schedule[$beforeDay.'_time_in'],
                    'lunch_out' => $schedule[$beforeDay.'_lunch_out'],
                    'lunch_in' => $schedule[$beforeDay.'_lunch_in'],
                    'time_out' => $schedule[$beforeDay.'_time_out'],
                    'flexi_from' => $schedule['flexi_from'],
                    'flexi_to' => $schedule['flexi_to']
                ];
            }

            if($employeSchedule->effective_date->timestamp <= time()) {
                $returnSchedule['today'] = [
                    'id' => $employeSchedule->id,
                    'schedule_id' => $schedule->id,
                    'code' => $schedule->code,
                    'effective_day' => Carbon::now()->format('l'),
                    'time_in' => $schedule[$day.'_time_in'],
                    'lunch_out' => $schedule[$day.'_lunch_out'],
                    'lunch_in' => $schedule[$day.'_lunch_in'],
                    'time_out' => $schedule[$day.'_time_out'],
                    'flexi_from' => $schedule['flexi_from'],
                    'flexi_to' => $schedule['flexi_to']
                ];
            }
        }

        $data['schedule'] = $returnSchedule;

        $data['dtr']['before'] = Dtr::miniSelect()
                                    ->where('ref_date', $beforeDate)
                                    ->where('employee_id', $employee['id'])
                                    ->first();

        $data['dtr']['today'] = Dtr::miniSelect()
                                    ->where('ref_date', date('Y-m-d'))
                                    ->where('employee_id', $employee['id'])
                                    ->first();

        return response($data, 200);
    }

    public function employee(Request $request, $id = null){
        $this->checkKioskAccess($this->USER);

        $parseToReturnData = function($employee) {
            $security = $employee->security ?? $this->DEFAULT_SECURITY;

            return [
                'id' => $employee->id,
                'employee_number' => $employee->employee_number,
                'last_name' => strtoupper($employee->last_name),
                'first_name' => strtoupper($employee->first_name),
                'middle_name' => strtoupper($employee->middle_name),
                'name_extension' => strtoupper($employee->name_extension),
                'birth_date' => $employee->birth_date,
                'position' => $employee->designationName,
                'division' => $employee->division,
                'mobile' => $employee->mobile,
                'email' => $employee->email,
                'rfid' => $security->rfid,
                'template1' => $security->template1,
                'template1_number' => $security->template1_number,
                'template2' => $security->template2,
                'template2_number' => $security->template2_number,
                'finger_mask' => $security->finger_mask,
                'face_template' => $security->face_template,
                'image_url' => $employee->dpUrl ?? url('/img/no-image.png')
            ];
        };

        if($id !== null) {
            $employee = Employee::find($id);
            if(!$employee)
                return response('employee not found',500);

            return response($parseToReturnData($employee),200);
        }

        $search_text = $request->input('search_text');
        $kiosk_name = $request->input('kiosk_name');

        if (!is_null($search_text) && is_null($kiosk_name))
            $activeEmployees = Employee::where('employee_number','LIKE',"%$search_text%")->orWhere('last_name','LIKE',"%$search_text")->orWhere('first_name','LIKE',"%$search_text%")->orderBy('created_at', 'DESC')->limit(10)->get();
        elseif (is_null($kiosk_name))
            $activeEmployees = Employee::orderBy('created_at', 'DESC')->limit(10)->get();
        else 
            $activeEmployees = Employee::whereHas('security',function ($query) use ($kiosk_name) {
                $query->whereJsonContains('kiosk_name',$kiosk_name);
            })->orderBy('created_at', 'DESC')->get();
        // $activeEmployees = $activeEmployees->filter(function($item) {
        //     $sr = ServiceRecord::getRecord($item->id);
        //     if (is_null($sr))
        //         return false;
        //     return !in_array($sr->remark_id, $this->remarkIdNotApplied);
        // });

        // dd($kiosk_name);
        // if (!is_null($kiosk_name)) {
        //     $activeEmployees = $activeEmployees->filter(function($employee) use ($kiosk_name) {
        //         $security = $employee->security;
        //         if (is_null($security)) {
        //             return false;
        //         }
        //         return in_array($kiosk_name,$security->kiosk_name);
        //     });
        // }

        $returnData = $activeEmployees->map(function($item) use ($parseToReturnData) {
            return $parseToReturnData($item);
        });
        $toArray = array();
        foreach ($returnData as $key=>$data) {
            $toArray[] = $data;
        }
        return response($toArray,200);
    }

    public function getLastLogEvent($id,$scheduleData) {
        $now = Carbon::now();
        $schedule_today = array();
        foreach ($scheduleData['today'] as $key=>$value) {
            if ($key!='sched_id')
                $schedule_today[$key] = !is_null($value)?new Carbon($now->toDateString(). ' ' . $value):null;
        }
        $schedule_tommorow = array();
        foreach ($scheduleData['tommorow'] as $key=>$value) {
            if ($key!='sched_id')
                $schedule_tommorow[$key] = !is_null($value)?new Carbon(date('Y-m-d H:i:s',strtotime('+1 day',strtotime($now->toDateString(). ' ' . $value)))):null;
        }
        $schedule_yesterday = array();
        foreach ($scheduleData['yesterday'] as $key=>$value) {
            if ($key!='sched_id')
                $schedule_yesterday[$key] = !is_null($value)?new Carbon(date('Y-m-d H:i:s',strtotime('-1 day',strtotime($now->toDateString(). ' ' . $value)))):null;
        }
        // dd($schedule_today);
        $lastEvent = 0;
        $reference_date = new Carbon();
        $timeLog = TimeLog::orderBy('post_date','desc')
                            ->where('ref_date',$now->toDateString())
                            ->where('employee_id', $id)
                            ->first();
        // dd($timeLog);
        if (!is_null($timeLog)) {
            $lastEvent = $timeLog->type;
            $reference_date = new Carbon($timeLog->post_date);
            // dd($reference_date->diffInHours($now,false));
            if ($reference_date->diffInHours($now,false)<1) {
                return array(
                    'type' => $lastEvent,
                    'reference_date' => $reference_date->toDateString()
                );
            }
            if (!is_null($schedule_tommorow['time_in'])) {
                if ($schedule_tommorow['time_in']->diffInHours($now,false)>=-4) {
                    $timeLog = TimeLog::orderBy('post_date','desc')
                            ->where('ref_date',date('Y-m-d',strtotime('+1 day',strtotime($now->toDateString()))))
                            ->where('employee_id', $id)
                            ->first();
                    if (is_null($timeLog)) {
                        return array (
                            'type' => 0,
                            'reference_date' => Carbon::parse(date('Y-m-d',strtotime('+1 day',strtotime($now->toDateString()))))->toDateString()
                        );
                    } else {
                        return array (
                            'type' => $timeLog->type,
                            'reference_date' => Carbon::parse($timeLog->post_date)->toDateString()
                        );
                    }
                }
            }
        } else {
            if (!is_null($schedule_today['time_in'])) {
                if ($schedule_today['time_in']->diffInHours($now,false) >= -4 && $now<$schedule_today['time_out']) {
                    return array (
                        'type' => 0,
                        'reference_date' => $now->toDateString()
                    );
                }
                if (!is_null($schedule_tommorow['time_in'])) {
                    if ($schedule_tommorow['time_in']->diffInHours($now,false)>=-4) {
                        $timeLog = TimeLog::orderBy('post_date','desc')
                                ->where('ref_date',date('Y-m-d',strtotime('+1 day',strtotime($now->toDateString()))))
                                ->where('employee_id', $id)
                                ->first();
                        if (is_null($timeLog)) {
                            return array (
                                'type' => 0,
                                'reference_date' => Carbon::parse(date('Y-m-d',strtotime('+1 day',strtotime($now->toDateString()))))->toDateString()
                            );
                        } else {
                            return array (
                                'type' => $timeLog->type,
                                'reference_date' => Carbon::parse($timeLog->post_date)->toDateString()
                            );
                        }
                    }
                }
                $timeLog = TimeLog::orderBy('post_date','desc')
                    ->where('ref_date',date('Y-m-d',strtotime('-1 day',strtotime($now->toDateString()))))
                    ->where('employee_id', $id)
                    ->first();
                if (!is_null($timeLog)) {
                    if (!is_null($schedule_yesterday['time_out'])) {
                        if ($schedule_yesterday['time_out']->diffInHours($now,false)<2) {
                            return array (
                                'type' => $timeLog->type,
                                'reference_date' => Carbon::parse($timeLog->post_date)->toDateString()
                            );
                        }
                        if ($timeLog->type=='TIME IN' || (Carbon::parse($timeLog->post_date)->diffInHours($now,false)<1 && $timeLog->type!='TIME_IN')){
                            return array (
                                'type' => $timeLog->type,
                                'reference_date' => Carbon::parse($timeLog->post_date)->toDateString()
                            );
                        }
                    }
                }
            } 
            
        }
        return array (
            'type' => $lastEvent,
            'reference_date' => $reference_date->toDateString()
        );
    }

    public function employeeSchedule($id){
        $this->checkKioskAccess($this->USER);

        $employee = Employee::find($id);
        if ($employee === null)
            return response('employee not found', 500);

        $date = Carbon::now()->subDay()->format('Y-m-d');

        $index = collect(['yesterday','today','tommorow']);

        $scheduleData = $index->mapWithKeys(function($day, $key) use ($date, $id) {
            $refDate = Carbon::parse($date)->addDays($key)->toDateString();

            $schedule = Employee::getScheduleByDate($id, $refDate);

            return [
                $day => [
                    'sched_id' => $schedule?->id ?? '',
                    'time_in' => $schedule?->time_in?->toTimeString() ?? null,
                    'lunch_out' => $schedule?->lunch_out?->toTimeString() ?? null,
                    'lunch_in' => $schedule?->lunch_in?->toTimeString() ?? null,
                    'time_out' => $schedule?->time_out?->toTimeString() ?? null
                ]
            ];
        });
        
        $lastEvent = $this->getLastLogEvent($id,$scheduleData);
        // dd($lastEvent);
        return response([
            'schedule' => $scheduleData,
            'event_type' =>  $lastEvent['type'],
            'event_date' => $lastEvent['reference_date']
        ], 200);

    }

    public function schedule(Request $request, $employeeId = null){
        $this->checkKioskAccess($this->USER);
        $kiosk_name = $request->input('kiosk_name');
        
        $getData = function ($employeeId) {
            $employee = Employee::find($employeeId);
            if ($employee === null)
                return null;

            // init returnData
            $returnData = [
                'id' => null,
                'schedule_id' => null,
                'employee_id' => null,
                'effective_date' => null,
                "mon_time_in" => null,
                "mon_lunch_out" => null,
                "mon_lunch_in" => null,
                "mon_time_out" => null,
                "tue_time_in" => null,
                "tue_lunch_out" => null,
                "tue_lunch_in" => null,
                "tue_time_out" => null,
                "wed_time_in" => null,
                "wed_lunch_out" => null,
                "wed_lunch_in" => null,
                "wed_time_out" => null,
                "thu_time_in" => null,
                "thu_lunch_out" => null,
                "thu_lunch_in" => null,
                "thu_time_out" => null,
                "fri_time_in"  => null,
                "fri_lunch_out"  => null,
                "fri_lunch_in"  => null,
                "fri_time_out"  => null,
                "sat_time_in"  => null,
                "sat_lunch_out"  => null,
                "sat_lunch_in"  => null,
                "sat_time_out"  => null,
                "sun_time_in"  => null,
                "sun_lunch_out"  => null,
                "sun_lunch_in"  => null,
                "sun_time_out"  => null,
                "flexi_from" => null,
                "flexi_to" => null
            ];

            // init dates
            $dateToday = Carbon::now();
            $startDate = $dateToday->copy()->startOfWeek()->format('Y-m-d');
            $endDate = $dateToday->copy()->endOfWeek()->format('Y-m-d');

            $period = CarbonPeriod::create($startDate, $endDate);
            $isIdsApplied = false;
            $isFlexiApplied = false;

            foreach ($period as $date) {
                $day = Str::lower($date->copy()->format('D'));
                $refDate = $date->copy()->format('Y-m-d');

                $schedule = Employee::getScheduleByDate($employee->id, $refDate);

                // validating null schedule
                if (!$schedule)
                    continue;

                // applying employee ids
                if (!$isIdsApplied) {
                    $returnData['id'] = $schedule->employeeScheduleId;
                    $returnData['schedule_id'] = $schedule->id;
                    $returnData['employee_id'] = $employee->id;
                    $returnData['effective_date'] = $schedule->effectiveDate;

                    $isIdsApplied = true;
                }

                // applying flexi schedule
                if (!$isFlexiApplied) {
                    if ($schedule->isFlexi) {
                        $returnData["flexi_from"] = $schedule->flexi_from->toTimeString();
                        $returnData["flexi_to"] = $schedule->flexi_to->toTimeString();

                        $isFlexiApplied = true;
                    }
                }

                // applying bandi schedules
                $returnData["{$day}_time_in"] = $schedule->time_in?->toTimeString();
                $returnData["{$day}_lunch_out"] = $schedule->lunch_out?->toTimeString();
                $returnData["{$day}_lunch_in"] = $schedule->lunch_in?->toTimeString();
                $returnData["{$day}_time_out"] = $schedule->time_out?->toTimeString();
            }

            if (!$returnData['id'])
                return [];

            return $returnData;
        };

        if($employeeId != null) {
            $returnData = $getData($employeeId);
            if ($returnData === null)
                return response('employee not found', 500);
        }else {
            $employees = Employee::orderBy('created_at', 'DESC')->get();

            $activeEmployees = $employees->filter(function($item) {
                $sr = ServiceRecord::getRecord($item->id);

                if (is_null($sr))
                    return false;

                return !in_array($sr->remark_id, $this->remarkIdNotApplied);
            });

            if (!is_null($kiosk_name)) {
                $activeEmployees = $activeEmployees->filter(function($employee) use ($kiosk_name) {
                    $security = $employee->security;
                    if (is_null($security)) {
                        return false;
                    }
                    return in_array($kiosk_name,$security->kiosk_name);
                });
            }
            
            $returnData = $activeEmployees->map(function ($item) use ($getData) {
                return $getData($item->id);
            })->filter()->values();
        }

        return response($returnData, 200);
    }

    public function monthlySchedule(Request $request, $employeeId = null){
        $this->checkKioskAccess($this->USER);
        $kiosk_name = $request->input('kiosk_name');
        
        $getData = function ($employeeId) {
            $employee = Employee::find($employeeId);
            if ($employee === null)
                return null;

            // init returnData
            $returnData = [
                'id' => null,
                'schedule_id' => null,
                'employee_id' => null,
                'effective_date' => null,
                'schedules' => []
            ];

            // init dates
            $dateToday = Carbon::now();
            // $startDate = $dateToday->copy()->format('Y-m-01');
            $startDate = $dateToday->copy()->subDays(1)->format('Y-m-d');
            $endDate = $dateToday->copy()->addDays(30)->format('Y-m-d');

            $period = CarbonPeriod::create($startDate, $endDate);
            $isIdsApplied = false;
            $isFlexiApplied = false;

            foreach ($period as $date) {
                $day = Str::lower($date->copy()->format('D'));
                $refDate = $date->copy()->format('Y-m-d');

                $schedule = Employee::getScheduleByDate($employee->id, $refDate);

                // validating null schedule
                if (!$schedule)
                    continue;

                // applying employee ids
                if (!$isIdsApplied) {
                    $returnData['id'] = $schedule->employeeScheduleId;
                    $returnData['schedule_id'] = $schedule->id;
                    $returnData['employee_id'] = $employee->id;
                    $returnData['effective_date'] = $schedule->effectiveDate;

                    $isIdsApplied = true;
                }

                // applying bandi schedules
                $returnData['schedules'][] = array(
                    'ref_date' => $refDate,
                    'time_in' => $schedule->time_in?->toTimeString(),
                    'lunch_out' => $schedule->lunch_out?->toTimeString(),
                    'lunch_in' => $schedule->lunch_in?->toTimeString(),
                    'time_out' => $schedule->time_out?->toTimeString()
                );
                // $returnData['schedules'][]]["time_in"] = $schedule->time_in?->toTimeString();
                // $returnData['schedules'][]]["lunch_out"] = $schedule->lunch_out?->toTimeString();
                // $returnData['schedules'][]]["lunch_in"] = $schedule->lunch_in?->toTimeString();
                // $returnData['schedules'][]]["time_out"] = $schedule->time_out?->toTimeString();
            }

            if (!$returnData['id'])
                return [];

            return $returnData;
        };

        if($employeeId != null) {
            $returnData = $getData($employeeId);
            if ($returnData === null)
                return response('employee not found', 500);
        }else {
            $employees = Employee::orderBy('created_at', 'DESC')->get();

            $activeEmployees = $employees->filter(fn($item) => ServiceRecord::getRecord($item->id, null, true) );

            if (!is_null($kiosk_name)) {
                $activeEmployees = $activeEmployees->filter(function($employee) use ($kiosk_name) {
                    $security = $employee->security;
                    if (is_null($security)) {
                        return false;
                    }
                    return in_array($kiosk_name,$security->kiosk_name);
                });
            }
            
            $returnData = $activeEmployees->map(function ($item) use ($getData) {
                return $getData($item->id);
            })->filter()->values();
        }

        return response($returnData, 200);
    }

    public function register(){
        $this->checkKioskAccess($this->USER);

        $validateData = $this->REQUEST->validate([
            'employee_id' => 'required',
            'rfid' => 'nullable|max:10',
            'template1' => 'nullable',
            'template1_number' => 'nullable|max:11',
            'template2' => 'nullable',
            'template2_number' => 'nullable|max:11',
            'finger_mask' => 'nullable|max:11',
            'face_template' => 'required',
            'kiosk_name' => 'required'
        ]);
        
        $employee = Employee::find($validateData['employee_id']);
        if($employee === null)
            return response("falied",500);

        $security = Security::firstOrNew(['employee_id' => $validateData['employee_id']]);
        // dd($security);
        unset($validateData['employee_id']);
        // dd($validateData);
        $isValidateRfid = true;
        if(isset($security->id)) {
            if ($security->rfid == $validateData['rfid'])
                $isValidateRfid = false;
        }

        $kiosk_names = is_null($security->kiosk_name)?array():$security->kiosk_name;
        
        if (!in_array($validateData['kiosk_name'],$kiosk_names)) {
            $kiosk_names[] = $validateData['kiosk_name'];
            $security->kiosk_name = $kiosk_names;
        }

        // if($isValidateRfid)
        //     $this->REQUEST->validate(['rfid' => 'unique:securities']);

        foreach ($validateData as $key => $value) {
            if ($key!='kiosk_name')
                $security[$key] = $value;
        }
        // dd($security);
        if($security->save())
            return response("success",201);
        
        return response("failed",500);
    }

    public function employeeRfid($rfid){
        $this->checkKioskAccess($this->USER);

        $employee = Employee::findByRfid($rfid);

        $security = $employee->security ?? $this->DEFAULT_SECURITY;

        $returnResponse = [
            'id' => $employee->id,
            'employee_number' => $employee->employee_number,
            'last_name' => strtoupper($employee->last_name),
            'first_name' => strtoupper($employee->first_name),
            'middle_name' => strtoupper($employee->middle_name),
            'name_extension' => strtoupper($employee->name_extension),
            'birth_date' => $employee->birth_date,
            'position' => $employee->designationName,
            'division' => $employee->division,
            'mobile' => $employee->mobile,
            'email' => $employee->email,
            'rfid' => $security->rfid,
            'template1' => $security->template1,
            'template1_number' => $security->template1_number,
            'template2' => $security->template2,
            'template2_number' => $security->template2_number,
            'finger_mask' => $security->finger_mask,
            'face_template' => $security->face_template,
            'image_url' => $employee->dpUrl ?? url('/img/no-image.png')
        ];

        return response($returnResponse, 200);
    }

    public function employeeFaceData(){
        $this->checkKioskAccess($this->USER);

        $validateData = $this->REQUEST->validate([
            'facedata' => 'required',
        ]);

        $employee = Employee::findByFaceData($validateData['facedata']);

        $security = $employee->security ?? $this->DEFAULT_SECURITY;

        $returnResponse = [
            'id' => $employee->id,
            'employee_number' => $employee->employee_number,
            'last_name' => strtoupper($employee->last_name),
            'first_name' => strtoupper($employee->first_name),
            'middle_name' => strtoupper($employee->middle_name),
            'name_extension' => strtoupper($employee->name_extension),
            'birth_date' => $employee->birth_date,
            'position' => $employee->designationName,
            'division' => $employee->division,
            'mobile' => $employee->mobile,
            'email' => $employee->email,
            'rfid' => $security->rfid,
            'template1' => $security->template1,
            'template1_number' => $security->template1_number,
            'template2' => $security->template2,
            'template2_number' => $security->template2_number,
            'finger_mask' => $security->finger_mask,
            'face_template' => $security->face_template,
            'image_url' => $employee->dpUrl ?? url('/img/no-image.png')
        ];

        return response($returnResponse, 200);
    }

    public function employeeById($id){
        $this->checkKioskAccess($this->USER);

        $employee = Employee::find($id);

        $security = $employee->security ?? $this->DEFAULT_SECURITY;
        if (!is_null($employee)) {
            $returnResponse = [
                'id' => $employee->id,
                'employee_number' => $employee->employee_number,
                'last_name' => strtoupper($employee->last_name),
                'first_name' => strtoupper($employee->first_name),
                'middle_name' => strtoupper($employee->middle_name),
                'name_extension' => strtoupper($employee->name_extension),
                'birth_date' => $employee->birth_date,
                'position' => $employee->designationName,
                'division' => $employee->division,
                'mobile' => $employee->mobile,
                'email' => $employee->email,
                'rfid' => $security->rfid,
                'template1' => $security->template1,
                'template1_number' => $security->template1_number,
                'template2' => $security->template2,
                'template2_number' => $security->template2_number,
                'finger_mask' => $security->finger_mask,
                'face_template' => $security->face_template,
                'image_url' => $employee->dpUrl ?? url('/img/no-image.png')
            ];
        } else {
            $returnResponse = null;
        }

        return response($returnResponse, 200);
    }
}
