<?php

namespace App\Http\Controllers\Report;

use App\Models\User;
use App\Models\Token;
use App\Traits\Reports\SelfService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SelfServiceController extends Controller
{
    use SelfService;

    public $LEAVE_APPLICATION_FORM = 'leave-application-form.pdf';
    public $LEAVE_LEDGER = 'leave-ledger.pdf';
    public $LEAVE_BALANCE = 'leave-balance.pdf';
    public $CERTIFICATION_OF_LEAVE_CREDITS = 'certification-of-leave-credit.pdf';
    public $CERTIFICATION_OF_LEAVE_WITHOUT_PAY = 'certification-of-leave-without-pay.pdf';
    public $SALARY_DEDUCTION_PAYROLL = 'report-of-salary-deduction-from-restoration-to-payroll.pdf';
    public $MONETIZATION = 'monetization.pdf';
    public $SUMMARY_REQUEST = 'summary-of-request.pdf';
    public $SUMMARY_RENDER_OT = 'summary-of-render-ot.pdf';
    public $SUMMARY_NIGHT_DIFFERENTIAL = 'summary-of-night-differential.pdf';
    public $SUMMARY_NEGATIVE_LEAVE = 'summary-of-negative-leave.pdf';
    public $ANNUAL_UNUSED_LEAVE = 'annual-unused-leave.pdf';

    public function __construct(Request $request)
    {
        $this->TOKEN = $request->route('token');

        $parameters = Token::findByToken($this->TOKEN);
        if ($parameters == null)
            abort(403, 'Token Expired');

        $this->USER = User::find($parameters->model_id);
        $this->checkUserAccess($this->USER, $parameters->permission_id);
        $this->PARAMETER = $parameters->model_name;

    // dd($this->PARAMETER);
    }

    public function __destruct()
    {
    // Token::revokeByToken($this->TOKEN);
    }

    public function singleLeaveApplicationForm()
    {
        // validation
        $leaveLedgerId = $this->PARAMETER['requestId'] ?? null;

        if (!$this->checkLeaveLedgerId($leaveLedgerId))
            abort(403, 'Request not found');

        return $this->leaveApplicationForm(
            $leaveLedgerId,
        )->Output($this->LEAVE_APPLICATION_FORM, 'I');
    }

    public function portalLeaveApplicationForm()
    {
        // validation
        $leaveLedgerId = $this->PARAMETER['requestId'] ?? null;

        if (!$this->checkLeaveLedgerId($leaveLedgerId))
            abort(403, 'Request not found');

        return $this->leaveApplicationForm(
            $leaveLedgerId,
        )->Output($this->LEAVE_APPLICATION_FORM, 'I');
    }

    public function singleLeaveLedger()
    {
        // validation
        $employeeId = $this->PARAMETER['employeeId'] ?? null;
        $preparedBy = $this->PARAMETER['preparedBy'] ?? null;
        $certifiedBy = $this->PARAMETER['certifiedBy'] ?? null;
        $position2 = $this->PARAMETER['position2'] ?? null;
        $division2 = $this->PARAMETER['division2'] ?? null;

        if (!$this->checkEmployeeId($employeeId))
            abort(403, 'Employee not found');

        return $this->leaveLedger(
            $employeeId,
            $preparedBy,
            $certifiedBy,
            $position2,
            $division2
        )->Output($this->LEAVE_LEDGER, 'I');
    }

    public function singleLeaveBalance()
    {
        // validation
        $divisionId = $this->PARAMETER['divisionId'] ?? null;
        $refDate = $this->PARAMETER['refDate'] ?? null;

        $from = $this->PARAMETER['from'] ?? null;

        $employee = $this->PARAMETER['employee'] ?? null;
        $employeePosition = $this->PARAMETER['employeePosition'] ?? null;
        $employeeDivision = $this->PARAMETER['employeeDivision'] ?? null;
        $supervisor = $this->PARAMETER['supervisor'] ?? null;
        $supervisorDivision = $this->PARAMETER['supervisorDivision'] ?? null;

        if (!$this->checkDivisionId($divisionId))
            abort(403, 'Division not found');

        return $this->leaveBalance(
            $divisionId,
            $refDate,
            $from,
            $employee,
            $employeePosition,
            $employeeDivision,
            $supervisor,
            $supervisorDivision
        )->Output($this->LEAVE_LEDGER, 'I');
    }

    public function singleCertificationLeaveCredits()
    {
        // validation
        $employeeId = $this->PARAMETER['employeeId'] ?? [];
        $refDate = $this->PARAMETER['refDate'] ?? null;

        $prepared = $this->PARAMETER['prepared'] ?? null;
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? null;
        $preparedDivision = $this->PARAMETER['preparedDivision'] ?? null;

        $verified = $this->PARAMETER['verified'] ?? null;
        $verifiedPosition = $this->PARAMETER['verifiedPosition'] ?? null;
        $verifiedDivision = $this->PARAMETER['verifiedDivision'] ?? null;

        if ($employeeId == [])
            abort(403, 'No Selected Employees found');

        return $this->certificationOfLeaveCredits(
            $employeeId,
            $refDate,
            $prepared,
            $preparedPosition,
            $preparedDivision,
            $verified,
            $verifiedPosition,
            $verifiedDivision
        )->Output($this->CERTIFICATION_OF_LEAVE_CREDITS, 'I');
    }

    public function singleCertificationWithoutPay()
    {
        // validation
        $employeeId = $this->PARAMETER['employeeId'] ?? [];
        $dateFrom = $this->PARAMETER['dateFrom'] ?? null;
        $dateTo = $this->PARAMETER['dateTo'] ?? null;

        $supervisor = $this->PARAMETER['supervisor'] ?? null;
        $supervisorPosition = $this->PARAMETER['supervisorPosition'] ?? null;
        $supervisorDivision = $this->PARAMETER['supervisorDivision'] ?? null;

        if ($employeeId == [])
            abort(403, 'No Selected Employees found');

        return $this->certificationOfLeaveWithoutPay(
            $employeeId,
            $dateFrom,
            $dateTo,
            $supervisor,
            $supervisorPosition,
            $supervisorDivision
        )->Output($this->CERTIFICATION_OF_LEAVE_WITHOUT_PAY, 'I');
    }

    public function singleSalaryDeductionPayroll()
    {
        // validation
        $month = $this->PARAMETER['month'] ?? null;
        $year = $this->PARAMETER['year'] ?? null;

        $from = $this->PARAMETER['from'] ?? null;

        $for = $this->PARAMETER['for'] ?? null;
        $forPosition = $this->PARAMETER['forPosition'] ?? null;
        $forDivision = $this->PARAMETER['forDivision'] ?? null;

        $signed = $this->PARAMETER['signed'] ?? null;
        $signedDivision = $this->PARAMETER['signedDivision'] ?? null;

        return $this->salaryDeductionPayroll(
            $month,
            $year,
            $from,
            $for,
            $forPosition,
            $forDivision,
            $signed,
            $signedDivision
        )->Output($this->SALARY_DEDUCTION_PAYROLL, 'I');
    }

    public function singleMonetization()
    {
        // validation
        $printType = in_array($this->PARAMETER['printType'], $this->printTypeArr) ? $this->PARAMETER['printType'] : null;

        if (!$printType)
            abort(403, 'Invalid Print Type');

        $month = $this->PARAMETER['month'] ?? null;
        $year = $this->PARAMETER['year'] ?? null;

        $for = $this->PARAMETER['for'] ?? null;
        $forPosition = $this->PARAMETER['forPosition'] ?? null;
        $forDivision = $this->PARAMETER['forDivision'] ?? null;

        $through = $this->PARAMETER['through'] ?? null;
        $throughPosition = $this->PARAMETER['throughPosition'] ?? null;
        $throughDivision = $this->PARAMETER['throughDivision'] ?? null;

        $signed = $this->PARAMETER['signed'] ?? null;
        $signedPosition = $this->PARAMETER['signedPosition'] ?? null;
        $signedDivision = $this->PARAMETER['signedDivision'] ?? null;

        return $this->monetization(
            $printType,
            $month,
            $year,
            $for,
            $forPosition,
            $forDivision,
            $through,
            $throughPosition,
            $throughDivision,
            $signed,
            $signedPosition,
            $signedDivision,
        )->Output($this->MONETIZATION, 'I');
    }

    public function singleSummaryRequest()
    {
        // validation
        $status = in_array($this->PARAMETER['status'], $this->statusTypeArr) ? $this->PARAMETER['status'] : null;
        if (!$status)
            abort(403, 'Invalid Status');

        $divisionId = $this->PARAMETER['divisionId'] ?? null;
        if ($divisionId) {
            if (!$this->checkDivisionId($divisionId))
                abort(403, 'Division not found');
        }

        $dateFrom = $this->PARAMETER['dateFrom'] ?? null;
        $dateTo = $this->PARAMETER['dateTo'] ?? null;

        return $this->summaryRequest(
            $status,
            $divisionId,
            $dateFrom,
            $dateTo
        )->Output($this->SUMMARY_REQUEST, 'I');
    }

    public function singleSummaryEmployeesRenderOt()
    {
        $divisionId = $this->PARAMETER['divisionId'] ?? null;
        if ($divisionId) {
            if (!$this->checkDivisionId($divisionId))
                abort(403, 'Division not found');
        }

        $dateFrom = $this->PARAMETER['dateFrom'] ?? null;
        $dateTo = $this->PARAMETER['dateTo'] ?? null;

        return $this->summaryRenderOt(
            $dateFrom,
            $dateTo,
            $divisionId
        )->Output($this->SUMMARY_RENDER_OT, 'I');
    }

    public function singleSummaryEmployeesNightDifferential()
    {
        $divisionId = $this->PARAMETER['divisionId'] ?? null;
        if ($divisionId) {
            if (!$this->checkDivisionId($divisionId))
                abort(403, 'Division not found');
        }

        $dateFrom = $this->PARAMETER['dateFrom'] ?? null;
        $dateTo = $this->PARAMETER['dateTo'] ?? null;

        return $this->summaryNightDifferential(
            $dateFrom,
            $dateTo,
            $divisionId
        )->Output($this->SUMMARY_NIGHT_DIFFERENTIAL, 'I');
    }

    public function singleSummaryEmployeesNegativeLeaveCredits()
    {
        $divisionId = $this->PARAMETER['divisionId'] ?? null;
        if ($divisionId) {
            if (!$this->checkDivisionId($divisionId))
                abort(403, 'Division not found');
        }

        $dateFrom = $this->PARAMETER['dateFrom'] ?? null;
        $dateTo = $this->PARAMETER['dateTo'] ?? null;

        return $this->summaryNegativeLeave(
            $dateFrom,
            $dateTo,
            $divisionId
        )->Output($this->SUMMARY_NEGATIVE_LEAVE, 'I');
    }

    public function singleAnnualEmployeesUnusedLeave()
    {
        $referenceDate = $this->PARAMETER['referenceDate'] ?? null;

        $divisionId = $this->PARAMETER['divisionId'] ?? null;
        if ($divisionId) {
            if (!$this->checkDivisionId($divisionId))
                abort(403, 'Division not found');
        }

        $for = $this->PARAMETER['for'] ?? null;
        $forPosition = $this->PARAMETER['forPosition'] ?? null;
        $forDivision = $this->PARAMETER['forDivision'] ?? null;

        $signed = $this->PARAMETER['signed'] ?? null;
        $signedDivision = $this->PARAMETER['signedDivision'] ?? null;

        return $this->annualUnusedLeave(
            $referenceDate,
            $divisionId,
            $for,
            $forPosition,
            $forDivision,
            $signed,
            $signedDivision
        )->Output($this->ANNUAL_UNUSED_LEAVE, 'I');
    }

}
