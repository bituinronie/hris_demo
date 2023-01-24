<?php

namespace App\Http\Controllers\Api\TimeKeeping;

use App\Models\Employee;
use App\Models\Schedule;

use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\EmployeeTrait;
use Illuminate\Support\Carbon;
use App\Models\SpecialSchedule;
use App\Models\EmployeeSchedule;
use App\Http\Controllers\Controller;

class EmployeeScheduleController extends Controller
{
    use EmployeeTrait;

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
            'effective_date' => 'required',
            'schedule_type' => 'required|in:REGULAR,SPECIAL',
            'type' => 'in:PERMANENT,ONE_TIME',
            'schedule_id' => 'nullable',
            'special_schedule_id' => 'nullable',
        ]);

        if($body['schedule_type'] == 'REGULAR') {
            $this->REQUEST->validate([
                'effective_date' => 'date_format:Y-m-d',
                'type' => 'required',
                'schedule_id' => 'required|exists:schedules,id',
            ]); 
        }else {
            $this->REQUEST->validate([
                'effective_date' => 'date_format:Y-m-01',
                'special_schedule_id' => 'required|exists:special_schedules,id',
            ]);

            $specialSchedule = SpecialSchedule::whereId($body['special_schedule_id'])->where('ref_date', $body['effective_date'])->first();

            if(!$specialSchedule)
                abort(422, 'special schedule and effective_date won\'t match.');
        }

        return $body;
    }

    public function create($employeeId){
        $this->checkUserAccess(auth()->user(), 'write employee schedule');

        $this->checkEmployeeId($employeeId);

        $body = $this->validation();

        $isAlready = EmployeeSchedule::firstOrNew(['employee_id' => $employeeId, 'effective_date' => $body['effective_date']])?->id;

        if ($isAlready)
            return response([
                'message' => 'Employee already has schedule on the given effective date.'
            ], 400);

        if($body['schedule_type'] == 'REGULAR') {
            $schedule = Employee::getScheduleByDate($employeeId, $body['effective_date']);

            if ($schedule) {
                if ($schedule->isSpecial)
                    return response([
                        'message' => 'Employee already has assigned to special schedule.'
                    ], 400);
            }

            $saveBody = [
                'employee_id' => $employeeId,
                'schedule_id' => $body['schedule_id'],
                'effective_date' => $body['effective_date']
            ];

            if($body['type'] == 'ONE_TIME') {
                // init effective dates
                $effectiveDate = Carbon::parse($body['effective_date']);
                $prevEffectiveDate = $effectiveDate->subDay(1)->toDateString();
                $nextEffectiveDate = $effectiveDate->addDay(2)->toDateString();

                // apply schedule for that reference date
                $this->createRecord('EmployeeSchedule', $saveBody);

                // apply schedule for the next day
                $scheduleId = Employee::getScheduleByDate($employeeId, $prevEffectiveDate)?->id;
                if ($scheduleId !== null) {
                    $saveBody['effective_date'] = $nextEffectiveDate;
                    $saveBody['schedule_id'] = $scheduleId;

                    $this->createRecord('EmployeeSchedule', $saveBody);
                }
            }else { // saving permanent type of schedule
                $this->createRecord('EmployeeSchedule', $saveBody);
            }
        }else {
            $body['employee_id'] = $employeeId;
            $this->createRecord('EmployeeSchedule', $body);
        }

        return response(['message' => 'employeeschedule successfully created.'], 201);
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search employee schedule');

        return response([
            'schedule_type' => ['REGULAR','SPECIAL'],
            'type' => ['PERMANENT','ONE_TIME'],
            'schedule' => Schedule::all()->map(function($item) {
                    return [
                        'id' => $item->id,
                        'code' => $item->code,
                        'description' => $item->description,
                        'info' => $item->info
                    ];
                })
        ], 200);
    }

    public function specialScheduleParameter(){
        $this->checkUserAccess(auth()->user(), 'search employee schedule');

        $refDate = $this->REQUEST->validate([
            'ref_date' => 'required|date_format:Y-m-01'
        ])['ref_date'];

        $specialSchedules = SpecialSchedule::select('id','code','description','template')->where('ref_date', $refDate)->get();

        return response($specialSchedules, 200);
    }

    public function today($employeeId){
        $this->checkUserAccess(auth()->user(), 'search employee schedule');
        $this->checkEmployeeId($employeeId);

        return response(Employee::getTodaySchedule($employeeId), 200);
    }

    public function returnSearchSchedule($employeeId){
        $query = EmployeeSchedule::select('*')->where('employee_id', $employeeId)->orderBy('effective_date','ASC');

        // Filters
        $filters = $this->REQUEST->validate([
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:schedule_id,employee_id,effective_date',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        if (isset($filters['field']))
           $query = $query->orderBy($filters['field'], $filters['order']);

        // return response
        $entities = $query->get();

        $count = $entities ==[]? 0:count($entities);
        $renderedData = collect();

        $try = 0;
        $io = 0;
        $getEntity = function($entity, $date){
            return [
                'id' => $entity->id,
                'schedule_type' => $entity->schedule_type,
                'date' => $date,
                'code' => $entity->code,
                'description' => $entity->description,
                'info' => $entity->schedule?->info ?? $entity->special_schedule
            ];
        };

        for ($i=0; $i < $count; $i++) {
            $entity = $entities[$i];

            if($entity->schedule_type == 'REGULAR') {
                if($count == 1){
                    $startDate = $entity->effective_date->format('M d, Y');

                    $renderedData->push($getEntity($entity, Str::upper($startDate.' - Present')));
                    break;
                }

                if($try  == 0){
                    $startDate = $entity->effective_date->format('M d, Y');
                    $prevEntity = $entities[$i];

                    $try = 1;
                    continue;
                }

                $endDate = $entity->effective_date->subDay(1)->format('M d, Y');

                if (strtotime($endDate) == strtotime($startDate)){
                    $renderedData->push($getEntity($prevEntity, Str::upper($startDate)));
                    $io++;
                }else {
                    $renderedData->push($getEntity($prevEntity, Str::upper("$startDate - $endDate")));
                    $io++;
                }

                $startDate = $entity->effective_date->format('M d, Y');
                $prevEntity = $entities[$i];

                if($i == ($count-1)){
                    $renderedData->push($getEntity($entity, Str::upper("$startDate - Present")));
                    $try = 0;
                }
            }else {

                if($try == 1) {
                    $endDate = $entity->effective_date->subDay(1)->format('M d, Y');

                    if (strtotime($endDate) == strtotime($startDate)){
                        $renderedData->push($getEntity($prevEntity, Str::upper($startDate)));
                        $io++;
                    }else {
                        $renderedData->push($getEntity($prevEntity, Str::upper("$startDate - $endDate")));
                        $io++;
                    }

                    $try = 0;
                }

                $startDate = $entity->effective_date->format('M d, Y');
                $endDate = $entity->effective_date->format('M t, Y');

                $renderedData->push($getEntity($entity, Str::upper("$startDate - $endDate")));
            }
        }

        if($try == 1) {
            $startDate = $entity->effective_date->format('M d, Y');

            $renderedData->push($getEntity($entity, Str::upper("$startDate - Present")));
        }

        $renderedData = $renderedData->reverse();

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $postRenderData = $this->paginate($renderedData, $perPage, $page);

        return response($postRenderData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function search($employeeId = null){
        $this->checkUserAccess(auth()->user(), 'search employee schedule');

        if($employeeId === null)
            return $this->returnResponseAllEmployees();

        $this->checkEmployeeId($employeeId);

        return $this->returnSearchSchedule($employeeId);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete employee schedule');

        $this->deleteRecord('EmployeeSchedule', $id);

        return response(null, 204);
    }

    public function mass(){
        $this->checkUserAccess(auth()->user(), 'write employee schedule');

        $employeeIds = collect($this->REQUEST->validate([
            'employeeIds' => 'required|array',
            'employeeIds.*' => 'required|exists:employees,id'
        ])['employeeIds']);

        $employeeIds->map(fn($employeeId) => $this->create($employeeId));

        return response(null, 204);

    }

    public function portalSearch(){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee schedule');

        if(!$employeeId = $user->employee?->id)
            return response('No employee found.', 400);

        return $this->returnSearchSchedule($employeeId);
    }

    public function portalToday(){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee schedule');

        if(!$employeeId = $user->employee?->id)
            return response('No employee found.', 400);

        return response(Employee::getTodaySchedule($employeeId, date('Y-m-d')), 200);
    }

}