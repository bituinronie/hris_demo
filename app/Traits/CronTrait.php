<?php
namespace App\Traits;

use App\Models\Dtr;
use App\Models\Employee;
use Carbon\CarbonPeriod;
use App\Models\LeaveLedger;
use App\Models\SpecialDate;
use Illuminate\Support\Str;
use App\Traits\RequestTrait;
use App\Models\ServiceRecord;
use App\Traits\ConstantTrait;
use Illuminate\Support\Carbon;
use App\Traits\LeaveLedgerTrait;

/**
 * Cron traits
 * 
 * TODO: Payroll Application on monthly leave earning
 */
trait CronTrait
{
    use ConstantTrait, RequestTrait, LeaveLedgerTrait;

    public function generateDtr($employeeId = null, $month = null, $year = null, $refDate = null)
    {
        // init date functions
        $isDate = fn($date) => date('Y-m-d', strtotime($date)) == $date;

        // init month and year
        $month = $month ?? date('m');
        $year = $year ?? date('Y');

        // generating dtr's by refDate (getting month and year by refDate)
        if ($refDate !== null) {
            if ($isDate($refDate)) {
                $parsedRefDate = Carbon::parse($refDate);

                $month = $parsedRefDate->copy()->format('m');
                $year = $parsedRefDate->copy()->format('Y');
            }
        }

        $refDate = "$year-$month-01";

        // init functions
        $generateDtr = function ($employeeId) use ($month, $year) {
            // init dates
            $startDate = Carbon::parse("$year-$month-01");
            $endDate = Carbon::parse("$year-$month-01")->endOfMonth();

            while ($startDate->lte($endDate)) {
                $refDate = $startDate->toDateString();

                Dtr::updateOrCreate([
                    'employee_id' => $employeeId,
                    'ref_date' => $refDate
                ]);

                $startDate->addDay();
            }
        };

        // for specific employee dtr seeding
        if ($employeeId !== null) {
            $employee = Employee::find($employeeId);
            if ($employee === null)
                return null;

            $generateDtr($employeeId);

            return null;
        }

        // for all employee dtr seeding
        // init employee records
        $employees = Employee::all()->filter(function ($item) use ($refDate) {
            return ServiceRecord::getRecord($item->id, $refDate, true);
        })->map(fn($item) => $item->id)->toArray();

        foreach ($employees as $employeeId) {
            $generateDtr($employeeId);
        }

        return null;
    }

    public function requestAutomatic()
    {
        $leaveLedgers = LeaveLedger::whereStatus(1)->get();

        $dateToday = Carbon::now()->format('Y-m-d');

        foreach ($leaveLedgers as $leaveLedger) {
            // getting approver info
            $approvers = $leaveLedger->approverInfo;
            if ($approvers == null)
                continue;

            // post date by updated_at
            $postDate = Carbon::parse($leaveLedger->updated_at)->format('Y-m-d');

            // skiping non leaves categorized request
            if ($leaveLedger->requestCategory != 'leaves')
                continue;


            // getting employee to approve request
            $employeeToApprove = null;
            for ($i = 0; $i < count($leaveLedger->approverStatus); $i++) {
                if ($leaveLedger->approverStatus[$i] == 1) {
                    $employeeToApprove = $approvers[$i]->user->employee;
                    break;
                }
            }

            // if approver has employee
            if ($employeeToApprove) {
                // days to be count
                $dayCount = 0;

                // Iterate over the period from = $postDate to = $dateToday
                $period = CarbonPeriod::create($postDate, $dateToday);
                foreach ($period as $date) {
                    $refDate = $date->format('Y-m-d');

                    // init schedule and special schedule
                    $schedule = Employee::getScheduleByDate($employeeToApprove->id, $refDate);
                    $specialDates = SpecialDate::getForDtr($refDate, $employeeToApprove->groupId);

                    // schedule part of validating day
                    if ($schedule != null) {
                        if ($schedule->workMinutes == null)
                            continue;
                    }
                    else {
                        $dayText = Str::lower($date->format('D'));
                        if (in_array($dayText, $this->dayNotCountedOnAutoApprove))
                            continue;
                    }

                    // Special Dates validating day
                    if (!$specialDates->isEmpty()) {
                        if ($specialDates->has('LEGAL') || $specialDates->has('SPECIAL'))
                            continue;
                    }

                    $dayCount++; // increase days count
                }

                // checking if days count match the request auto approved setting
                if ($dayCount < $this->daysToAutoApprove)
                    continue;
            }

            $approverStatus = $leaveLedger->approverStatus;
            $approverStatus[$i] = 5;
            $leaveLedger->approverStatus = $approverStatus;

            $leaveLedger->save();
        }

        return null;
    }

