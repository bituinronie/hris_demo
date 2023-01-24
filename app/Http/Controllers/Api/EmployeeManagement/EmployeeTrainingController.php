<?php

namespace App\Http\Controllers\Api\EmployeeManagement;

use App\Models\Setting;
use App\Models\Training;

use Illuminate\Http\Request;
use App\Models\EmployeeTraining;
use App\Http\Controllers\Controller;

class EmployeeTrainingController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
            'program' => 'required',
            'date_from' => 'required|date_format:Y-m-d|max:'.date('Y-m-d'),
            'date_to' => 'required|date_format:Y-m-d|gte:date_from|max:'.date('Y-m-d'),
            'number_of_hours' => 'required',
            'type_of_ld' => 'required|max:50',
            'sponsored_by' => 'nullable',
            'conducted_by' => 'nullable',
            'location' => 'nullable|in:LOCAL,FOREIGN',
        ]);

        $body['is_foreign'] = null;
        if(isset($body['location']))
            $body['is_foreign'] = $body['location'] == 'FOREIGN'?true:false;


        // split training column & employee_training column
        // on training process
        $training = Training::firstOrCreate([
            "program" => $body['program'],
            "type_of_ld" => $body['type_of_ld'],
            "sponsored_by" => $body['sponsored_by'],
            "conducted_by" => $body['conducted_by'],
            "is_foreign" => $body['is_foreign']
        ]);

        // unsetting unnecessary columns for employee_Training
        unset($body['program']);
        unset($body['type_of_ld']);
        unset($body['sponsored_by']);
        unset($body['conducted_by']);
        unset($body['is_foreign']);
        unset($body['location']);


        // apply training_id
        $body['training_id'] = $training->id;

        $body['show_pds'] = true; // HARD CODED (DON'T REMOVE) for showing on PDS when employee(TAB) changes

        return $body;
    }

    private function returnAllResponse($employeeId){
        $entities = EmployeeTraining::select('*')->where('employee_id', $employeeId)->orderBy('date_from', 'DESC')->get();
        $returnEntities = $entities->map(function($item, $key) {
            return $item->employeeRecord;
        });

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable', // by program, type_of_ld, sponsored_by, conducted_by
            'show_pds' => 'nullable|boolean',
            'location' => 'nullable|in:LOCAL,FOREIGN',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:program,date_from,date_to,number_of_hours,type_of_ld,sponsored_by,conducted_by,location',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        // filter for search value
        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $returnEntities = $returnEntities->filter(function ($item) use ($search) {
                return $this->isMatch($item['program'], $search) ||
                    $this->isMatch($item['type_of_ld'], $search) ||
                    $this->isMatch($item['sponsored_by'], $search) ||
                    $this->isMatch($item['conducted_by'], $search);
            });
        }

        // filter for show_pds
        if (isset($filters['show_pds']))
            $returnEntities = $returnEntities->where('show_pds', $filters['show_pds']);

        // filter for location
        if (isset($filters['location']))
            $returnEntities = $returnEntities->where('location', $filters['location']);

        // filter for asc and desc fields
        if (isset($filters['field'])) {
            $returnEntities = match($filters['order']) {
                 'ASC' => $returnEntities->sortBy($filters['field']),
                 'DESC' => $returnEntities->sortByDesc($filters['field'])
            };
         }

        // return response
        $count = $returnEntities ==[]? 0:count($returnEntities);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $renderedData = $this->paginate($returnEntities, $perPage, $page);

        return response($renderedData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    private function getParameter(){
        // PROGRAM
        $trainings = Training::select('program', 'type_of_ld','sponsored_by','conducted_by','is_foreign')->get();
        $program = $trainings->map(function($item, $key) {
            $item['location'] = null;
            if($item->is_foreign !== null)
                $item['location'] = $item->is_foreign?'FOREIGN':'LOCAL';

            unset($item->is_foreign);

            return $item;
        });

        return [
            'program' => $program,
            'type_of_ld' => Training::groupBy('type_of_ld')->where('type_of_ld', '!=', null)->pluck('type_of_ld'),
            'sponsored_by' => Training::groupBy('sponsored_by')->where('sponsored_by', '!=', null)->pluck('sponsored_by'),
            'conducted_by' => Training::groupBy('conducted_by')->where('conducted_by', '!=', null)->pluck('conducted_by'),
            'location' => ['FOREIGN','LOCAL'],
        ];
    }

    public function create($employeeId){
        $this->checkUserAccess(auth()->user(), 'write employee');
        $this->checkEmployeeId($employeeId);

        $body = $this->validation();
        $body['employee_id'] = $employeeId;

        $this->createRecord('EmployeeTraining', $body);

        return response(['message' => 'employeetraining successfully created.'], 201);
    }

    public function search($employeeId, $id = null){
        $this->checkUserAccess(auth()->user(), 'search employee');
        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = EmployeeTraining::find($id);

            if($entity == null)
                return response(['message' => 'no employee training record found.'], 400);

            return response($entity->employeeRecord, 200);
        }

        return $this->returnAllResponse($employeeId);
    }

    public function searchParameter(){
        $this->checkUserAccess(auth()->user(), 'search employee');

        return response($this->getParameter());
    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write employee');

        $body = $this->validation();

        $this->updateRecord('EmployeeTraining', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete employee');

        $this->deleteRecord('EmployeeTraining', $id);

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

        $this->createRecord('EmployeeTraining', $body);

        return response(['message' => 'employeetraining successfully created.'], 201);
    }

    public function portalSearch($id = null){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');
        $employeeId = $this->checkUserHasEmployee($user);

        if($id != null) {
            $entity = EmployeeTraining::where('id', $id)->where('employee_id', $employeeId)->first();

            if($entity == null)
                return response(['message' => 'no employee training record found.'], 400);

            return response($entity->employeeRecord, 200);
        }

        return $this->returnAllResponse($employeeId);
    }

    public function portalParameter(){
        $this->checkUserAccess(auth()->user(), 'portal employee');

        return response($this->getParameter());
    }

    public function portalUpdate($id){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');
        $employeeId = $this->checkUserHasEmployee($user);

        // is setting update employee
        $isUpdateEmployee = Setting::isUpdateEmployee();
        if(!$isUpdateEmployee)
            return response(['message' => 'Unauthorized'], 401);

        $entity = EmployeeTraining::where('id', $id)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no employee training record found.'], 400);

        $body = $this->validation();

        $this->updateRecord('EmployeeTraining', $id, $body);

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

        $entity = EmployeeTraining::where('id', $id)->where('employee_id', $employeeId)->first();
        if($entity == null)
            return response(['message' => 'no employee training record found.'], 400);

        $this->deleteRecord('EmployeeTraining', $id);

        return response(null, 204);
    }

}