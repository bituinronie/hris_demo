<?php

namespace App\Http\Controllers\Api;

use App\Models\Token;
use App\Models\Remark;
use App\Models\Division;

use App\Models\Employee;

use App\Traits\TokenTrait;
use Illuminate\Http\Request;
use App\Models\EmployeeGroup;
use App\Models\ServiceRecord;
use App\Traits\ConstantTrait;
use App\Traits\EmployeeTrait;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class TokenController extends Controller
{
    use TokenTrait, ConstantTrait, EmployeeTrait;

    // PHP 8.0
    public function __construct(
        public Request $REQUEST
    ){}

    /**
     * Validation inside token controller
     * 
     * @return object
     */
    private function getBody(){
        $request = $this->REQUEST;

        $body = $request->validate([
            'permission' => 'required|exists:permissions,name',
            'model_name' => 'nullable|array',
        ]);

        $permissionId = Permission::where('name', $body)->first()->id;
        $body['permission_id'] = $permissionId;
        unset($body['permission']);

        $user = auth()->user();
        $body['model_id'] = $user->id;

        return (object) $body;
    }

    /**
     * Generate token
     * 
     * @param $request
     * 
     * @return response
     */
    public function generate(){

        $body = $this->getBody();

        $token = $this->generateToken(
            $body->permission_id,
            $body->model_id, 
            $body->model_name
        );

        return response()->json(['message' => $token], 200);
    }

    public function reportParameter($employeeId = null){
        // init employee
        if($employeeId != null) {
            $employee = Employee::find($employeeId);
            if ($employee == null)
                return response([
                    'message' => 'Employee not found.'
                ], 400);

        }else {
            $user = auth()->user();
            $employee = $user->employee;
        }

        $paramsFunc = function($employee) {
            // employee
            $employeeDisignation = $employee?->designation;

            // supervisor
            $supervisorPosition = $employeeDisignation?->supervisor;
            $supervisorEmployee = $supervisorPosition?->employeeAssignedTo;

            // higher supervisor
            $higherSupervisorPosition = $supervisorPosition?->supervisor;
            $higherSupervisorEmployee = $higherSupervisorPosition?->employeeAssignedTo;

            return [
                'employee' => [
                    'name' => $employee->name ?? null,
                    'position' => $employeeDisignation->positionName ?? null,
                    'division' => $employee->division ?? null
                ],
                'supervisor' => [
                    'name' => $supervisorEmployee->name ?? null,
                    'position' => $supervisorPosition->positionName ?? null,
                    'division' => $supervisorEmployee->division ?? null
                ],
                'higherSupervisor' => [
                    'name' => $higherSupervisorEmployee->name ?? null,
                    'position' => $higherSupervisorPosition->positionName ?? null,
                    'division' => $higherSupervisorEmployee->division ?? null
                ]
            ];
        };

        // suggestions
        $suggestions = Employee::all()->map(function($item, $key) use ($paramsFunc) {
            return $paramsFunc($item);
        });

        return response([
            'self' => $paramsFunc($employee),
            'suggestions' => $suggestions,
            'divisionId' => Division::select('id','name')->get()->makeHidden(['is_new','officeGroupData','is_deleted']),
            'placeOfWork' => ServiceRecord::where('place_of_work', '!=', null)->groupBy('place_of_work')->pluck('place_of_work'),
        ],200);
    }

    public function serviceRecordParameter(){
        return response([
            'remarks' => Remark::where('id', '!=', $this->remarkIdNotApplied)->select('id','code','description')->get(),
            'gender' => ['MALE','FEMALE'],
            'employeeGroup' => EmployeeGroup::select('id','code','description')->get()->makeHidden(['is_new']),
            'placeOfWork' => ServiceRecord::where('place_of_work', '!=', '')->where('place_of_work', '!=', null)->groupBy('place_of_work')->pluck('place_of_work'),
        ], 200);
    }

    public function employeesParameter(){
        return $this->returnResponseEmployeesParameter();
    }

    public function reportPlainParameter(){

        $suggestions = Employee::all()->map(function($item) {
            return [
                'name' => $item->name ?? null,
                'position' => $item->designationName ?? null,
                'division' => $item->division ?? null
            ];
        })->sortBy('name')->values()->toArray();

        return response([
            'suggestion' => $suggestions,
            'divisionId' => Division::select('id','name')->get()->makeHidden(['is_new','officeGroupData','is_deleted']),
            'placeOfWork' => ServiceRecord::where('place_of_work', '!=', null)->groupBy('place_of_work')->pluck('place_of_work'),
        ], 200);
    }

    /**
     * Check token
     * 
     * @param $token
     * 
     * @return response
     */
    public function check(string $token){
        $isValid = Token::findByToken($token) != null? true:false;

        if($isValid)
            return response()->json(null,204);

        return response()->json(['message' => 'Token unauthorized.'], 400);
    }

}
