<?php

namespace App\Http\Controllers\Report;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Reports\ApplicationMatrix;

class ApplicationMatrixController extends Controller
{
    use ApplicationMatrix;

    public $AM = 'application-matrix.xlsx';

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

    //* Application Matrix Report
    public function singleAm()
    {
        // validation
        $positionName = $this->PARAMETER['positionName'] ?? null;
        if (!$this->checkPositionName($positionName))
            abort(403, 'Position on Applicant Matrix not found.');

        // generate report
        return $this->am($positionName);
    }
}
