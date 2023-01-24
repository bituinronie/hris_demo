<?php
namespace App\Traits;

use App\Models\Setting;
use App\Models\Employee;
use App\Traits\DtrTrait;
use Carbon\CarbonPeriod;
use App\Models\LeaveLedger;
use App\Models\RequestType;
use Illuminate\Support\Str;
use App\Models\ServiceRecord;
use App\Traits\ConstantTrait;
use App\Notifications\Request;
use Illuminate\Support\Carbon;

/**
 * Leave Ledger Trait
 * 
 * TODO: Payroll application on applySlEarningBasedOnNegativeSl
 * TODO: Payroll application on applyVlEarningBasedOnNegativeVl
 */
trait LeaveLedgerTrait
{
    use DtrTrait, ConstantTrait;

    public $DATE_FORMAT = 'Y-m-d H:i:s';

    public static function initApproverStatus($employee, $category){
        $category = Str::lower($category);


        $approvers = $employee->approver()->select("{$category}_1","{$category}_2","{$category}_3")->first()?->only(["{$category}_1","{$category}_2","{$category}_3"]);
        if(!$approvers)
            return [];

        $approverStatus = [];

        foreach ($approvers as $employeeId) {
            if($employeeId != null)
                $approverStatus[] = 1;
        }

        return $approverStatus;
    }

    public static function isToApprove($employee, $leaveLedger){
        $category = Str::lower($leaveLedger->requestType->category);

        $toApprove = $employee->{$category."ToApprove"};

        $isUnderApprover = in_array(
            $leaveLedger->employee_id,
            $toApprove->getFromColumn('employeeId')->toArray()
        );

        if(!$isUnderApprover) // When request not under approver
            return false;

        $sequence = $toApprove
                            ->where('employeeId', $leaveLedger->employee_id)
                            ->first()
                            ['sequence'];

        if($leaveLedger->status == 2 || $leaveLedger->status == 5) // When request approved
            return true;

        if($sequence == 1) // When approver on first sequence
            return true;

        $index = $sequence - 2; // Subtract 2 for previous approver

        if($leaveLedger->approverStatus[$index] != 2 && $leaveLedger->approverStatus[$index] != 5)
            return false;

        return true;
    }

    public static function getStatingDate($employeeId, $requestTypeId){

        $leaveLedger = LeaveLedger::where('employee_id', $employeeId)
                                ->where('request_type_id', $requestTypeId)
                                ->where('is_start', true)
                                ->orderBy('from', 'DESC')
                                ->first();

        if(!$leaveLedger)
            $leaveLedger = LeaveLedger::where('employee_id', $employeeId)
                                ->where('request_type_id', $requestTypeId)
                                ->orderBy('from', 'ASC')
                                ->first();

        return $leaveLedger?->from ?? Carbon::parse('1970-01-01');
    }

    /**
     * Notify approver based on leaveLedger
     * 
     * @param LeaveLedger leaveLedger
     * 
     * @return boolean isNotified
     */
    public static function notifyApprover($leaveLedger){
        $isNotified = false;

        for ($i = 1; $i <= count($leaveLedger->approverStatus); $i++) {
            $status = $leaveLedger->approverStatus[($i-1)];

            if($status == 3) // check status if status has disapproved
                break;

            if($status == 1) {
                $approverData = Employee::find($leaveLedger->employee_id)->approver;
                $approverData->isShowUser = true;

                $approverInfo = $approverData->{"{$leaveLedger->requestCategory}{$i}Data"};

                // notify
                try {
                    $approverInfo->user->notify(new Request($leaveLedger, $approverInfo));
                } catch (\Throwable $th) {
                    // error message
                    if(env('IS_DEV') == true)
                        dd($th);
                    else
                        abort(400, 'sending email error.');
                }

                $isNotified = true;

                break;
            }
        }

        return $isNotified;
    }

    /**
     * Clear is_start for making is_start show once per request
     * 
     * @param Employee employee
     * @param LeaveLedger leaveLedger
     * 
     * @return void
     */
    public static function clearIsStart($employee, $leaveLedger){
        // init query, get all leaveLedgers w/ is_start true
        $employee->leaveLedgers()
            ->where('id','!=',$leaveLedger->id)
            ->where('request_type_id', $leaveLedger->request_type_id)
            ->where('is_start', true)
            ->update([
                'is_start' => false // false all is_start
            ]);
    }

