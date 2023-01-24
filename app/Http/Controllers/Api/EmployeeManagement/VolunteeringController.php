<?php

namespace App\Http\Controllers\Api\EmployeeManagement;

use App\Models\Setting;
use App\Models\Volunteering;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VolunteeringController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'organization' => 'required',
           'date_from' => 'required|date_format:Y-m-d',
           'date_to' => 'nullable|date_format:Y-m-d',
           'number_of_hours' => 'required|max:1000',
           'position' => 'required',
           'nature_of_work' => 'required|max:100',
        ]);

        return $body;
    }

    private function getParameter(){
        return [
            'organization' => Volunteering::groupBy('organization')->pluck('organization'),
            'position' => Volunteering::groupBy('position')->pluck('position'),
            'nature_of_work' => Volunteering::groupBy('nature_of_work')->pluck('nature_of_work'),
        ];
    }

    private function returnAllResponse($employeeId){
        $query = Volunteering::select('*')->where('employee_id', $employeeId)->orderBy('date_from','DESC');

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:organization,date_from,date_to,number_of_hours,position,nature_of_work',
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

        $this->createRecord('Volunteering', $body);

        return response(['message' => 'volunteering successfully created.'], 201);
    }

    public function search($employeeId, $id = null){
        $this->checkUserAccess(auth()->user(), 'search employee');
        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = Volunteering::find($id);

            if($entity == null)
                return response(['message' => 'no volunteering record found.'], 400);

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

        $this->updateRecord('Volunteering', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete employee');

        $this->deleteRecord('Volunteering', $id);

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

        $this->createRecord('Volunteering', $body);

        return response(['message' => 'volunteering successfully created.'], 201);
    }

    public function portalSearch($id = null){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');
        $employeeId = $this->checkUserHasEmployee($user);

        if($id != null) {
            $entity = Volunteering::where('id',$id)->where('employee_id', $employeeId)->first();

            if($entity == null)
                return response(['message' => 'no volunteering record found.'], 400);

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

        $entity = Volunteering::where('id',$id)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no volunteering record found.'], 400);

        $body = $this->validation();

        $this->updateRecord('Volunteering', $id, $body);

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

        $entity = Volunteering::where('id',$id)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no volunteering record found.'], 400);

        $this->deleteRecord('Volunteering', $id);

        return response(null, 204);
    }

}