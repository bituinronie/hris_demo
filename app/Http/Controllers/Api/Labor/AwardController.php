<?php

namespace App\Http\Controllers\Api\Labor;

use App\Models\Award;
use Illuminate\Http\Request;

use App\Traits\EmployeeTrait;
use App\Http\Controllers\Controller;

class AwardController extends Controller
{
    use EmployeeTrait;

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'date_awarded' => 'required|date_format:Y-m-d',
           'type' => 'required',
           'activity' => 'required',
           'remarks' => 'nullable',
        ]);

        return $body;
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search award');

        return response([
            'type' => Award::generateAutoSuggest('type'),
            'activity' => Award::generateAutoSuggest('activity')
        ], 200);
    }

    public function create($employeeId){
        $this->checkUserAccess(auth()->user(), 'write award');

        $this->checkEmployeeId($employeeId);

        $body = $this->validation();

        $body['employee_id'] = $employeeId;

        $this->createRecord('Award', $body);

        return response(['message' => 'award successfully created.'], 201);
    }

    public function search($employeeId = null, $id = null){
        $this->checkUserAccess(auth()->user(), 'search award');

        if($employeeId == null)
            return $this->returnResponseAllEmployees();

        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = Award::find($id);

            if($entity == null)
                return response(['message' => 'no award record found.'], 400);

            return response($entity, 200);
        }

        $query = Award::select('*')->where('employee_id', $employeeId);

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:date_awarded,type,activity,remarks',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if(isset($filters['searchValue']))
            $query = $query->filter('type', $filters['searchValue'])
                            ->orFilter('activity', $filters['searchValue'])
                            ->orFilter('remarks', $filters['searchValue']);

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
        $this->checkUserAccess(auth()->user(), 'write award');

        $body = $this->validation();

        $this->updateRecord('Award', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete award');

        $this->deleteRecord('Award', $id);

        return response(null, 204);
    }

}