    public function getApproverIndex($employee, $requestCategory, $employeeIdToApprove) {
        $category = Str::lower($requestCategory);

        return $employee->{$category."ToApprove"}
                    ->where('employeeId', $employeeIdToApprove)
                    ->first()
                    ['sequence']-1;
    }

    public static function applyRelatedRequest($leaveLedger, $isAdmin = false){
        if ($leaveLedger->credit > 0)
            return null;

        // init newLeaveLedger
        $newLeaveLedger = new LeaveLedger;

        switch ($leaveLedger->request_type_id) {
            case 3:
                $newLeaveLedger->employee_id = $leaveLedger->employee_id;
                $newLeaveLedger->request_type_id = 1;
                $newLeaveLedger->from = $leaveLedger->from;
                $newLeaveLedger->to = $leaveLedger->to;
                $newLeaveLedger->credit = $leaveLedger->credit;
                $newLeaveLedger->status = 7;
                $newLeaveLedger->remarks = "DEDUCTED DUE TO ML;";

                break;
            
            case 5:
                $employee = $leaveLedger->employee;

                $period = CarbonPeriod::create($leaveLedger->from, $leaveLedger->to);

                $vlCredit = 0;
                $preCredit = 0;

                foreach ($period as $date) {
                    $refDate = $date->copy()->format('Y-m-d');
                    $schedule = Employee::getScheduleByDate($employee->id, $refDate, true);

                    if(!$schedule)
                        continue;


                    $hr = $schedule->workMinutes / 60;

                    $daysHr = (double) $hr * .125;
                    if($daysHr > 1)
                        $preCredit = $daysHr - 1;

                    $vlCredit  += $preCredit;

                }
               
                $newLeaveLedger = new LeaveLedger;
                $newLeaveLedger->employee_id = $leaveLedger->employee_id;
                $newLeaveLedger->request_type_id = 1;
                $newLeaveLedger->from = $leaveLedger->from;
                $newLeaveLedger->to = $leaveLedger->to;
                $newLeaveLedger->credit = -$vlCredit;
                $newLeaveLedger->status = 7;
                $newLeaveLedger->remarks = "DEDUCTED DUE TO SPL;";
                break;
            
            case 14:
                $newLeaveLedger = new LeaveLedger;
                $newLeaveLedger->employee_id = $leaveLedger->employee_id;
                $newLeaveLedger->request_type_id = 1;
                $newLeaveLedger->from = $leaveLedger->from;
                $newLeaveLedger->to = $leaveLedger->to;
                $newLeaveLedger->credit = -$leaveLedger->credit;
                $newLeaveLedger->status = 7;
                $newLeaveLedger->remarks = "DEDUCTED DUE TO MONETIZATION;";
                break;
            case 17:
                $newLeaveLedger = new LeaveLedger;
                $newLeaveLedger->employee_id = $leaveLedger->employee_id;
                $newLeaveLedger->request_type_id = 2;
                $newLeaveLedger->from = $leaveLedger->from;
                $newLeaveLedger->to = $leaveLedger->to;
                $newLeaveLedger->credit = -$leaveLedger->credit;
                $newLeaveLedger->status = 7;
                $newLeaveLedger->remarks = "DEDUCTED DUE TO MONETIZATION;";
                break;
            case 19:
                $newLeaveLedger = new LeaveLedger;
                $newLeaveLedger->employee_id = $leaveLedger->employee_id;
                $newLeaveLedger->request_type_id = 18;
                $newLeaveLedger->from = $leaveLedger->from;
                $newLeaveLedger->to = $leaveLedger->to;
                $newLeaveLedger->credit = $leaveLedger->credit;
                $newLeaveLedger->status = 7;
                $newLeaveLedger->remarks = "EARNED DUE TO OVERTIME COMPENSATORY TIME-OFF;";
                break;
        }

        //condition before saving
        if($newLeaveLedger?->request_type_id)
            $newLeaveLedger->save();

        return null;
    }

