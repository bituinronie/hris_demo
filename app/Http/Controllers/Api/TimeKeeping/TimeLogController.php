<?php

namespace App\Http\Controllers\Api\TimeKeeping;

use App\Models\Dtr;
use App\Models\TimeLog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimeLogController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    public function dtrLog($dtrId){
        $this->checkUserAccess(auth()->user(), 'search dtr');

        $dtr = Dtr::find($dtrId);
        if ($dtr === null)
            return response([
                'message' => 'No dtr found.'
            ], 400);

        $timeLogs = $dtr->timeLogs;

        return response($timeLogs, 200);
    }

    public function portalDtrLog($dtrId){
        $user = auth()->user();
        $this->checkUserAccess($user, 'portal dtr');

        if(!$employeeId = $user->employee?->id)
            return response('No employee found.', 400);

        $dtr = Dtr::find($dtrId);
        if ($dtr === null)
            return response([
                'message' => 'No dtr found.'
            ], 400);

        $timeLogs = $dtr->timeLogs;

        return response($timeLogs, 200);
    }
}