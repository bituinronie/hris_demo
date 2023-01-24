<?php

namespace App\Http\Controllers\Report;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Traits\Reports\History;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    use History;

    private $SR = "sr.pdf";
    private $MU = "mu.pdf";
    private $MC = "mc.pdf";
    private $SS = "ss.pdf";

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

    //* Service Record Reports
    public function singleSr()
    {
        // validation
        $employeeId = $this->PARAMETER['employeeId'] ?? null;
        if (!$this->checkEmployeeId($employeeId))
            abort(403, 'Employee not found');

        $name = $this->PARAMETER['supervisorName'] ?? '';
        $position = $this->PARAMETER['position'] ?? '';
        $division = $this->PARAMETER['division'] ?? '';

        // generate report
        return $this->sr($employeeId, $name, $position, $division)->Output($this->SR, 'I');
    }

    public function singleMu()
    {
        // validation
        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';

        $supervisor = $this->PARAMETER['supervisor'] ?? '';
        $supervisorPosition = $this->PARAMETER['supervisorPosition'] ?? '';

        return $this->mu(
            $prepared,
            $preparedPosition,
            $supervisor,
            $supervisorPosition
        )->Output($this->MU, 'I');
    }

    public function singleMc()
    {
        // validation
        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';
        $preparedDivision = $this->PARAMETER['preparedDivision'] ?? '';

        $supervisor = $this->PARAMETER['supervisor'] ?? '';
        $supervisorPosition = $this->PARAMETER['supervisorPosition'] ?? '';
        $supervisorDivision = $this->PARAMETER['supervisorDivision'] ?? '';

        return $this->mc(
            $prepared,
            $preparedPosition,
            $preparedDivision,
            $supervisor,
            $supervisorPosition,
            $supervisorDivision
        )->Output($this->MC, 'I');
    }

    // TODO
    public function singleSs()
    {
        // validation
        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';
        $preparedDivision = $this->PARAMETER['preparedDivision'] ?? '';

        $supervisor = $this->PARAMETER['supervisor'] ?? '';
        $supervisorPosition = $this->PARAMETER['supervisorPosition'] ?? '';
        $supervisorDivision = $this->PARAMETER['supervisorDivision'] ?? '';

        return $this->ss(
            $prepared,
            $preparedPosition,
            $preparedDivision,
            $supervisor,
            $supervisorPosition,
            $supervisorDivision
        )->Output($this->SS, 'I');
    }
}
