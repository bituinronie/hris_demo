<?php

namespace App\Http\Controllers\Api\Labor;

use App\Models\Offense;
use Illuminate\Http\Request;

use App\Traits\EmployeeTrait;
use App\Http\Controllers\Controller;

class OffenseController extends Controller
{
    use EmployeeTrait;

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'recieved_date' => 'required|date_format:Y-m-d',
           'type' => 'required',
           'offense' => 'required',
           'corrective_action_taken' => 'required',
           'status' => 'required',
           'remarks' => 'nullable',
           'memo_date' => 'required|date_format:Y-m-d',
        ]);

        return $body;
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search offense');

        return response([
            'type' => Offense::generateAutoSuggest('type'),
            'offense' => Offense::generateAutoSuggest('offense'),
            'corrective_action_taken' => Offense::generateAutoSuggest('corrective_action_taken'),
            'status' => Offense::generateAutoSuggest('status')
        ], 200);
    }

    public function create($employeeId){
        $this->checkUserAccess(auth()->user(), 'write offense');

        $this->checkEmployeeId($employeeId);

        $body = $this->validation();

        $body['employee_id'] = $employeeId;

        $this->createRecord('Offense', $body);

        return response(['message' => 'offense successfully created.'], 201);
    }

    public function search($employeeId = null, $id = null){
        $this->checkUserAccess(auth()->user(), 'search offense');

        if($employeeId == null)
            return $this->returnResponseAllEmployees();

        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = Offense::find($id);

            if($entity == null)
                return response(['message' => 'no offense record found.'], 400);

            return response($entity, 200);
        }

        $query = Offense::select('*')->where('employee_id', $employeeId);

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:recieved_date,type,offense,corrective_action_taken,status,remarks,memo_date',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if(isset($filters['searchValue']))
            $query = $query->filter('type', $filters['searchValue'])
                            ->orFilter('offense', $filters['searchValue'])
                            ->orFilter('status', $filters['searchValue'])
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
        $this->checkUserAccess(auth()->user(), 'write offense');

        $body = $this->validation();

        $this->updateRecord('Offense', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete offense');

        $this->deleteRecord('Offense', $id);

        return response(null, 204);
    }

}