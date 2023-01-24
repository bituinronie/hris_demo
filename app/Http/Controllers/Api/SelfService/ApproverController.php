<?php

namespace App\Http\Controllers\Api\SelfService;

use App\Models\Approver;
use App\Models\Employee;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\EmployeeTrait;
use App\Http\Controllers\Controller;

class ApproverController extends Controller
{
    use EmployeeTrait;

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'leaves_1' => 'nullable|exists:employees,id',
           'leaves_2' => 'nullable|exists:employees,id',
           'leaves_3' => 'nullable|exists:employees,id',
           'ob_1' => 'nullable|exists:employees,id',
           'ob_2' => 'nullable|exists:employees,id',
           'ob_3' => 'nullable|exists:employees,id',
           'overtime_1' => 'nullable|exists:employees,id',
           'overtime_2' => 'nullable|exists:employees,id',
           'overtime_3' => 'nullable|exists:employees,id',
           'request_1' => 'nullable|exists:employees,id',
           'request_2' => 'nullable|exists:employees,id',
           'request_3' => 'nullable|exists:employees,id',
        ]);

        return $body;
    }

    private function renderData($column){
        return [
            'id' => $column->id,
            'leaves_1' => $column->leaves1Data,
            'leaves_2' => $column->leaves2Data,
            'leaves_3' => $column->leaves3Data,
            'ob_1' => $column->ob1Data,
            'ob_2' => $column->ob2Data,
            'ob_3' => $column->ob3Data,
            'overtime_1' => $column->overtime1Data,
            'overtime_2' => $column->overtime2Data,
            'overtime_3' => $column->overtime3Data,
            'request_1' => $column->request1Data,
            'request_2' => $column->request2Data,
            'request_3' => $column->request3Data,
            'created_at' => $column->created_at,
            'updated_at' => $column->updated_at,
            'isNew' => $column->is_new
        ];
    }

    public function search($employeeId = null){
        $this->checkUserAccess(auth()->user(), 'search approver');

        if($employeeId != null) {
            $employee = Employee::findOrFail($employeeId);

            $approver = $employee->approver;

            if($approver == null) {
                $approver = Approver::create();

                $employee->approver_id = $approver->id;
                $employee->save();
            }

            return response($this->renderData($approver), 200);
        }

        return $this->returnResponseAllEmployeesWithSR();
    }

    public function parameter() {
        return response([
            'employees' => Employee::orderBy('created_at', 'DESC')->get()->map(function($item) {
                return [
                    'id' => $item->id,
                    'name' => Str::upper($item->name)
                ];
            })
        ], 200);
    }

    public function update($employeeId){
        $this->checkUserAccess(auth()->user(), 'write approver');

        $body = $this->validation();

        $employee = Employee::findOrFail($employeeId);

        $id = $employee->approver_id;

        if($id == null) {
            $approver = $this->createRecord('Approver', $body);

            $employee->approver_id = $approver->id;
            $employee->save();
        }else {
            $this->updateRecord('Approver', $id, $body);
        }

        return response(null, 204);
    }
    
    public function mass(){
        $this->checkUserAccess(auth()->user(), 'write approver');

        $employeeIds = collect($this->REQUEST->validate([
            'employeeIds' => 'required|array',
            'employeeIds.*' => 'required|exists:employees,id'
        ])['employeeIds']);

        $employeeIds->map(fn($employeeId) => $this->update($employeeId));

        return response(null, 204);

    }
}