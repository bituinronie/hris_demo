<?php

namespace App\Http\Controllers\Api\SelfService;

use App\Models\User;
use App\Models\Token;

use App\Models\Employee;
use App\Traits\CronTrait;
use App\Models\LeaveLedger;
use App\Models\RequestType;
use Illuminate\Support\Str;
use App\Traits\RequestTrait;
use Illuminate\Http\Request;
use App\Traits\ConstantTrait;
use App\Traits\EmployeeTrait;
use Illuminate\Support\Carbon;
use App\Traits\LeaveLedgerTrait;
use App\Http\Controllers\Controller;

/**
 * TODO
 * 
 * Request Computation
 * Apply getKeys on `getPortalBody` & `getBody`
 * CRON
 */
class RequestController extends Controller
{
    use LeaveLedgerTrait, ConstantTrait, RequestTrait, EmployeeTrait, CronTrait;

    private $TOKEN = null;

    public function __construct(
        public Request $REQUEST
    ){
        $this->middleware('auth:api', ['except' => ['tokenApprove','tokenDisapprove']]);
    }

    public function __destruct(){
        if($this->TOKEN)
            Token::revokeByToken($this->TOKEN);
    }

    /**
     * Validations & getBody
     */
    private function getPortalBody(){
        $keys = $this->getKeys(); // primary need for creating LeaveLedger

        $body = collect($this->REQUEST->validate([
            'reason' => 'nullable',

            'proof' => 'nullable|file',
            'proof_type' => 'nullable',

            'ob_venue' => 'nullable',
        ]))->merge($keys)->all();

        //* init records
        $employee = auth()->user()->employee;
        if(!$employee)
            abort(404, 'Employee not found.');

        $body['employee_id'] = $employee->id;
        $body['status'] = 1;

        //* Computation Validation
        $computationError  = $this->getComputationError($employee, $body['from'], $body['to'], $body['request_type_id']);
        if($computationError)
            abort(400, $computationError);

        //* GET credit
        $body['credit'] = $this->getCredit($employee, $body['from'], $body['to'], $body['request_type_id']);

        return $body;
    }

    private function getBody($employeeId = null, $leaveLedger = null){ // null => for update
        $keys = $this->getKeys(); // primary need for creating LeaveLedger
        
        $body = collect($this->REQUEST->validate([
            'remarks' => 'nullable',

            'credit' => 'nullable|numeric',

            'proof' => 'nullable|file',
            'proof_type' => 'nullable',

            'ob_venue' => 'nullable',
            'is_start' => 'nullable'
        ]))->merge($keys)->all();

        // is_start
        if(isset($body['is_start']))
            $body['is_start'] = match($body['is_start']) {
                '1',1,'true','TRUE',true => true,
                '0',0,'false','FALSE',false => false,
                default => null
            };

        //* init records
        if($employeeId) {
            $employee = Employee::find($employeeId);
            if(!$employee)
                abort(404, 'Employee not found.');

            $body['employee_id'] = $employee->id;
            $body['status'] = 6;
        }

        if($leaveLedger)
            $employee = $leaveLedger->employee;

        return $body;
    }

