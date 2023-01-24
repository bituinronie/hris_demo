<?php

namespace App\Http\Controllers\Api\EmployeeManagement;

use Illuminate\Http\Request;
use App\Models\EmployeeGroup;

use App\Models\ServiceRecord;
use App\Http\Controllers\Controller;

class EmployeeGroupController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation($id = null){
        $body = $this->REQUEST->validate([
           'code' => 'required',
           'description' => 'required',
        ]);

        $isToCheckCode = true;
        if($id) {
            $entity = EmployeeGroup::findOrFail($id);

            if($entity->code == $body['code'])
                $isToCheckCode = false;
        }

        if($isToCheckCode)
            $this->REQUEST->validate(['code' => 'unique:employee_groups']);

        return $body;
    }

    public function create(){
        $this->checkUserAccess(auth()->user(), 'write employee group');

        $body = $this->validation();

        $this->createRecord('EmployeeGroup', $body);

        return response(['message' => 'employeegroup successfully created.'], 201);
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search employee group');

        if($id != null) {
            $entity = EmployeeGroup::find($id);

            if($entity == null)
                return response(['message' => 'no employee group record found.'], 400);

            return response($entity, 200);
        }

        $query = EmployeeGroup::select('*')->orderDesc('created_at');

        if($this->userCan(auth()->user(), 'restore employee group'))
            $query = $query->withTrashed();

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:code,description',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if(isset($filters['searchValue']))
            $query = $query->filter('code', $filters['searchValue'])->orFilter('description', $filters['searchValue']);

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

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write employee group');

        $body = $this->validation($id);

        $this->updateRecord('EmployeeGroup', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete employee group');
        
        // Validate delete
        $isOkOnServiceRecord = !ServiceRecord::where('employee_group_id', $id)->exists();
        if(!$isOkOnServiceRecord)
            return response([
                'message' => 'Employee group has related record'
            ], 400);

        $this->deleteRecord('EmployeeGroup', $id);

        return response(null, 204);
    }

    public function restore($id){
        $this->checkUserAccess(auth()->user(), 'restore employee group');

        $this->restoreRecord('EmployeeGroup', $id);

        return response(null, 204);
    }

}