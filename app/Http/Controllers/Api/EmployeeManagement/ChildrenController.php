<?php

namespace App\Http\Controllers\Api\EmployeeManagement;

use App\Models\Setting;

use App\Models\Children;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChildrenController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'name' => 'required|max:200',
           'birth_date' => 'required|date_format:Y-m-d',
        ]);

        return $body;
    }

    private function returnAllResponse($employeeId){
        $query = Children::select('*')->where('employee_id', $employeeId)->orderBy('created_at','DESC');

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:name,birth_date',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if(isset($filters['searchValue']))
            $query = $query->filter('name', $filters['searchValue']);

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
        // validation
        $this->checkUserAccess(auth()->user(), 'write employee');
        $this->checkEmployeeId($employeeId);

        $body = $this->validation();
        $body['employee_id'] = $employeeId;

        // creating record
        $this->createRecord('Children', $body);

        return response(['message' => 'children successfully created.'], 201);
    }

    public function search($employeeId, $id = null){
        $this->checkUserAccess(auth()->user(), 'search employee');
        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = Children::find($id);

            if($entity == null)
                return response(['message' => 'no children record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnAllResponse($employeeId);

    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write employee');

        $body = $this->validation();

        $this->updateRecord('Children', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete employee');

        $this->deleteRecord('Children', $id);

        return response(null, 204);
    }

    public function portalSearch($childrenId = null){
        $user = auth()->user();
        $this->checkUserAccess($user, 'portal employee');

        $employeeId = $this->checkUserHasEmployee($user);

        if($childrenId != null) {
            $entity = Children::where('id',$childrenId)->where('employee_id', $employeeId)->first();
            if($entity == null)
                return response(['message' => 'no children record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnAllResponse($employeeId);
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

        // creating record
        $this->createRecord('Children', $body);

        return response(['message' => 'children successfully created.'], 201);
    }

    public function portalUpdate($childrenId){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');

        $employeeId = $this->checkUserHasEmployee($user);

        // is setting update employee
        $isUpdateEmployee = Setting::isUpdateEmployee();
        if(!$isUpdateEmployee)
            return response(['message' => 'Unauthorized'], 401);
        

        $body = $this->validation();
        $entity = Children::where('id',$childrenId)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no children record found.'], 400);

        $this->updateRecord('Children', $childrenId, $body);

        return response(null, 204);
    }

    public function portalDelete($childrenId){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');

        $employeeId = $this->checkUserHasEmployee($user);

        // is setting update employee
        $isUpdateEmployee = Setting::isUpdateEmployee();
        if(!$isUpdateEmployee)
            return response(['message' => 'Unauthorized'], 401);
        

        $entity = Children::where('id',$childrenId)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no children record found.'], 400);

        $this->deleteRecord('Children', $childrenId);

        return response(null, 204);
    }

}