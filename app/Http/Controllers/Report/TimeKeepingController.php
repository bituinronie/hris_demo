<?php

namespace App\Http\Controllers\Report;

use App\Models\User;
use App\Models\Token;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Traits\Reports\TimeKeeping;
use App\Http\Controllers\Controller;

class TimeKeepingController extends Controller
{
    use TimeKeeping;

    public $DTR = "dtr.pdf";
    public $TS = "tardiness-summary.pdf";
    public $BS = "login-logout-summary.pdf";
    public $MA = "monthly-attendance.pdf";
    public $EA = "employee-absences.pdf";

    public function __construct(Request $request)
    {
        $this->TOKEN = $request->route('token');

        $parameters = Token::findByToken($this->TOKEN);
        if ($parameters == null)
            abort(403, 'Token Expired');

        $this->USER = User::find($parameters->model_id);
        $this->checkUserAccess($this->USER, $parameters->permission_id);
        $this->PARAMETER = $parameters->model_name;
    }

    public function __destruct()
    {
    // Token::revokeByToken($this->TOKEN);
    }

    private function getDates()
    {
        $year = $this->PARAMETER['year'] ?? date('Y');
        $month = $this->PARAMETER['month'] ?? date('m');

        $dateToParse = "$year-$month-01";

        $dateFrom = $this->PARAMETER['dateFrom'] ?? date('Y-m-01', strtotime($dateToParse));
        $dateTo = $this->PARAMETER['dateTo'] ?? date('Y-m-t', strtotime($dateToParse));

        return (object)[
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ];
    }

    //* DTR Reports
    public function singleDtr()
    {
        // validation
        $employeeId = $this->PARAMETER['employeeId'] ?? null;
        if (!$this->checkEmployeeId($employeeId))
            abort(403, 'Employee not found');

        $dates = $this->getDates();

        $perPage = $this->PARAMETER['perPage'] ?? 31;
        $supervisor = $this->PARAMETER['supervisor'] ?? '';

        // generate report
        return $this->dtr($employeeId, $dates->dateFrom, $dates->dateTo, $perPage, $supervisor)->Output($this->DTR, 'I');
    }

    public function portalDtr()
    {
        // validation
        $employeeId = $this->USER->employee->id ?? null;
        if (!$this->checkEmployeeId($employeeId))
            abort(403, 'Employee not found');

        $dates = $this->getDates();

        $perPage = $this->PARAMETER['perPage'] ?? 31;
        $supervisor = $this->PARAMETER['supervisor'] ?? '';

        // generate report
        return $this->dtr($employeeId, $dates->dateFrom, $dates->dateTo, $perPage, $supervisor)->Output($this->DTR, 'I');
    }

    public function multipleDtr()
    {
        // validation
        $employeeId = $this->PARAMETER['employeeIds'] ?? [];

        $employeeId = collect($employeeId)->filter(fn($id) => Employee::find($id) ? true : false)->toArray();

        if (!$employeeId)
            return abort(400, 'Employee not found');

        $dates = $this->getDates();

        $perPage = $this->PARAMETER['perPage'] ?? 31;
        $supervisor = $this->PARAMETER['supervisor'] ?? '';

        // generate report
        return $this->dtr($employeeId, $dates->dateFrom, $dates->dateTo, $perPage, $supervisor)->Output($this->DTR, 'I');
    }

    //* Log-in and Log-out Summary
    public function singleBandiSummary()
    {
        $placeOfWork = $this->PARAMETER['placeOfWork'] ?? null;
        $divisionId = $this->PARAMETER['divisionId'] ?? null;

        $dates = $this->getDates();

        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';
        $supervisor = $this->PARAMETER['supervisor'] ?? '';
        $supervisorPosition = $this->PARAMETER['supervisorPosition'] ?? '';

        return $this->bandiSummary($divisionId, $placeOfWork, $dates->dateFrom, $dates->dateTo, $prepared, $preparedPosition, $supervisor, $supervisorPosition)->Output($this->BS, 'I');
    }

    //* Summary of Tardiness
    public function singleTardinessSummary()
    {
        $placeOfWork = $this->PARAMETER['placeOfWork'] ?? '';

        $dates = $this->getDates();

        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';
        $supervisor = $this->PARAMETER['supervisor'] ?? '';
        $supervisorPosition = $this->PARAMETER['supervisorPosition'] ?? '';

        return $this->tardinessSummary($placeOfWork, $dates->dateFrom, $dates->dateTo, $prepared, $preparedPosition, $supervisor, $supervisorPosition)->Output($this->TS, 'I');
    }

    //* Monthly Attendance Report
    public function singleMonthlyAttendance()
    {
        $placeOfWork = $this->PARAMETER['placeOfWork'] ?? null;
        $divisionId = $this->PARAMETER['divisionId'] ?? null;

        $dates = $this->getDates();

        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';
        $supervisor = $this->PARAMETER['supervisor'] ?? '';
        $supervisorPosition = $this->PARAMETER['supervisorPosition'] ?? '';

        return $this->monthlyAttendance($divisionId, $placeOfWork, $dates->dateFrom, $dates->dateTo, $prepared, $preparedPosition, $supervisor, $supervisorPosition)->Output($this->BS, 'I');
    }

    //* Summary of Employees Absences
    public function singleEmployeeAbsences()
    {
        $placeOfWork = $this->PARAMETER['placeOfWork'] ?? null;

        $dates = $this->getDates();

        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';
        $supervisor = $this->PARAMETER['supervisor'] ?? '';
        $supervisorPosition = $this->PARAMETER['supervisorPosition'] ?? '';

        return $this->employeeAbsences($placeOfWork, $dates->dateFrom, $dates->dateTo, $prepared, $preparedPosition, $supervisor, $supervisorPosition)->Output($this->EA, 'I');
    }
}
