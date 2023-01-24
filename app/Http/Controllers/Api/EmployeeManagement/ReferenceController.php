<?php

namespace App\Http\Controllers\Api\EmployeeManagement;

use App\Models\Setting;
use App\Models\Reference;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReferenceController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'name' => 'required|max:150',
           'address' => 'required',
           'telephone' => 'required|max:15',
        ]);

        return $body;
    }

    private function returnAllResponse($employeeId){
        $query = Reference::select('*')->where('employee_id', $employeeId)->orderBy('created_at','DESC');

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:employee_id,name,address,telephone',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if (isset($filters['searchValue'])) {
            $searchVal = $filters['searchValue'];
            $query = $query->where(function($query) use ($searchVal){
                return $query->filter('name', $searchVal)
                            ->orFilter('address', $searchVal)
                            ->orFilter('telephone', $searchVal);
            });
        }

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

        $this->createRecord('Reference', $body);

        return response(['message' => 'reference successfully created.'], 201);
    }

    public function search($employeeId, $id = null){
        $this->checkUserAccess(auth()->user(), 'search employee');
        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = Reference::find($id);

            if($entity == null)
                return response(['message' => 'no reference record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnAllResponse($employeeId);
    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write employee');

        $body = $this->validation();

        $this->updateRecord('Reference', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete employee');

        $this->deleteRecord('Reference', $id);

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

        $this->createRecord('Reference', $body);

        return response(['message' => 'reference successfully created.'], 201);
    }

    public function portalSearch($id = null){
        $user = auth()->user();
        $this->checkUserAccess($user, 'portal employee');
        $employeeId = $this->checkUserHasEmployee($user);

        if($id != null) {
            $entity = Reference::where('id', $id)->where('employee_id', $employeeId)->first();

            if($entity == null)
                return response(['message' => 'no reference record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnAllResponse($employeeId);

    }

    public function portalUpdate($id){
        $user = auth()->user();
        $this->checkUserAccess($user, 'portal employee');
        $employeeId = $this->checkUserHasEmployee($user);

        // is setting update employee
        $isUpdateEmployee = Setting::isUpdateEmployee();
        if(!$isUpdateEmployee)
            return response(['message' => 'Unauthorized'], 401);

        $entity = Reference::where('id', $id)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no reference record found.'], 400);

        $body = $this->validation();

        $this->updateRecord('Reference', $id, $body);

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

        $entity = Reference::where('id', $id)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no reference record found.'], 400);

        $this->deleteRecord('Reference', $id);

        return response(null, 204);
    }

}