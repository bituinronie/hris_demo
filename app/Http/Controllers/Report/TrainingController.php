<?php

namespace App\Http\Controllers\Report;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Traits\Reports\Training;
use App\Http\Controllers\Controller;

class TrainingController extends Controller
{
    use Training;

    public $SUMMARY_OF_TRAINING = 'summary-of-training.xlsx';

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

    public function singleTrainingSummary()
    {
        // generate report
        return $this->st($this->SUMMARY_OF_TRAINING);
    }
}