    public function requestMonthlyEarning($employeeId = null, $month = null, $year = null)
    {
        // creating month year parameter to use
        $month = $month ?? date('m');
        $year = $year ?? date('Y');

        // Init dates required
        $dateFrom = Carbon::parse("$year-$month-01")->subMonth();
        $dateTo = Carbon::parse(
            $dateFrom->copy()->format('Y-m-t')
        );

        //* init function - generate earning
        $generateEarning = function ($employee) use ($dateFrom, $dateTo) {
            // dateFrom and dateTo carbon => formated string
            $dateFrom = $dateFrom->format('Y-m-d');
            $dateTo = $dateTo->format('Y-m-t');

            // reseting leave VL and SL earnings other than MONETIZATION applied to VL and SL
            $employee->leaveLedgers()
                ->whereIn('request_type_id', [1, 2])
                ->whereStatus(7)
                ->where('remarks', 'NOT LIKE', '%MONETIZATION%')
                ->whereDate('from', '>=', $dateFrom)
                ->whereDate('from', '<=', $dateTo)
                ->delete();

            // apply vl deductions on late, ut, halfday differences
            $this->applyVlDeductionBasedOnDtr($employee, $dateFrom, $dateTo);

            // TODO: apply payroll deductions
            // $this->applyPayrollDeductionBasedOnDtr($employee, $dateFrom, $dateTo);

            $balance = $this->getBalance($employee);

            // checking if SL has negative balance
            if ($balance->get('SL') < 0) {

                if (abs($balance->get('SL')) < $balance->get('VL')) { // check if VL has enough to use on negative SL's

                    $this->applyVlDeductionBasedOnNegativeSl($employee, $dateTo, $balance->get('SL'));

                }
                else { // when lack of VL credits to used for Negative SL

                    if ($balance->get('VL') > 0) // check for remaining VL's, then deduct all VL's for Negative SL
                        $this->applyVlDeductionBasedOnNegativeSl($employee, $dateTo, $balance->get('VL'));

                    $this->applySlEarningBasedOnNegativeSl($employee, $dateTo);
                }

                $balance = $this->getBalance($employee);
            }

            // set as default monthly earning
            $earningToApply = $this->monthlyLeaveEarning;

            // checking if VL has negative balance
            if ($balance->get('VL') < 0) {

                if (abs($balance->get('VL')) >= $this->monthlyLeaveEarning) { // check if Negative VL is greater than Monthly VL earnings
                    $this->applyVlEarningBasedOnNegativeVl($employee, $dateTo, $balance->get('VL'));

                    $balance = $this->getBalance($employee);
                }

                // deducting earning to apply on VL and SL
                if ($balance->get('VL') < 0)
                    $earningToApply = $this->monthlyLeaveEarning - $this->leavesPerDay * abs($balance->get('VL'));
            }

            // Applying Monthly VL Earnings
            $this->applyVlEarning($employee, $dateTo, $earningToApply);

            // Applying Monthly SL Earnings
            $this->applySlEarning($employee, $dateTo, $earningToApply);

            // Get new balances
            $balance = $this->getBalance($employee);

            // Resting Mandatory Leave every month
            if ($balance->get('VL') >= 10)
                $this->applyMlEarning($employee, $dateTo);
        };

        // conditioning employeeIds
        if (!$employeeId)
            Employee::all()->filter(fn($item) => $this->isAllowedOnEarning($item))->map(fn($item) => $generateEarning($item));
        else
            Employee::whereId($employeeId)->get()->filter(fn($item) => $this->isAllowedOnEarning($item))->map(fn($item) => $generateEarning($item));

        return null;
    }

    public function requestAnnualEarning($employeeId = null)
    {
        // initial postDate
        $postDate = Carbon::now()->copy()->format('Y-01-01 00:00:00');

        //* init function - generate earning
        $generateEarning = function ($employee) use ($postDate) {
            // SPL Earning
            $this->applySplEarning($employee, $postDate);

            $vlBalance = $this->getBalance($employee,
                Carbon::parse($postDate)
                ->subYear()
                ->format('Y-12-31 00:00:00')
            )->get('VL');

            if ($vlBalance >= 10)
                $this->applyAnnualMlApplication($employee, $postDate);
            else
                $this->removeAnnualMlBalance($employee, $postDate);
        };

        // conditioning employeeIds
        if (!$employeeId)
            Employee::all()->filter(fn($item) => $this->isAllowedOnEarning($item))->map(fn($item) => $generateEarning($item));
        else
            Employee::whereId($employeeId)->get()->filter(fn($item) => $this->isAllowedOnEarning($item))->map(fn($item) => $generateEarning($item));

        return null;
    }
}
