<?php

namespace App\Http\Controllers\Api\EmployeeManagement;

use App\Models\Setting;
use App\Models\Eligibility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EligibilityController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'type' => 'required',
           'rating' => 'nullable|numeric',
           'date_conferment' => 'required|date_format:Y-m-d',
           'place_conferment' => 'required',
           'license_number' => 'nullable|max:50',
           'license_validity' => 'nullable|date_format:Y-m-d',
        ]);

        return $body;
    }

    private function getParameter(){
        return [
            'type' => Eligibility::groupBy('type')->pluck('type'),
            'place_conferment' => Eligibility::groupBy('place_conferment')->pluck('place_conferment'),
        ];
    }

    private function returnAllResponse($employeeId){
        $query = Eligibility::select('*')->where('employee_id', $employeeId)->orderBy('date_conferment','DESC');

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:type,rating,date_conferment,place_conferment,license_number,license_validity',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if (isset($filters['searchValue']))
            $query = $query->filter('type', $filters['searchValue']);

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

        $this->createRecord('Eligibility', $body);

        return response(['message' => 'eligibility successfully created.'], 201);
    }

    public function search($employeeId, $id = null){
        $this->checkUserAccess(auth()->user(), 'search employee');
        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = Eligibility::find($id);

            if($entity == null)
                return response(['message' => 'no eligibility record found.'], 400);

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

        $this->updateRecord('Eligibility', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete employee');

        $this->deleteRecord('Eligibility', $id);

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

        $this->createRecord('Eligibility', $body);

        return response(['message' => 'eligibility successfully created.'], 201);
    }

    public function portalSearch($id = null){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');
        $employeeId = $this->checkUserHasEmployee($user);

        if($id != null) {
            $entity = Eligibility::where('id',$id)->where('employee_id', $employeeId)->first();

            if($entity == null)
                return response(['message' => 'no eligibility record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnAllResponse($employeeId);

        return response([], 200);

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

        $entity = Eligibility::where('id',$id)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no eligibility record found.'], 400);

        $body = $this->validation();

        $this->updateRecord('Eligibility', $id, $body);

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

        $entity = Eligibility::where('id',$id)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no eligibility record found.'], 400);

        $this->deleteRecord('Eligibility', $id);

        return response(null, 204);
    }

}