    public static function cancelRelatedRequest($leaveLedger){
        if ($leaveLedger->status != 4)
            return null;

        switch ($leaveLedger->request_type_id) {
           
            case 3:
                $newLeaveLedger = new LeaveLedger;
                $newLeaveLedger->employee_id = $leaveLedger->employee_id;
                $newLeaveLedger->request_type_id = 1;
                $newLeaveLedger->from = $leaveLedger->from;
                $newLeaveLedger->to = $leaveLedger->to;
                $newLeaveLedger->credit = abs($leaveLedger->credit);
                $newLeaveLedger->status = 7;
                $newLeaveLedger->remarks = "ADDED DUE TO CANCELLED ML REQUEST;";
                $newLeaveLedger->save();

                $newLeaveLedger = new LeaveLedger;
                $newLeaveLedger->employee_id = $leaveLedger->employee_id;
                $newLeaveLedger->request_type_id = 3;
                $newLeaveLedger->from = $leaveLedger->from;
                $newLeaveLedger->to = $leaveLedger->to;
                $newLeaveLedger->credit = abs($leaveLedger->credit);
                $newLeaveLedger->status = 7;
                $newLeaveLedger->remarks = "ADDED DUE TO CANCELLED ML REQUEST;";
                $newLeaveLedger->save();

                break;
            case 5:
                $employee = $leaveLedger->employee;

                $period = CarbonPeriod::create($leaveLedger->from, $leaveLedger->to);

                $vlCredit = 0;
                $preCredit = 0;

                foreach ($period as $date) {
                    $refDate = $date->copy()->format('Y-m-d');
                    $schedule = Employee::getScheduleByDate($employee->id, $refDate, true);

                    if(!$schedule)
                        continue;


                    $hr = $schedule->workMinutes / 60;

                    $daysHr = (double) $hr * .125;
                    if($daysHr > 1)
                        $preCredit = $daysHr - 1;

                    $vlCredit  += $preCredit;

                }

                $newLeaveLedger = new LeaveLedger;
                $newLeaveLedger->employee_id = $leaveLedger->employee_id;
                $newLeaveLedger->request_type_id = 1;
                $newLeaveLedger->from = $leaveLedger->from;
                $newLeaveLedger->to = $leaveLedger->to;
                $newLeaveLedger->credit = $vlCredit;
                $newLeaveLedger->status = 7;
                $newLeaveLedger->remarks = "ADDED DUE TO CANCELLED SPL REQUEST;";
                $newLeaveLedger->save();

                break;
            case 14:
                $newLeaveLedger = new LeaveLedger;
                $newLeaveLedger->employee_id = $leaveLedger->employee_id;
                $newLeaveLedger->request_type_id = 1;
                $newLeaveLedger->from = $leaveLedger->from;
                $newLeaveLedger->to = $leaveLedger->to;
                $newLeaveLedger->credit = abs($leaveLedger->credit);
                $newLeaveLedger->status = 7;
                $newLeaveLedger->remarks = "ADDED DUE TO CANCELLED MONETIZATION;";
                $newLeaveLedger->save();
                break;
            case 17:
                $newLeaveLedger = new LeaveLedger;
                $newLeaveLedger->employee_id = $leaveLedger->employee_id;
                $newLeaveLedger->request_type_id = 2;
                $newLeaveLedger->from = $leaveLedger->from;
                $newLeaveLedger->to = $leaveLedger->to;
                $newLeaveLedger->credit = abs($leaveLedger->credit);
                $newLeaveLedger->status = 7;
                $newLeaveLedger->remarks = "ADDED DUE TO CANCELLED MONETIZATION;";
                $newLeaveLedger->save();
                break;
            // TODO: on COC and CTO cancellation
            // case 19:
            //     $newLeaveLedger = new LeaveLedger;
            //     $newLeaveLedger->employee_id = $leaveLedger->employee_id;
            //     $newLeaveLedger->request_type_id = 18;
            //     $newLeaveLedger->from = $leaveLedger->from;
            //     $newLeaveLedger->to = $leaveLedger->to;
            //     $newLeaveLedger->credit = $leaveLedger->credit;
            //     $newLeaveLedger->status = 7;
            //     $newLeaveLedger->remarks = "EARNED DUE TO OVERTIME COMPENSATORY TIME-OFF;";
            //     break;
        }

        return null;
    }

    /**
     * getting from based on schedule
     * 
     * @param Employee employee 
     * @param Date refDate
     * @param AM|PM halfDay 
     */
    public function getFrom($employee, $refDate, $halfDay = null) {
        $schedule = Employee::getScheduleByDate($employee->id, $refDate, true); // true => to strictly check sched
        if(!$schedule)
            return null;

        $template = (object) collect($this->timeKeepingTypes)->mapWithKeys(function($type) use($schedule, $refDate) {
            return [$type => $this->generateTemplate($type, $schedule, $refDate)];
        })->toArray();

        return match($halfDay) {
            'AM' => $template->time_in->format($this->DATE_FORMAT),
            'PM' => $template->lunch_in ? $template->lunch_in->format($this->DATE_FORMAT) : $template->time_in->format($this->DATE_FORMAT),
            null => $template->time_in->format($this->DATE_FORMAT),
            default => null
        };
    }

