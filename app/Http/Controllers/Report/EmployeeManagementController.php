<?php

namespace App\Http\Controllers\Report;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Reports\EmployeeManagement;

class EmployeeManagementController extends Controller
{
    use EmployeeManagement;

    public $PDS = "pds.pdf";
    public $PDF = "pdf.pdf";
    public $CE = "ce.pdf";
    public $PEA = "plantilla-ea.pdf";
    public $JOCOSEA = "jo-cos-ea.pdf";

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

    //* PDS Reports
    public function singlePds()
    {
        // validation
        $employeeId = $this->PARAMETER['employeeId'] ?? null;
        if (!$this->checkEmployeeId($employeeId))
            abort(403, 'Employee not found');

        // generate report
        return $this->pds($employeeId)->Output($this->PDS, 'I');
    }

    public function portalPds()
    {
        // validation
        $employeeId = $this->USER->employee->id ?? null;
        if (!$this->checkEmployeeId($employeeId))
            abort(403, 'Employee not found');

        // generate report
        return $this->pds($employeeId)->Output($this->PDS, 'I');
    }

    // TODO
    public function multiplePds()
    {
        // validation
        $employeeId = $this->USER->employee->id ?? null;
        if ($employeeId == null)
            return abort('Employee not found', 400);

        // generate report
        return $this->pds($employeeId)->Output($this->PDS, 'I');
    }

    //* PDF Reports
    public function singlePdf()
    {
        // validation
        $positionId = $this->PARAMETER['positionId'] ?? null;
        if (!$this->checkPositionId($positionId))
            abort(403, 'Employee not found');

        $employeeName = $this->PARAMETER['employeeName'] ?? '';
        $supervisorName = $this->PARAMETER['supervisorName'] ?? '';

        // generate report
        return $this->pdf($positionId, $employeeName, $supervisorName)->Output($this->PDF, 'I');
    }

    // TODO
    public function multiplePdf()
    {
        // validation
        $positionId = $this->PARAMETER['positionId'] ?? null;
        if (!$this->checkPositionId($positionId))
            abort(403, 'Employee not found');

        // generate report
        return $this->pds($employeeId)->Output($this->PDS, 'I');
    }

    //* CE Reports
    public function singleCe()
    {
        // validation
        $employeeId = $this->PARAMETER['employeeId'] ?? null;
        if (!$this->checkEmployeeId($employeeId))
            abort(403, 'Employee not found');

        $name1 = $this->PARAMETER['name1'] ?? '';
        $position1 = $this->PARAMETER['position1'] ?? '';
        $division1 = $this->PARAMETER['division1'] ?? '';

        $name2 = $this->PARAMETER['name2'] ?? '';
        $position2 = $this->PARAMETER['position2'] ?? '';
        $division2 = $this->PARAMETER['division2'] ?? '';

        // generate report
        return $this->ce(
            $employeeId,
            $name1,
            $position1,
            $division1,
            $name2,
            $position2,
            $division2
        )->Output($this->CE, 'I');
    }

    //* EA Reports
    public function plantillaEa()
    {
        // validation
        $remarkId = $this->PARAMETER['remarkId'] ?? null;
        $dateOfEmployment = $this->PARAMETER['dateOfEmployment'] ?? null;
        $placeOfWork = $this->PARAMETER['placeOfWork'] ?? null;
        $gender = $this->PARAMETER['gender'] ?? null;
        $employeeGroupId = $this->PARAMETER['employeeGroupId'] ?? null;

        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';

        $supervisor = $this->PARAMETER['supervisor'] ?? '';
        $supervisorPosition = $this->PARAMETER['supervisorPosition'] ?? '';

        return $this->pea(
            $prepared,
            $preparedPosition,
            $supervisor,
            $supervisorPosition,

            $remarkId,
            $dateOfEmployment,
            $placeOfWork,
            $gender,
            $employeeGroupId
        )->Output($this->PEA, 'I');
    }

    public function joCosEa()
    {
        // validation
        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';

        $supervisor = $this->PARAMETER['supervisor'] ?? '';
        $supervisorPosition = $this->PARAMETER['supervisorPosition'] ?? '';

        return $this->jcea(
            $prepared,
            $preparedPosition,
            $supervisor,
            $supervisorPosition
        )->Output($this->JOCOSEA, 'I');
    }

}
