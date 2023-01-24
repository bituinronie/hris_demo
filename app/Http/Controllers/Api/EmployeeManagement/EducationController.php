<?php

namespace App\Http\Controllers\Api\EmployeeManagement;

use App\Models\Setting;
use App\Models\Education;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EducationController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
            'level' => 'required|in:ELEMENTARY,SECONDARY,VOCATIONAL,COLLEGE,GRADUATE STUDIES',
            'school_name' => 'required',
            'course' => 'nullable',
            'attended_from' => 'required|numeric|date_format:Y|max:'.date('Y'),
            'attended_to' => 'nullable|numeric|date_format:Y|gte:attended_from|max:'.date('Y'),
            'graduated' => 'nullable|boolean',
            'year_graduated' => 'nullable|numeric|date_format:Y|max:'.date('Y'),
            'highest_level' => 'nullable',
            'honors' => 'nullable',
        ]);

        return $body;
    }

    private function getParameter(){
        return [
            'level' => ['ELEMENTARY','SECONDARY','VOCATIONAL','COLLEGE','GRADUATE STUDIES'],
            'school_name' => Education::groupBy('school_name')->where('school_name', '!=', null)->pluck('school_name'),
            'course' => Education::groupBy('course')->where('course', '!=', null)->pluck('course'),
            'highest_level' => Education::groupBy('highest_level')->where('highest_level', '!=', null)->pluck('highest_level'),
            'honors' => Education::groupBy('honors')->where('honors', '!=', null)->pluck('honors'),
        ];
    }

    private function returnAllResponse($employeeId){
        $query = Education::select('*')->where('employee_id', $employeeId)->orderBy('attended_from','DESC');

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'level' => 'nullable|in:ELEMENTARY,SECONDARY,VOCATIONAL,COLLEGE,GRADUATE STUDIES',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:level,school_name,course,attended_from,attended_to,graduated,highest_level,year_graduated,honors',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if (isset($filters['searchValue'])) {
            $searchVal = $filters['searchValue'];

            $query = $query->where(function($query) use ($searchVal){
                return $query->filter('school_name', $searchVal)
                            ->orFilter('course', $searchVal)
                            ->orFilter('highest_level', $searchVal)
                            ->orFilter('honors', $searchVal);
            });
        }

        if (isset($filters['level']))
            $query = $query->where('level', $filters['level']);

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

        $this->createRecord('Education', $body);

        return response(['message' => 'education successfully created.'], 201);
    }

    public function search($employeeId, $id = null){
        $this->checkUserAccess(auth()->user(), 'search employee');
        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = Education::find($id);

            if($entity == null)
                return response(['message' => 'no education record found.'], 400);

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

        $this->updateRecord('Education', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete employee');

        $this->deleteRecord('Education', $id);

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

        $this->createRecord('Education', $body);

        return response(['message' => 'education successfully created.'], 201);
    }

    public function portalSearch($id = null){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');
        $employeeId = $this->checkUserHasEmployee($user);

        if($id != null) {
            $entity = Education::where('id',$id)->where('employee_id', $employeeId)->first();

            if($entity == null)
                return response(['message' => 'no education record found.'], 400);

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

        $entity = Education::where('id',$id)->where('employee_id', $employeeId)->first();

        if($entity == null)
            return response(['message' => 'no education record found.'], 400);


        $body = $this->validation();

        $this->updateRecord('Education', $id, $body);

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

        $entity = Education::where('id',$id)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no education record found.'], 400);

        $this->deleteRecord('Education', $id);

        return response(null, 204);
    }
}