    /**
     * getting to based on schedule
     * 
     * @param Employee employee 
     * @param Date refDate
     * @param AM|PM halfDay 
     */
    public function getTo($employee, $refDate, $halfDay = null) {
        $schedule = Employee::getScheduleByDate($employee->id, $refDate, true); // true => to strictly check sched
        if(!$schedule)
            return null;

        $template = (object) collect($this->timeKeepingTypes)->mapWithKeys(function($type) use($schedule, $refDate) {
            return [$type => $this->generateTemplate($type, $schedule, $refDate)];
        })->toArray();

        if($halfDay) {
            if(!$schedule->hasLunch) {
                // TODO
                // get mid day of timeIn and timeOut
                // get work hours between timeIn and timeOut
                // divide 2 and add hours timeIn
                // return mid day
            }else {
                return match($halfDay) {
                    'AM' => $template->lunch_out->format($this->DATE_FORMAT),
                    'PM' => $template->time_out->format($this->DATE_FORMAT),
                    default => null
                };
            }
        }

        return $template->time_out->format($this->DATE_FORMAT);
    }

    //*******************************
    //* Use for Earning

    public function generateCreatedAt(){
        return Carbon::now()->format('Y-m-d 00:00:00');
    }

    public function isAllowedOnEarning($employee){
        $serviceRecord = ServiceRecord::getRecord($employee->id);
        if(!$serviceRecord)
            return false;

        if ( in_array($serviceRecord->employment_status_id, $this->employmentStatusNotAllowedToEarn) ||
                in_array($serviceRecord->remark_id, $this->remarkIdNotApplied)
            )
                return false;

        return true;
    }

    // parse credit before passing to database credit
    // NOTE: can be change
    public function passToCredit($credit){
        return round($credit, 3);
    }

    public function getCreditBasedOnPayroll($credit){
        $creditedBalance = 0;

        // any whole number pass creditBalance
        $creditedBalance = (int) abs($credit);

        // get the decimal values
        $decimalCredit = abs($credit) - $creditedBalance;

        // any greater than .5, wont applied to creditBalance
        if($decimalCredit >= $this->leaveDivisibleBy)
            $creditedBalance += .5;

        return $creditedBalance;
    }

    public function getMlCredit($employee, $year = null){
        if (!$year)
            $year = date('Y');

        // Init Annual ML
        $annualML = Setting::annualMandatoryLeave();

        // sum of approved VL and ML
        $approvedVL = $employee
                        ->leaveLedgers()
                        ->where('request_type_id', 1)
                        ->whereIn('status', [2,6,5])
                        ->whereYear('from', $year)
                        ->where('credit', '<', 0)
                        ->where('remarks', 'NOT LIKE', 'DEDUCTED%')
                        ->where('remarks', 'NOT LIKE', 'SYNCHRONIZATION%')
                        ->sum('credit');

        $approvedML = $employee
                        ->leaveLedgers()
                        ->where('request_type_id', 3)
                        ->whereIn('status', [2,6,5,3])
                        ->whereYear('from', $year)
                        ->where('credit', '<', 0)
                        ->sum('credit');

        $approvedVLML = $approvedVL + $approvedML;

        return $annualML + $approvedVLML;
    }

    public function applyVlDeductionBasedOnDtr($employee, $dateFrom, $dateTo){
        // query
        $dtr = $employee->dtrs()
                    ->whereBetween('ref_date', [$dateFrom, $dateTo])
                    ->get();

        // logic
        $dtr->filter(function($item) {
            $item->showStats = true;
            $stats = $item->parseDtr->get('stats');

            if($stats->diff)
                return true;

            return false;
        })->map(function($item) use ($employee) {
            $createdAt = $this->generateCreatedAt();

            $item->showStats = true;
            $stats = $item->parseDtr->get('stats');

            // init parameters
            $from = $item->time_in != null ? $item->time_in->format('Y-m-d H:i:s') : $item->ref_date->format('Y-m-d 00:00:00');
            $to = $item->tim_out != null ? $item->tim_out->format('Y-m-d H:i:s') : $item->ref_date->format('Y-m-d 00:00:00');

            $credit = -$this->passToCredit($stats->diffToDays());
            $remarks = "DEDUCTED DUE TO {$stats->remark}";

            // create VL deduction
            LeaveLedger::firstOrCreate([
                'employee_id' => $employee->id,
                'from' => $from,
                'to' => $to,
                'request_type_id' => 1, // VL request type
                'status' => 7 // System Generated
            ],[
                'credit' => $credit,
                'remarks' => $remarks,
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ]);
        });
    }

