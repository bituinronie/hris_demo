<?php

namespace App\Http\Controllers\Api\EmployeeManagement;

use App\Models\Setting;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\WorkExperience;
use App\Http\Controllers\Controller;

class WorkExperienceController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
            'position' => 'required|max:150',
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'nullable',
            'company' => 'required',
            'salary' => 'required|numeric',
            'pay_grade' => 'required|max:50',
            'status_of_appointment' => 'nullable|max:200',
            'sector' => 'nullable',
            'is_government_service' => 'required|boolean',
        ]);

        $isCheckDateTo = true;

        if(isset($body['date_to'])) {
            if(Str::lower($body['date_to']) === 'present' || $body['date_to'] == null) {
                $body['date_to'] = null;
                $isCheckDateTo = false;
            }
        }

        if($isCheckDateTo)
            $this->REQUEST->validate(['date_to' => 'date_format:Y-m-d']);

        return $body;
    }

    private function getParameter(){
        return [
            'position' => WorkExperience::groupBy('position')->pluck('position'),
            'company' => WorkExperience::groupBy('company')->pluck('company'),
            'status_of_appointment' => WorkExperience::groupBy('status_of_appointment')->pluck('status_of_appointment'),
            'sector' => WorkExperience::groupBy('sector')->pluck('sector'),
        ];
    }

    private function returnAllResponse($employeeId){
        $query = WorkExperience::select('*')->where('employee_id', $employeeId)->orderBy('date_from','DESC');

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:position,date_from,date_to,company,salary,pay_grade,status_of_appointment,sector,is_government_service',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if (isset($filters['field']))
           $query = $query->orderBy($filters['field'], $filters['order']);

        // return response
        $count = $query->get() ==[]? 0:count($query->get());

        // paginate
        $entities = $query->paginate($filters['perPage']);

        return response($entities)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function create($employeeId){
        $this->checkUserAccess(auth()->user(), 'write employee');
        $this->checkEmployeeId($employeeId);

        $body = $this->validation();
        $body['employee_id'] = $employeeId;

        $this->createRecord('WorkExperience', $body);

        return response(['message' => 'workexperience successfully created.'], 201);
    }

    public function search($employeeId, $id = null){
        $this->checkUserAccess(auth()->user(), 'search employee');
        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = WorkExperience::find($id);

            if($entity == null)
                return response(['message' => 'no work experience record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnAllResponse($employeeId);
    }

    public function searchParameter(){
        $this->checkUserAccess(auth()->user(), 'search employee');

        return response($this->getParameter(), 200);
    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write employee');

        $body = $this->validation();

        $this->updateRecord('WorkExperience', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete employee');

        $this->deleteRecord('WorkExperience', $id);

        return response(null, 204);
    }

    public function portalCreate(){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');
        $employeeId = $this->checkUserHasEmployee($user);

        // is setting update employee
        $isUpdateEmployee = Setting::isUpdateEmployee();
        if(!$isUpdateEmployee)
            return response(['message' => 'Unauthorized'], 401);

        $body = $this->validation();
        $body['employee_id'] = $employeeId;

        $this->createRecord('WorkExperience', $body);

        return response(['message' => 'workexperience successfully created.'], 201);
    }

    public function portalSearch($id = null){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');
        $employeeId = $this->checkUserHasEmployee($user);

        if($id != null) {
            $entity = WorkExperience::where('id',$id)->where('employee_id', $employeeId)->first();

            if($entity == null)
                return response(['message' => 'no work experience record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnAllResponse($employeeId);

    }

    public function portalParameter(){
        $this->checkUserAccess(auth()->user(), 'portal employee');

        return response($this->getParameter(), 200);
    }

    public function portalUpdate($id){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');
        $employeeId = $this->checkUserHasEmployee($user);

        // is setting update employee
        $isUpdateEmployee = Setting::isUpdateEmployee();
        if(!$isUpdateEmployee)
            return response(['message' => 'Unauthorized'], 401);

        $entity = WorkExperience::where('id',$id)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no work experience record found.'], 400);

        $body = $this->validation();

        $this->updateRecord('WorkExperience', $id, $body);

        return response(null, 204);
    }

    public function portalDelete($id){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');
        $employeeId = $this->checkUserHasEmployee($user);

        // is setting update employee
        $isUpdateEmployee = Setting::isUpdateEmployee();
        if(!$isUpdateEmployee)
            return response(['message' => 'Unauthorized'], 401);

        $entity = WorkExperience::where('id',$id)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no work experience record found.'], 400);

        $this->deleteRecord('WorkExperience', $id);

        return response(null, 204);
    }

}