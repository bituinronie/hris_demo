<?php
namespace App\Traits\Reports;

use Mpdf\Mpdf;
use NumberFormatter;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Position;
use App\Models\LeaveLedger;
use Illuminate\Support\Str;
use App\Traits\RequestTrait;
use App\Models\ServiceRecord;
use Illuminate\Support\Carbon;
use App\Classes\Reports\SelfServiceTemplate;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

/**
 * SelfService
 */
trait SelfService
{
    use RequestTrait;

    public $LAF_SETTING = [
        'format' => 'A4',
        'margin_left' => 6,
        'margin_right' => 6,
        'margin_top' => 2,
        'margin_bottom' => 2
    ];

    public $LL_SETTING = [
        'format' => [215.9,279.4],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    public $LB_SETTING = [
        'format' => [215.9, 279.4],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    public $CLC_SETTING = [
        'format' => [215.9,279.4],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 7,
        'margin_bottom' => 8
    ];

    public $CWP_SETTING = [
        'format' => [215.9,279.4],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];
    
    public $SR_SETTING = [
        'format' => [215.9,279.4],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    public $MONETIZATION_SETTING = [
        'format' => [215.9,279.4],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    public $SUMMARY_REQUEST_SETTING = [
        'format' => [279.4,215.9],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    public $SUMMARY_RENDER_OT_SETTING = [
        'format' => [279.4, 215.9],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    public $SUMMARY_NIGHT_DIFFERENTIAL_SETTING = [
        'format' => [215.9,279.4],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    public $SUMMARY_NEGATIVE_LEAVE_SETTING = [
        'format' => [279.4, 215.9],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    public $ANNUAL_UNUSED_LEAVE_SETTING = [
        'format' => [215.9,279.4],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 8
    ];

    public function checkLeaveLedgerId($leaveLedgerId){
        return LeaveLedger::find($leaveLedgerId) ? true : false;
    }

    public function checkEmployeeId($employeeId){
        return Employee::find($employeeId) ? true : false;
    }

    public function checkDivisionId($divisionId){
        return Division::find($divisionId) ? true : false;
    }

    public function leaveApplicationForm($leaveLedgerId){
        $data = $this->leaveApplicationFormData($leaveLedgerId);

        $report = new Mpdf($this->LAF_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->laf($data));

        return $report;
    }

    public function leaveApplicationFormData($leaveLedgerId){
        $data = array();

        $leaveLedger = LeaveLedger::find($leaveLedgerId);

        $employee = $leaveLedger->employee;

        $serviceRecord = ServiceRecord::getRecord($employee->id, $leaveLedger->created_at);

        $data['info']['office'] = $serviceRecord->place_of_work;
        $data['info']['firstName'] = $employee->first_name;
        $data['info']['lastName'] = $employee->last_name;
        $data['info']['middleName'] = trim($employee->middle_name.' '.$employee->name_extension,' ');
        $data['info']['dateOfFiling'] = Carbon::parse($leaveLedger->created_at)->format('F d, Y h:i A');
        $data['info']['position'] = $serviceRecord->positionName;
        $data['info']['salary'] = $serviceRecord->salaryOnPrint;

        $typesOfLeave = collect([
            1,2,3,5,6,7,8,10,12,11,13,21,22,23
        ]);

        $data['details']['type'] = $typesOfLeave->mapWithKeys(function($item) use ($leaveLedger) {
            return [$item => $leaveLedger->request_type_id == $item?'X':null];
        })->toArray();

        $data['details']['others'] = in_array($leaveLedger->request_type_id, $typesOfLeave->toArray()) ? null : $leaveLedger->requestType->name;

        $data['details']['numberOfWorkingDays'] = $leaveLedger->workingDays.' '.$leaveLedger > 1?'Days':'Day';
        $data['details']['inclusiveDates'] = $leaveLedger->from->format('F d, Y') == $leaveLedger->to->format('F d, Y')?$leaveLedger->from->format('F d, Y'):($leaveLedger->from->format('F d, Y'). ' to ' . $leaveLedger->to->format('F d, Y'));
        $data['details']['commutation'] = [
            'notRequested' => $leaveLedger->status == 6 ? 'X':null,
            'requested' => $leaveLedger->status != 6 ? 'X':null
        ];

        $data['details']['certification']['asOf'] = Carbon::now()->format('F d, Y');

        $balance = $this->getBalance($employee);

        $earnedVl = $balance->get('VL');
        if ($leaveLedger->status == 2 || $leaveLedger->status == 6)
            $earnedVl += $leaveLedger->deductedToVl;

        $earnedSl = $balance->get('SL');
        if ($leaveLedger->status == 2 || $leaveLedger->status == 6)
            $earnedSl += $leaveLedger->deductedToSl;

        $data['details']['certification']['earned'] = [
            'vl' => $earnedVl,
            'sl' => $earnedSl,
        ];

        $data['details']['certification']['less'] = [
            'vl' => $leaveLedger->deductedToVl,
            'sl' => $leaveLedger->deductedToSl,
        ];

        $balanceVl = $balance->get('VL');
        if (in_array($leaveLedger->status, [1,3,4]))
            $balanceVl -= $leaveLedger->deductedToVl;

        $balanceSl = $balance->get('SL');
        if (in_array($leaveLedger->status, [1,3,4]))
            $balanceSl -= $leaveLedger->deductedToSl;

        $data['details']['certification']['balance'] = [
            'vl' => $balanceVl,
            'sl' => $balanceSl,
        ];

        $data['details']['recommendations']['approval'] = in_array($leaveLedger->status, [2,6]) ? 'X':null;
        $data['details']['recommendations']['disapproval'] = $leaveLedger->status == 3?'X':null;
        $data['details']['recommendations']['dueTo'] = $leaveLedger->status == 3?$leaveLedger->remarks:null;

        $data['daysWithPay'] = $leaveLedger->workingDays;
        $data['reason'] = $leaveLedger->status == 3?$leaveLedger->remarks:null;

        return json_decode(json_encode($data), FALSE);

    }

    public function leaveLedger($employeeId, $preparedBy = null, $certifiedBy = null, $position2 = null, $division2 = null){
        $data = $this->leaveLedgerData($employeeId);
        $data->preparedBy = $preparedBy ?? '';
        $data->certifiedBy = $certifiedBy ?? '';
        $data->position2 = $position2 ?? '';
        $data->division2 = $division2 ?? '';

        $report = new Mpdf($this->LL_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->ll($data));

        return $report;
    }

    public function leaveLedgerData($employeeId){
        $data = [];

        $employee = Employee::find($employeeId);
        $serviceRecord = ServiceRecord::getRecord($employee->id);

        $data['name'] = $employee->name;
        $data['position'] = $serviceRecord->positionName;
        $data['office'] = $serviceRecord->place_of_work;

        $leaveledgers = $employee->leaveLedgers()->orderBy('from')->get()->filter(fn($item) => $item->isCounted);

        $first = 1;
        $vl_balance = 0;
        $sl_balance = 0;

        $leaveLedger = array();

        foreach ($leaveledgers as $leaveData) {

            $date_index = $leaveData->from->format('d-M-Y');
            $date_from = $leaveData->from->format('d-M-Y');
            $date_to = $leaveData->to->format('d-M-Y');

            if ($date_from==$date_to)
                $date_to = '';

            $requesttype = $leaveData->requestType->code;
            $request_id = $leaveData->request_type_id;


            $remarks = $leaveData->remarks;

            if(in_array($leaveData->status, [2,5,6,7])) {

                if ($request_id!=1 || $request_id!=2) {

                    if ($first==1) {
                        $data['first_day_entitlements'] = $date_from;
                        $first++;
                    }

                    if ($request_id==1) {
                        if (strpos($remarks,'BALANCE')!==false) {
                            $vl_balance+=$leaveData['credit'];
                        } elseif (strpos($remarks,'EARNED VACATION LEAVE;')!==false) {
                            $leaveLedger[$date_index]['earnings']['vl_earned'] = $leaveData['credit'];
                            $vl_balance+=$leaveData['credit'];
                            $leaveLedger[$date_index]['earnings']['vl_balance'] = $vl_balance;
                        } elseif ((strpos($remarks, 'LATE') !== false) || (strpos($remarks, 'HALFDAY') !== false) || (strpos($remarks, 'UNDERTIME') !== false)) {
                            $leaveLedger[$date_index][$requesttype]['with_pay'] = $leaveData['credit'];
                            $vl_balance+=$leaveData['credit'];
                            $leaveLedger[$date_index][$requesttype]['vl_balance'] = $vl_balance;
                            $leaveLedger[$date_index][$requesttype]['date_action'] = "LATE/UT/HALFDAY";
                        } elseif (strpos($remarks,'EARNED BUT DEDUCTED TO PAYROLL;')!==false) {
                            $leaveLedger[$date_index]['earnings']['vl_without_pay'] = $leaveData['credit'];
                            $vl_balance+=$leaveData['credit'];
                            $leaveLedger[$date_index]['earnings']['vl_balance'] = $vl_balance;
                        } else {
                            $leaveLedger[$date_index][$requesttype]['with_pay'] = $leaveData['credit'];
                            $vl_balance+=$leaveData['credit'];
                            $leaveLedger[$date_index][$requesttype]['vl_balance'] = $vl_balance;
                            $leaveLedger[$date_index][$requesttype]['date_action'] = $date_from . ($date_to==''?'':'-' . $date_to);
                        }
                    } elseif($request_id==2) {
                        if (strpos($remarks,'BALANCE')!==false) {
                            $sl_balance+=$leaveData['credit'];
                        }elseif (strpos($remarks,'EARNED SICK LEAVE;')!==false) {
                            $leaveLedger[$date_index]['earnings']['sl_earned'] = $leaveData['credit'];
                            $sl_balance+=$leaveData['credit'];
                            $leaveLedger[$date_index]['earnings']['sl_balance'] = $sl_balance;
                        } elseif (strpos($remarks,'EARNED BUT DEDUCTED TO VL;') !== false) {
                            $leaveLedger[$date_index][$requesttype]['with_pay'] = $leaveData['credit'];
                            $sl_balance+=$leaveData['credit'];
                            $leaveLedger[$date_index][$requesttype]['sl_balance'] = $sl_balance;
                            $leaveLedger[$date_index][$requesttype]['date_action'] = "Negative SL";
                        } elseif (strpos($remarks,'EARNED BUT DEDUCTED TO PAYROLL;')!==false) {
                            $leaveLedger[$date_index]['earnings']['sl_without_pay'] = $leaveData['credit'];
                            $sl_balance+=$leaveData['credit'];
                            $leaveLedger[$date_index]['earnings']['sl_balance'] = $sl_balance;
                        } else {
                            $leaveLedger[$date_index][$requesttype]['with_pay'] = $leaveData['credit'];
                            $sl_balance+=$leaveData['credit'];
                            $leaveLedger[$date_index][$requesttype]['sl_balance'] = $sl_balance;
                            $leaveLedger[$date_index][$requesttype]['date_action'] = $date_from . ($date_to==''?'':'-' . $date_to);
                        }
                    }
                } else {
                    if (!(strpos($remarks,'BALANCE')!==false || strpos($remarks,'RESET')!==false)) {
                        $leaveLedger[$date_index][$requesttype]['date_action'] = $date_from . ($date_to==''?'':'-' . $date_to);
                    }
                }
            }
        }

        $data['total_vl_balance'] = $vl_balance;
        $data['total_sl_balance'] = $sl_balance;
        $data['total'] = $vl_balance + $sl_balance;
        $data['leave_ledger'] = $leaveLedger;

        return (object) $data;
    }

    public function leaveBalance($division, $refDate = null, $from = null, $employee = null, $employeePosition = null, $employeeDivision = null, $supervisor = null, $supervisorDivision = null){

        $data = $this->leaveBalanceData($division, $refDate);

        $data->from = Str::upper($from);

        $data->employee = $employee;
        $data->employeePosition = $employeePosition;
        $data->employeeDivision = $employeeDivision;
        $data->supervisor = $supervisor;
        $data->supervisorDivision = $supervisorDivision;

        $report = new Mpdf($this->LB_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->lb($data));

        return $report;
    }

    public function leaveBalanceData($divisionId, $refDate = null){
        $data = [];

        $positions = Position::where('division_id',$divisionId)->get();

        foreach ($positions as $position) {
            $sr = ServiceRecord::where('position_id',$position->id)->whereNull('date_to')->whereNull('date_seperation')->first();

            if (!is_null($sr)) {

                $employee = $sr->employee;

                $balance = $this->getBalance($employee, $refDate);
                $vlBalance = $balance->get('VL');
                $slBalance = $balance->get('SL');

                $data[] = (object) [
                    'fullname' => $employee->nameLastNameFirst,
                    'vl_balance' => number_format($vlBalance, 3),
                    'sl_balance' => number_format($slBalance, 3),
                    'total' => number_format($vlBalance + $slBalance, 3)
                ];

            }
        }

        $returnData = [];
        $returnData['items'] = collect($data)->sortBy('fullname')->toArray();
        $returnData['divisionName'] = Str::upper(Division::find($divisionId)->name);
        $returnData['asOf'] = ($refDate?Carbon::parse($refDate):Carbon::now())->format('d F Y');

        return (object) $returnData;
    }

    public function certificationOfLeaveCredits($employeeIds, $refDate = null, $prepared = null, $preparedPosition = null, $preparedDivision = null, $verified = null, $verifiedPosition = null, $verifiedDivision = null){
        $data = $this->certificationOfLeaveCreditsData($employeeIds, $refDate);

        $data->asOf = ($refDate?Carbon::parse($refDate):Carbon::now())->format('d F Y');
        $data->prepared = $prepared;
        $data->preparedPosition = $preparedPosition;
        $data->preparedDivision = $preparedDivision;
        $data->verified = $verified;
        $data->verifiedPosition = $verifiedPosition;
        $data->verifiedDivision = $verifiedDivision;

        $report = new Mpdf($this->CLC_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->clc($data));

        return $report;
    }

    public function certificationOfLeaveCreditsData($employeeIds, $refDate = null){
        $data = [];

        $data['items'] = Employee::find($employeeIds)->map(function($item) use ($refDate) {
            $balance = $this->getBalance($item, $refDate);

            $vlBalance = $balance->get('VL');
            $slBalance = $balance->get('SL');
            $total = ($vlBalance + $slBalance);

            $record = ServiceRecord::getRecord($item->id, $refDate, true);

            $basicPay = $record?->salary ?? 0;

            $totalAmount = round($total * $basicPay * $this->commonFactor, 2);

            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $whole = (int)$totalAmount;
            $centavos = (int) (round($totalAmount - $whole, 2) * 100);

            $totalAmountWord = Str::upper(str_replace("-"," ","{$f->format($whole)} PESOS AND {$f->format($centavos)} CENTAVOS"));

            return (object) [
              'employee_name' => Str::upper($item->statusTitle)." ".ucwords(Str::lower($item->name)),
              'employee_position' => $item->designationName,
              'vl_balance' => number_format($vlBalance, 2),
              'sl_balance' => number_format($slBalance, 2),
              'vl_sl_total' => number_format( $total, 2),
              'basicPay' => "Php{$record->salaryOnPrint}mo",
              'commonFactor' => $this->commonFactor,
              'totalAmount' => "Php ".number_format($totalAmount,2,'.',','),
              'totalAmountWord' => $totalAmountWord,
            ];
        })->toArray();

        return (object)$data;
    }

    public function certificationOfLeaveWithoutPay($employeeIds, $dateFrom = null, $dateTo = null, $supervisor = null, $supervisorPosition = null, $supervisorDivision = null){
        if (!$dateFrom)
            $dateFrom = date('Y-m-01');

        if (!$dateTo)
            $dateTo = date('Y-m-t');

        $data = $this->certificationOfLeaveWithoutPayData($employeeIds, $dateFrom, $dateTo);

        $data->dateFrom = Carbon::parse($dateFrom)->format('F d, Y');
        $data->dateTo = Carbon::parse($dateTo)->format('F d, Y');

        $data->supervisor = $supervisor;
        $data->supervisorPosition = $supervisorPosition;
        $data->supervisorDivision = $supervisorDivision;

        $report = new Mpdf($this->CWP_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->cwp($data));

        return $report;
    }

    public function certificationOfLeaveWithoutPayData($employeeIds, $dateFrom, $dateTo){
        $data = [];

        $data['items'] = Employee::find($employeeIds)->map(function($item) use ($dateFrom, $dateTo) {
            $count = $item->leaveLedgers()
                                ->whereRaw('UPPER(remarks) LIKE (?)','%EARNED BUT DEDUCTED TO PAYROLL%')
                                ->whereBetween('from',[$dateFrom, $dateTo])
                                ->count();

            return (object) [
                'employee_name' => Str::upper($item->name),
                'employee_position' => $item->designationName,
                'requestor' => "{$item->statusTitle} {$item->last_name}",
                'withoutPay' => $count
            ];
        })->toArray();

        return (object)$data;
    }

    public function salaryDeductionPayroll($month = null, $year = null, $from = null, $for = null, $forPosition = null, $forDivision = null, $signed = null, $signedDivision = null){
        if (!$month)
            $month = date('m');

        if (!$year)
            $year = date('Y');

        $data = $this->salaryDeductionPayrollData($month, $year);

        $data->from = Str::upper($from);

        $data->for = Str::upper($for);
        $data->forPosition = Str::upper($forPosition);
        $data->forDivision = Str::upper($forDivision);

        $data->signed = Str::upper($signed);
        $data->signedDivision = Str::upper($signedDivision);

        $report = new Mpdf($this->SR_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->sr($data));

        return $report;
    }

    public function salaryDeductionPayrollData($month, $year){
        $data = [];

        $service_records = ServiceRecord::whereRaw('remark_id IN (26,28)')
                                    ->whereYear("date_from", $year)
                                    ->whereMonth("date_from", $month)
                                    ->orderBy('place_of_work')
                                    ->get();

        $prevPlaceOfWork = '';
        foreach($service_records as $sr) {
            if ($prevPlaceOfWork!=$sr->place_of_work) {
                $prevPlaceOfWork = $sr->place_of_work;
            }

            $employee = $sr->employee;
            $employee_name = Str::upper($employee->name);
            $data[$prevPlaceOfWork][$employee_name]['wop_covered'] = '';
            $data[$prevPlaceOfWork][$employee_name]['tardiness'] = '';
            $data[$prevPlaceOfWork][$employee_name]['days'] = '';
            $data[$prevPlaceOfWork][$employee_name]['remarks'] =  $sr->remarks_id==26?'For Cancellation':'For Restoration';
        }

        // TODO: Continue on Payroll Deduction Basis
        // $deductions = EmployeeDeduction::whereRaw('deduction_id IN (1,2,3)')
        //                                 ->whereRaw("DATE_FORMAT(ref_date,'%Y-%m')=?",$params['year'] . '-' . $params['month'])
        //                                 ->get();

        // foreach($deductions as $d) {
        //     $employee = Employee::find($d->employee_id);
        //     $sr = ServiceRecord::where('employee_id',$employee->id)->orderBy('date_from','DESC')->first();

        //     if (is_null($sr))
        //         $place_of_work = 'Unassigned';
        //     else
        //         $place_of_work = $sr->place_of_work;

        //     $employee_name = $employee->name;

        //     $dtr_json = json_decode($d->dtr_json);
        //     if ($d->deduction_id==1 || $d->deduction_id==3) {
        //         $data[$place_of_work][$employee_name]['wop_covered'] = date('Y-m-t',strtotime('-2 months',strtotime($d->ref_date)));
        //         if ($d->deduction_id==1)
        //         $data[$place_of_work][$employee_name]['wop_covered'] .= " - VL";
        //         else
        //         $data[$place_of_work][$employee_name]['wop_covered'] .= " - SL";
        //     } else {
        //         $data[$place_of_work][$employee_name]['wop_covered'] = '';
        //     }

        //     $tardiness = '';
        //     if ($d->deduction_id==2) {
        //         foreach ($dtr_json->ids as $dtr){
        //         $dtr_data = DailyTimeRecord::find($dtr);
        //         $tardiness .= (date('M-d',strtotime($dtr_data->ref_date)) . '<br/>');
        //         }
        //     }
        //     $data[$place_of_work][$employee_name]['tardiness'] = $tardiness;
        //     $data[$place_of_work][$employee_name]['days'] = $dtr_json->days;
        //     if (isset($data[$place_of_work][$employee_name]['remarks']))
        //         $data[$place_of_work][$employee_name]['remarks'] .= "For Salary Deduction";
        //     else
        //         $data[$place_of_work][ $employee_name]['remarks'] = "For Salary Deduction";
        // }

        return (object) [
            'items' => $data
        ];
    }

    public function monetization($printType, $month = null, $year = null, $for = null, $forPosition = null, $forDivision = null, $through = null, $throughPosition = null, $throughDivision = null, $signed = null, $signedPosition = null, $signedDivision = null){
        if (!in_array($this->PARAMETER['printType'], $this->printTypeArr))
            abort(403, 'Invalid Print Type');

        if (!$month)
            $month = date('m');

        if (!$year)
            $year = date('Y');

        $data = $this->monetizationData($month, $year);

        $data->printType = $printType;

        $data->for = Str::upper($for);
        $data->for = Str::upper($for);
        $data->forPosition = Str::upper($forPosition);
        $data->forDivision = Str::upper($forDivision);

        $data->through = Str::upper($through);
        $data->throughPosition = Str::upper($throughPosition);
        $data->throughDivision = Str::upper($throughDivision);

        $data->signed = Str::upper($signed);
        $data->signedPosition = Str::upper($signedPosition);
        $data->signedDivision = Str::upper($signedDivision);

        $report = new Mpdf($this->MONETIZATION_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->mon($data));

        return $report;
    }

    public function monetizationData($month, $year){
        $data = [];
        $leaveLedgers = LeaveLedger::whereRaw('request_type_id IN (14,17)')
                                ->whereRaw("DATE_FORMAT(`from`,'%Y-%m') = '$year-$month AND $year-$month'")
                                ->whereRaw("status IN (2,5,6,7)")
                                ->get();

        foreach ($leaveLedgers as $ledger) {
            $employee = $ledger->employee;

            $data[] = [
                'employee_number' => $employee->employee_number,
                'employee_name' => $employee->name,
                'credit' => $ledger->credit,
                'reason' => $ledger->reason
            ];
        }

        return (object)[
            'items' => $data
        ];
    }

    public function summaryRequest($status, $divisionId = null, $dateFrom = null, $dateTo = null){
        if (!in_array($status, $this->statusTypeArr))
            abort(403, 'Invalid Status');

        $data = $this->summaryRequestData($status, $divisionId, $dateFrom, $dateTo);

        $data->title = 'SUMMARY OF ';
        if ($status == 'ALL')
          $data->title .= "APPROVED/DISAPPROVED/CANCELLED";
        else
            $data->title .= Str::upper($status);
        $data->title .= ' LEAVE AND CTO REQUESTS';

        $data->status = $status;

        $report = new Mpdf($this->SUMMARY_REQUEST_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->slr($data));
        $report->setAutoTopMargin = 'stretch';

        return $report;
    }

    public function summaryRequestData($status, $division, $dateFrom, $dateTo) {
        $data = [];
        $leaveLedger = LeaveLedger::whereRaw("status IN (2,3,4)")
                            ->whereBetween('from',[$dateFrom, $dateTo])
                            ->whereRaw("request_type_id IN (1,2,15)")
                            ->orderBy('from')
                            ->get();

        foreach ($leaveLedger as $ledger) {
            $dataRow = array();

            $employee = $ledger->employee;

            $dataRow['employee_number'] = $employee->employee_number;
            $dataRow['employee_name'] = Str::upper($employee->nameLastNameFirst);

            $sr = ServiceRecord::getRecord($employee->id);

            if ($division) {
                if ($sr->division_id == $division) {
                    $dataRow['position'] = $sr?->positionOnPrint;
                    $dataRow['salary_grade'] = $sr?->designation?->sgOnPrint;
                    $dataRow['place_of_work'] = $sr?->place_of_work;
                } else {
                    continue;
                }
            }else {
                $dataRow['position'] = $sr?->positionOnPrint;
                $dataRow['salary_grade'] = $sr?->designation?->sgOnPrint;
                $dataRow['place_of_work'] = $sr?->place_of_work;
            }

            $from = $ledger->from->format('F d, Y');
            $to = $ledger->to->format('F d, Y');

            if ($ledger->request_type_id == 15) {
                $from = $ledger->from->format('F d, Y <br> H:i A');
                $to = $ledger->to->format('F d, Y <br> H:i A');
            }

            if ($status == 'ALL') {
                $dataRow['SL'] = $ledger->request_type_id==2?number_format(abs($ledger->credit),3):'';
                $dataRow['VL'] = $ledger->request_type_id==1?number_format(abs($ledger->credit),3):'';
                $dataRow['OB'] = $ledger->request_type_id==15?number_format(abs($ledger->credit),3):'';
                $dataRow['CTO'] = '';
                $dataRow['from'] = $from;
                $dataRow['to'] = $to;
                $dataRow['status'] = $ledger->statusOnDisplay;
            } else {
                $cond = [
                    'APPROVED' => 2,
                    'DISAPPROVED' => 3,
                    'CANCELLED' => 4
                ];

                if ($ledger->status == $cond[$status]) {
                    $dataRow['SL'] = $ledger->request_type_id==2?number_format(abs($ledger->credit),3):'';
                    $dataRow['VL'] = $ledger->request_type_id==1?number_format(abs($ledger->credit),3):'';
                    $dataRow['OB'] = $ledger->request_type_id==15?number_format(abs($ledger->credit),3):'';
                    $dataRow['CTO'] = '';
                    $dataRow['from'] = $from;
                    $dataRow['to'] = $to;
                } else {
                    continue;
                }
            }

            $data[] = $dataRow;
        }
        return (object)[
            'items' => collect($data)->sortBy('employee_name')->values()->toArray()
        ];
    }

    public function summaryRenderOt($dateFrom, $dateTo, $divisionId = null){
        $data = $this->summaryRenderOtData($dateFrom, $dateTo, $divisionId);

        $report = new Mpdf($this->SUMMARY_RENDER_OT_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->sro($data));
        $report->setAutoTopMargin = 'stretch';

        return $report;
    }

    public function summaryRenderOtData($dateFrom, $dateTo, $division = null){
        $data = [];
        $leaveLedger = LeaveLedger::where('request_type_id', 16)
                                ->whereRaw("DATE_FORMAT(`from`,'%Y-%m-%d') BETWEEN '$dateFrom' AND '$dateTo'")
                                ->whereRaw("status IN (2,6,5,7)")
                                ->orderBy('from')
                                ->get();

        foreach ($leaveLedger as $ledger) {
            $dataRow = array();

            $employee = $ledger->employee;

            $dataRow['employee_number'] = $employee->employee_number;
            $dataRow['employee_name'] = Str::upper($employee->nameLastNameFirst);

            $sr = ServiceRecord::getRecord($employee->id);

            if ($division) {
                if ($sr->division_id == $division) {
                    $dataRow['position'] = $sr?->positionOnPrint;
                    $dataRow['salary_grade'] = $sr?->designation?->sgOnPrint;
                    $dataRow['place_of_work'] = $sr?->place_of_work;
                } else {
                    continue;
                }
            }else {
                $dataRow['position'] = $sr?->positionOnPrint;
                $dataRow['salary_grade'] = $sr?->designation?->sgOnPrint;
                $dataRow['place_of_work'] = $sr?->place_of_work;
            }

            $dataRow['OT'] = number_format(abs($ledger->credit),3);
            $dataRow['from'] = $ledger->from->format('F d, Y');
            $dataRow['to'] = $ledger->to->format('F d, Y');

            $data[] = $dataRow;
        }

        return $data;
    }

    public function summaryNightDifferential($dateFrom, $dateTo, $divisionId = null){
        $data = $this->summaryNightDifferentialData($dateFrom, $dateTo, $divisionId);

        $report = new Mpdf($this->SUMMARY_NIGHT_DIFFERENTIAL_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->snd($data));
        $report->setAutoTopMargin = 'stretch';

        return $report;
    }

    public function summaryNightDifferentialData($dateFrom, $dateTo, $division = null){
        return array();
    }

    public function summaryNegativeLeave($dateFrom, $dateTo, $divisionId = null){
        $data = $this->summaryNegativeLeaveData($dateFrom, $dateTo, $divisionId);

        $report = new Mpdf($this->SUMMARY_NEGATIVE_LEAVE_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->snl($data));
        $report->setAutoTopMargin = 'stretch';

        return $report;
    }

    public function summaryNegativeLeaveData($dateFrom, $dateTo, $division = null){
        $data = [];

        $leaveLedger = LeaveLedger::whereRaw("remarks LIKE '%EARNED BUT DEDUCTED TO PAYROLL%'")
                                ->whereBetween('from', [$dateFrom, $dateTo])
                                ->orderBy('from')
                                ->get();

        foreach ($leaveLedger as $ledger) {
            $dataRow = array();

            $employee = $ledger->employee;

            $dataRow['employee_number'] = $employee->employee_number;
            $dataRow['employee_name'] = Str::upper($employee->nameLastNameFirst);

            $sr = ServiceRecord::getRecord($employee->id);

            if ($division) {
                if ($sr->division_id == $division) {
                    $dataRow['position'] = $sr?->positionOnPrint;
                    $dataRow['salary_grade'] = $sr?->designation?->sgOnPrint;
                    $dataRow['place_of_work'] = $sr?->place_of_work;
                } else {
                    continue;
                }
            }else {
                $dataRow['position'] = $sr?->positionOnPrint;
                $dataRow['salary_grade'] = $sr?->designation?->sgOnPrint;
                $dataRow['place_of_work'] = $sr?->place_of_work;
            }

            $dataRow['SL'] = $ledger->request_type_id==2?number_format(abs($ledger->credit),3):'';
            $dataRow['VL'] = $ledger->request_type_id==1?number_format(abs($ledger->credit),3):'';
            $dataRow['from'] = $ledger->from->format('F d, Y');
            $dataRow['to'] = $ledger->to->format('F d, Y');

            $data[] = $dataRow;
        }

        return $data;
    }

    public function annualUnusedLeave($refDate, $divisionId = null, $for = null, $forPosition = null, $forDivision = null, $signed = null, $signedDivision = null){
        $data = $this->annualUnusedLeaveData($refDate, $divisionId);

        $data->divisionName = $divisionId ?Division::find($divisionId)->name : 'N/A';

        $data->refDate = Carbon::parse($refDate)->format('d F, Y');

        $data->for = Str::upper($for);
        $data->forPosition = Str::upper($forPosition);
        $data->forDivision = Str::upper($forDivision);

        $data->signed = Str::upper($signed);
        $data->signedDivision = Str::upper($signedDivision);

        $report = new Mpdf($this->ANNUAL_UNUSED_LEAVE_SETTING);

        $template = new SelfServiceTemplate;
        $report->WriteHTML($template->aul($data));

        return $report;
    }

    public function annualUnusedLeaveData($refDate, $divisionId = null){
        $data = [];
        $positions = Position::where('division_id', $divisionId)->get();

        foreach ($positions as $position) {
            $sr = ServiceRecord::where('position_id', $position->id)->whereNull('date_to')->whereNull('date_seperation')->first();

            if (!is_null($sr)) {
                $employee = $sr->employee;

                $balance = $this->getBalance($employee, $refDate);
                $vlBalance = $balance->get('VL');
                $slBalance = $balance->get('SL');

                $rowData = array (
                    'fullname' => $employee->name,
                    'vl_balance' => number_format($vlBalance, 3),
                    'sl_balance' => number_format($slBalance, 3),
                    'total' => number_format($vlBalance + $slBalance, 3)
                );

                $data[] = (object) $rowData;
            }
        }

        return (object) [
            'items' => $data
        ];
    }
}