    public function applyVlDeductionBasedOnNegativeSl($employee, $postDate, $credit = null){
        // get SL balance if no credit passed
        if($credit === null) {
            $credit = $this->getBalance($employee)->get('SL');

            if($credit >= 0)
                return null;
        }

        // checking if SL balance is absolute credit
        if($credit >= 0)
            $credit = -$credit;

        // init params
        $date = Carbon::parse($postDate)->format('Y-m-d 23:59:59');
        $createdAt = $this->generateCreatedAt();

        // Apply VL Deduction
        LeaveLedger::updateOrCreate([
            'employee_id' => $employee->id,
            'from' => $date,
            'to' => $date,
            'request_type_id' => 1, // VL request type
            'status' => 7, // System Generated
            'remarks' => 'DEDUCTION DUE TO SICK LEAVE;', //* Hard Coded
        ],[
            'credit' => $this->passToCredit($credit),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ]);

        // Apply  SL Earning due to deductiion to VL
        // Apply VL Deduction
        LeaveLedger::updateOrCreate([
            'employee_id' => $employee->id,
            'from' => $date,
            'to' => $date,
            'request_type_id' => 2, // VL request type
            'status' => 7, // System Generated
            'remarks' => 'EARNED BUT DEDUCTED TO VL;', //* Hard Coded
        ],[
            'credit' => $this->passToCredit(abs($credit)), // negative => positve
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ]);
    }

    public function applySlEarningBasedOnNegativeSl($employee, $postDate, $credit = null){
        // get SL balance if no credit passed
        if($credit === null)
            $credit = $this->getBalance($employee)->get('SL');

        // checking if SL balance is absolute credit
        if($credit >= 0)
            return null;

        // init params
        $credit = $this->getCreditBasedOnPayroll($credit); // geting new credit based on payroll application credit rule
        $date = Carbon::parse($postDate)->format('Y-m-d 23:59:59');
        $createdAt = $this->generateCreatedAt();

        // Apply SL Earning
        LeaveLedger::updateOrCreate([
            'employee_id' => $employee->id,
            'from' => $date,
            'to' => $date,
            'request_type_id' => 2, // SL request type
            'status' => 7, // System Generated
            'remarks' => 'EARNED BUT DEDUCTED TO PAYROLL;', //* Hard Coded
        ],[
            'credit' => $this->passToCredit($credit),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ]);

        // TODO: Apply Payroll Deduction
        // $this->applyPayrollDeduction($employee, $applyDate, $credit);
    }

    public function applyVlEarningBasedOnNegativeVl($employee, $postDate, $credit = null){
        // get VL balance if no credit passed
        if($credit === null)
            $credit = $this->getBalance($employee)->get('VL');

        // checking if VL balance is absolute credit
        if($credit >= 0)
            return null;

        // init params
        // $credit = $this->getCreditBasedOnPayroll($credit); // geting new credit based on payroll application credit rule
        $credit = abs(round($credit));
        $date = Carbon::parse($postDate)->format('Y-m-d 23:59:59');
        $createdAt = $this->generateCreatedAt();

        // Apply VL Earning
        LeaveLedger::updateOrCreate([
            'employee_id' => $employee->id,
            'from' => $date,
            'to' => $date,
            'request_type_id' => 1, // VL request type
            'status' => 7, // System Generated
            'remarks' => 'EARNED BUT DEDUCTED TO PAYROLL;', //* Hard Coded
        ],[
            'credit' => $this->passToCredit($credit),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ]);

        // TODO: Apply Payroll Deduction
        // $this->applyPayrollDeduction($employee, $applyDate, $credit);
    }