    /**
     * Token Access
     */
    public function tokenApprove($token){
        $parameters = Token::findByToken($token);
        if($parameters == null)
            return response([
                'message' => 'Token Expired'
            ], 403);

        $this->TOKEN = $token;

        $user = User::find($parameters->model_id);
        $leaveLedgerId = $parameters->model_name['requestId'] ?? null;

        if(!$leaveLedgerId)
            return response([
                'message' => 'request id missing.'
            ], 400);

        $employee = $user->employee;

        if(!$employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        $leaveLedger = LeaveLedger::findToApprove($leaveLedgerId, $employee);

        if(!$leaveLedger)
            return response([
                'message' => 'Request not found.'
            ], 404);

        $index = $this->getApproverIndex($employee, $leaveLedger->requestType->category, $leaveLedger->employee_id);

        $newApproverStatus = $leaveLedger->approverStatus;
        $newApproverStatus[$index] = 2; // 2 => approve request

        $leaveLedger->approverStatus = $newApproverStatus;

        if($leaveLedger->save())
            return response([
                'message' => 'request approved.'
            ], 200);

        return response([
            'message' => 'Oh no! Something\'s wrong.'
        ], 500);
    }

    public function tokenDisapprove($token){
        $parameters = Token::findByToken($token);
        if($parameters == null)
            return response([
                'message' => 'Token Expired'
            ], 403);

        $this->TOKEN = $token;

        $user = User::find($parameters->model_id);
        $leaveLedgerId = $parameters->model_name['requestId'] ?? null;

        if(!$leaveLedgerId)
            return response([
                'message' => 'request id missing.'
            ], 400);

        $employee = $user->employee;

        if(!$employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        $leaveLedger = LeaveLedger::findToApprove($leaveLedgerId, $employee);

        if(!$leaveLedger)
            return response([
                'message' => 'Request not found.'
            ], 404);

        $remarks = $this->REQUEST->validate([
            'remarks' => 'required|string'
        ])['remarks'];

        $index = $this->getApproverIndex($employee, $leaveLedger->requestType->category, $leaveLedger->employee_id);

        $newApproverStatus = $leaveLedger->approverStatus;
        $newApproverStatus[$index] = 3; // 3 => disapprove request

        $leaveLedger->approverStatus = $newApproverStatus;
        $leaveLedger->remarks = $remarks;

        if($leaveLedger->save())
            return response([
                'message' => 'request disapproved.'
            ], 200);

        return response([
            'message' => 'Oh no! Something\'s wrong.'
        ], 500);

    }

    /**
     * Admin Access
     */

    public function create($employeeId){
        $this->checkUserAccess(auth()->user(), 'write request');

        $employee = Employee::find($employeeId);

        if(!$employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        $body = $this->getBody($employee->id);

        $ll = $this->createRecord('LeaveLedger', $body);

        return response([
            'message' => 'request successfully created.'
        ], 200);
    }

    public function update($leaveLedgerId){
        $this->checkUserAccess(auth()->user(), 'write request');

        $leaveLedger = LeaveLedger::find($leaveLedgerId);

        if($leaveLedger == null && !$leaveLedger?->canUpdate)
            return response(['message' => 'no request record found.'], 400);

        $body = $this->getBody(null, $leaveLedger); // null => employeeId already set on create

        $ll = $this->updateRecord('LeaveLedger', $leaveLedger->id, $body);

        return response(null, 204);
    }

    public function cancel($leaveLedgerId){
        $this->checkUserAccess(auth()->user(), 'write request');

        $leaveLedger = LeaveLedger::find($leaveLedgerId);
        if(!$leaveLedger)
            return response([
                'message' => 'Request not found.'
            ], 400);

        if(!($leaveLedger->status == 6? true:$leaveLedger->isToCancel))
            return response([
                'message' => 'Request cannot be cancelled.'
            ], 400);

        $leaveLedger->status = 4; // cancellation status

        if($leaveLedger->save())
            return response(null, 204);

        return response([
            'message' => 'Oh no! Something\'s wrong.'
        ], 500);
    }

    public function search($employeeId = null, $leaveLedgerId = null){
        $this->checkUserAccess(auth()->user(), 'search request');

        if(!$employeeId)
            return $this->returnResponseAllEmployees();

        if($leaveLedgerId) {
            $entity = LeaveLedger::find($leaveLedgerId);

            if($entity == null)
                return response(['message' => 'no request record found.'], 400);

            return response($this->renderRawData($entity), 200);
        }

        $employee = Employee::find($employeeId);

        if(!$employee)
            return response([
                'message' => 'No employee found.'
            ], 400);

        return $this->getRequestResponse($employee, false); // false =>isPortal
    }

    public function balance($employeeId){
        $this->checkUserAccess(auth()->user(), 'search request');

        $employee = Employee::find($employeeId);

        if(!$employee)
            return response([
                'message' => 'No employee found.'
            ], 400);

        return response($this->getBalanceOnDisplay($employee), 200);
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search request');

        return $this->getParameterResonse();
    }

    public function compute($employeeId){
        $this->checkUserAccess(auth()->user(), 'search request');

        $employee = Employee::find($employeeId);

        if(!$employee)
            return response([
                'message' => 'No employee found.'
            ], 400);

        return $this->getComputationResponse($employee, false); // false =>isStrict
    }

    /**
     * Portal Access
     */

    public function portalSearch(){
        $user = auth()->user();

        if(!$user->employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        $this->checkUserAccess($user, 'portal request');

        if(!$user->employee)
            return response([
                'message' => 'No employee found.'
            ], 400);

       return $this->getRequestResponse($user->employee);
    }

    public function portalBalance(){
        $user = auth()->user();

        if(!$user->employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        $this->checkUserAccess($user, 'portal request');

        if(!$user->employee)
            return response([
                'message' => 'No employee found.'
            ], 400);

        return response($this->getBalanceOnDisplay($user->employee), 200);
    }

    public function portalProof($leaveLedgerId){
        $user = auth()->user();

        if(!$user->employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        $this->checkUserAccess($user, 'portal request');

        $leaveLedger = LeaveLedger::whereId($leaveLedgerId)->where('employee_id', $user->employee->id)->first();
        if(!$leaveLedger)
            return response([
                'message' => 'Request not found.'
            ], 400);

        $validateData = $this->REQUEST->validate([
            'proof' => 'required|file',
            'proof_type' => 'required'
        ]);

        $leaveLedger->proof = $validateData['proof'];
        $leaveLedger->proof_type = $validateData['proof_type'];

        if($leaveLedger->save())
            return response(null, 204);

        return response([
            'message' => 'Oh no! Something\'s wrong.'
        ], 500);
    }

    public function portalParameter(){
        $user = auth()->user();

        $employee = $user->employee;

        if(!$employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        if(!$employee->hasApprover)
            return response([
                'message' => 'No approver found.'
            ], 404);

        $this->checkUserAccess($user, 'portal request');

        return $this->getParameterResonse();
    }

    public function portalCreate(){
        $user = auth()->user();

        $employee = $user->employee;

        if (!$employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        $this->checkUserAccess($user, 'portal request');

        $body = $this->getPortalBody();

        // check if employees approver is not null
        $approvers = $employee->approver;
        $category = Str::lower(RequestType::find($body['request_type_id'])->category);
        if(!$approvers->{"{$category}_1"})
            return response([
                'message' => 'No approver found.'
            ], 404);


        $ll = $this->createRecord('LeaveLedger', $body);

        return response([
            'message' => 'request successfully created.'
        ], 200);
    }

    public function portalCompute(){
        $user = auth()->user();

        if(!$user->employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        $this->checkUserAccess($user, 'portal request');

        if(!$user->employee)
            return response([
                'message' => 'No employee found.'
            ], 400);

        return $this->getComputationResponse($user->employee);
    }

    public function portalCancel($leaveLedgerId){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal request');

        $leaveLedger = LeaveLedger::whereId($leaveLedgerId)->where('employee_id', $user->employee->id)->first();
        if(!$leaveLedger)
            return response([
                'message' => 'Request not found.'
            ], 400);

        if(!$leaveLedger->isToCancel)
            return response([
                'message' => 'Request cannot be cancelled.'
            ], 400);

        $leaveLedger->status = 4; // cancellation status

        if($leaveLedger->save())
            return response(null, 204);

        return response([
            'message' => 'Oh no! Something\'s wrong.'
        ], 500);
    }

    /**
     * Approver Access
     */

    public function approverSearch($leaveLedgerId = null){
        $user = auth()->user();

        $employee = $user->employee;

        if(!$employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        $leaveLedgers = LeaveLedger::whereIn('status',[1,2,3,5])->get()
                    ->filter(function($item) use ($employee){
                        return $this->isToApprove($employee, $item);
                    })
                    ->map(function($item) use ($employee) {
                        return $this->renderApproverData($item, $employee);
                    });

        // check on empty data
        if($leaveLedgers->isEmpty())
            return response([
                'message' => 'No approver list found.'
            ], 400);

        // Filters
        $filters = $this->listFilter();

        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];

            $leaveLedgers = $leaveLedgers->filter(function ($item) use ($search) {
                return $this->isMatch($item['name'], $search) ||
                    $this->isMatch($item['requestType'], $search);
            });
        }

        if(isset($filters['request_type_id']))
            $leaveLedgers = $leaveLedgers->where('request_type_id', $filters['request_type_id']);

        if(isset($filters['category']))
            $leaveLedgers = $leaveLedgers->where('category', $filters['category']);

        if(isset($filters['isNew']))
            $leaveLedgers = $leaveLedgers->where('isNew', $filters['isNew']);

        if(isset($filters['status']))
            $leaveLedgers = $leaveLedgers->where('status', $filters['status']);

        if(isset($filters['dateFrom']) && isset($filters['dateTo'])) {
            $dateFrom = $filters['dateFrom'];
            $dateTo = $filters['dateTo'];

            $leaveLedgers = $leaveLedgers->filter(function ($item) use ($dateFrom, $dateTo) {
                return $this->isBetweenDates($item['dateFiled'], $dateFrom, $dateTo);
            });
        }

        // count
        $count = $leaveLedgers == [] ? 0 : count($leaveLedgers);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $postRenderData = $this->paginate($leaveLedgers, $perPage, $page);

        return response($postRenderData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function approverApprove($leaveLedgerId){
        $user = auth()->user();

        $employee = $user->employee;

        if(!$employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        $leaveLedger = LeaveLedger::findToApprove($leaveLedgerId);

        if(!$leaveLedger)
            return response([
                'message' => 'Request not found.'
            ], 404);

        $index = $this->getApproverIndex($employee, $leaveLedger->requestType->category, $leaveLedger->employee_id);

        $newApproverStatus = $leaveLedger->approverStatus;
        $newApproverStatus[$index] = 2; // 2 => approve request

        $leaveLedger->approverStatus = $newApproverStatus;

        if($leaveLedger->save())
            return response([
                'message' => 'request approved.'
            ], 200);

        return response([
            'message' => 'Oh no! Something\'s wrong.'
        ], 500);
    }

    public function approverDisapprove($leaveLedgerId){
        $user = auth()->user();

        $employee = $user->employee;

        if(!$employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        $leaveLedger = LeaveLedger::findToApprove($leaveLedgerId);

        if(!$leaveLedger)
            return response([
                'message' => 'Request not found.'
            ], 404);

        $remarks = $this->REQUEST->validate([
            'remarks' => 'required|string'
        ])['remarks'];

        $index = $this->getApproverIndex($employee, $leaveLedger->requestType->category, $leaveLedger->employee_id);

        $newApproverStatus = $leaveLedger->approverStatus;
        $newApproverStatus[$index] = 3; // 3 => disapprove request

        $leaveLedger->approverStatus = $newApproverStatus;
        $leaveLedger->remarks = $remarks;

        if($leaveLedger->save())
            return response([
                'message' => 'request disapproved.'
            ], 200);

        return response([
            'message' => 'Oh no! Something\'s wrong.'
        ], 500);
    }

    public function approverParameter(){
        $user = auth()->user();

        $employee = $user->employee;

        if(!$employee)
            return response([
                'message' => 'Unauthorized. Employee not found.'
            ], 401);

        return response([
            'halfDay' => ['AM','PM'],
            'request_type_id' => RequestType::all()->map(fn($item) => [
                'id' => $item->id,
                'name' => "{$item->code} - {$item->description}"
            ]),
            'category' => ['LEAVES','OB','OVERTIME','REQUEST'],
            'status' => collect($this->requestStatus)->take(5)
        ], 200);
    }

    /**
     * Cron
     */

    public function cronAutomatic(){
        $this->requestAutomatic();

        return response(null, 204);
    }

    public function cronEarn($employeeId = null){
        $body = $this->REQUEST->validate([
            'month' => 'nullable|date_format:m',
            'year' => 'nullable|date_format:Y'
        ]);

        $month = $body['month'] ?? date('m');
        $year = $body['year'] ?? date('Y');

        $this->requestMonthlyEarning($employeeId, $month, $year);

        return response(null, 204);
    }

    public function cronAnnual($employeeId = null){
        $this->requestAnnualEarning($employeeId);

        return response(null, 204);
    }

}