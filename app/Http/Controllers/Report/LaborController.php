<?php

namespace App\Http\Controllers\Report;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Traits\Reports\Labor;
use App\Http\Controllers\Controller;

class LaborController extends Controller
{
    use Labor;

    public $SUMMARY_OF_APPRAISALS = 'summary-of-appraisals.xlsx';
    public $SUMMARY_OF_AWARDS = 'summary-of-awards.pdf';
    public $SUMMARY_OF_OFFENSES = 'summary-of-offenses.pdf';

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

    public function singleAppraisalSummary()
    {
        // validation
        $year = $this->PARAMETER['year'] ?? date('Y');
        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';

        $noted = $this->PARAMETER['noted'] ?? '';
        $notedPosition = $this->PARAMETER['notedPosition'] ?? '';

        // generate report
        return $this->appraisalSummary($year, $prepared, $preparedPosition, $noted, $notedPosition);
    }

    public function singleAwardSummary()
    {
        // validation
        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';

        $noted = $this->PARAMETER['noted'] ?? '';
        $notedPosition = $this->PARAMETER['notedPosition'] ?? '';

        // generate report
        return $this->awardSummary($prepared, $preparedPosition, $noted, $notedPosition)->Output($this->SUMMARY_OF_AWARDS, 'I');
    }

    public function singleOffenseSummary()
    {
        // validation
        $prepared = $this->PARAMETER['prepared'] ?? '';
        $preparedPosition = $this->PARAMETER['preparedPosition'] ?? '';

        $noted = $this->PARAMETER['noted'] ?? '';
        $notedPosition = $this->PARAMETER['notedPosition'] ?? '';

        // generate report
        return $this->offenseSummary($prepared, $preparedPosition, $noted, $notedPosition)->Output($this->SUMMARY_OF_OFFENSES, 'I');
    }
}