    public function applyVlEarning($employee, $postDate, $credit = null){
        // get monthly credit balance
        if($credit === null)
            $credit = $this->monthlyLeaveEarning;

        // init params
        $date = Carbon::parse($postDate)->format('Y-m-d 23:59:59');
        $createdAt = $this->generateCreatedAt();

        // Apply VL Earning
        LeaveLedger::updateOrCreate([
            'employee_id' => $employee->id,
            'from' => $date,
            'to' => $date,
            'request_type_id' => 1, // VL request type
            'status' => 7, // System Generated
            'remarks' => 'EARNED VACATION LEAVE;', //* Hard Coded
        ],[
            'credit' => $this->passToCredit($credit),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ]);
    }

    public function applySlEarning($employee, $postDate, $credit = null){
        // get monthly credit balance
        if($credit === null)
            $credit = $this->monthlyLeaveEarning;

        // init params
        $date = Carbon::parse($postDate)->format('Y-m-d 23:59:59');
        $createdAt = $this->generateCreatedAt();

        // Apply VL Earning
        LeaveLedger::updateOrCreate([
            'employee_id' => $employee->id,
            'from' => $date,
            'to' => $date,
            'request_type_id' => 2, // SL request type
            'status' => 7, // System Generated
            'remarks' => 'EARNED SICK LEAVE;', //* Hard Coded
        ],[
            'credit' => $this->passToCredit($credit),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ]);
    }

    public function applyMlEarning($employee, $postDate){
        $annualML = Setting::annualMandatoryLeave();

        $credit = $this->getMlCredit($employee);

        if($credit > 0) {
            $date = Carbon::parse($postDate)->format('Y-m-d 23:59:59');
            $createdAt = $this->generateCreatedAt();

            // Apply ML Earning
            LeaveLedger::updateOrCreate([
                'employee_id' => $employee->id,
                'request_type_id' => 3, // ML request type
                'status' => 7, // System Generated
                'remarks' => 'FORCE LEAVE BALANCE;', //* Hard Coded
            ],[
                'from' => $date,
                'to' => $date,
                'is_start' => true,
                'credit' => $this->passToCredit( min($credit, $annualML) ),
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ]);
        }else {
            $this->removeMlBalance($employee);
        }
    }

    public function applyAnnualMlApplication($employee, $postDate){
        $mlCreditYear = Carbon::parse($postDate)->subYear()->format('Y');

        $credit = $this->getMlCredit($employee, $mlCreditYear);

        if($credit > 0) {
            $createdAt = $this->generateCreatedAt();

            // Apply ML Deduction
            LeaveLedger::updateOrCreate([
                'employee_id' => $employee->id,
                'from' => $postDate,
                'to' => $postDate,
                'request_type_id' => 3, // ML request type
                'status' => 7, // System Generated
                'remarks' => 'DEDUCTION DUE TO UNUSED FL;', //* Hard Coded
            ],[
                'credit' => -$credit,
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ]);

            // Apply VL Deduction
            LeaveLedger::updateOrCreate([
                'employee_id' => $employee->id,
                'from' => $postDate,
                'to' => $postDate,
                'request_type_id' => 1, // VL request type
                'status' => 7, // System Generated
                'remarks' => 'DEDUCTION DUE TO UNUSED FL;', //* Hard Coded
            ],[
                'credit' => -$credit,
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ]);
        }else {
            $this->removeAnnualMlBalance($employee, $postDate);
        }
    }

    public function applySplEarning($employee, $postDate){
        // Init Annual SPL
        $annualSpl = Setting::annualSpecialLeave();

        // Apply SPL Earning
        LeaveLedger::updateOrCreate([
            'employee_id' => $employee->id,
            'from' => $postDate,
            'to' => $postDate,
            'request_type_id' => 5, // SPL request type
            'status' => 7, // System Generated
            'remarks' => 'SPECIAL LEAVE BALANCE;', //* Hard Coded
            'is_start' => true
        ],[
            'credit' => $annualSpl,
            'created_at' => $this->generateCreatedAt(),
            'updated_at' => $this->generateCreatedAt()
        ]);
    }

    public function removeAnnualMlBalance($employee, $postDate){
        $whereData = [
            ['employee_id', $employee->id],
            ['from', $postDate],
            ['to', $postDate],
            ['status', 7],
            ['remarks','DEDUCTION DUE TO UNUSED FL;']
        ];

        LeaveLedger::where($whereData)->where('request_type_id',3)->delete(); // ML
        LeaveLedger::where($whereData)->where('request_type_id',1)->delete(); //VL
    }

    public function removeMlBalance($employee){
        $employee->leaveLedgers()->where('request_type_id', 3)->where('status', 7)->where('remarks', 'FORCE LEAVE BALANCE;')->delete();
    }
}
