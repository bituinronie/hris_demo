<?php

namespace App\Http\Controllers\Api\TrainingManagement;

use App\Models\Employee;
use App\Models\Training;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\EmployeeTraining;
use App\Http\Controllers\Controller;

class TrainingController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    //********************
    //* Training Admin

    private function createValidation(){
        $body = $this->REQUEST->validate([
            'program' => 'required',

            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d',
            'number_of_hours' => 'required|numeric|min:1',

            'type_of_ld' => 'required|max:50',
            'sponsored_by' => 'nullable',
            'conducted_by' => 'nullable',
            'location' => 'nullable|in:LOCAL,FOREIGN',
            'description' => 'nullable',
        ]);

        $body['is_foreign'] = null;
        if(isset($body['location']))
            $body['is_foreign'] = $body['location'] == 'FOREIGN'?true:false;

        unset($body['location']);

        return $body;
    }

    private function updateValidation(){
        $body = $this->REQUEST->validate([
            'program' => 'required',
            'type_of_ld' => 'required|max:50',
            'sponsored_by' => 'nullable',
            'conducted_by' => 'nullable',
            'location' => 'nullable|in:LOCAL,FOREIGN',
            'description' => 'nullable',
        ]);

        $body['is_foreign'] = null;
        if(isset($body['location']))
            $body['is_foreign'] = $body['location'] == 'FOREIGN'?true:false;

        unset($body['location']);

        return $body;
    }

    private function renderData($column){
        return [
            'id' => $column->id,
            'program' => $column->program,
            'type_of_ld' => $column->type_of_ld,
            'sponsored_by' => $column->sponsored_by,
            'conducted_by' => $column->conducted_by,
            'location' => $column->location,
            'description' => $column->description,
            'created_at' => $column->created_at,
            'updated_at' => $column->updated_at,
            'deleted_at' => $column->deleted_at,
            'isNew' => $column->is_new,
            'isDeleted' => $column->is_deleted,
        ];
    }

    public function create(){
        $this->checkUserAccess(auth()->user(), 'write training');

        $body = $this->createValidation();

        // split training column
        // on training process
        $training = Training::firstOrCreate([
            "program" => $body['program'],
            "type_of_ld" => $body['type_of_ld'],
            "sponsored_by" => $body['sponsored_by'],
            "conducted_by" => $body['conducted_by'],
            "is_foreign" => $body['is_foreign']
        ]);

        // employee training process
        $employeeTraining = EmployeeTraining::firstOrNew([
            'training_id' => $training->id,
            'date_from' => $body['date_from'],
            'date_to' => $body['date_to'],
            'number_of_hours' => $body['number_of_hours'],
        ])->save();

        return response(['message' => 'training successfully created.'], 201);
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search training');

        if($id != null) {
            $entity = Training::find($id);

            if($entity == null)
                return response(['message' => 'no training record found.'], 400);

            return response($this->renderData($entity), 200);
        }

        $query = Training::select('*')->orderBy('program','ASC');

        if($this->userCan(auth()->user(), 'restore training'))
            $query = $query->withTrashed();

        $entities = $query->get()->map(function($item) {
            return $this->renderData($item);
        });

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:program,type_of_ld,sponsored_by,conducted_by,location',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

         // filter for search value
         if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $entities = $entities->filter(function ($item) use ($search) {
                return $this->isMatch($item['program'], $search) ||
                    $this->isMatch($item['type_of_ld'], $search) ||
                    $this->isMatch($item['sponsored_by'], $search) ||
                    $this->isMatch($item['conducted_by'], $search) ||
                    $this->isMatch($item['location'], $search);
            });
        }

        // filter for asc and desc fields
        if (isset($filters['field'])) {
            $entities = match($filters['order']) {
                 'ASC' => $entities->sortBy($filters['field']),
                 'DESC' => $entities->sortByDesc($filters['field'])
            };
         }

        // return response
        $count = $entities ==[]? 0:count($entities);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $renderedData = $this->paginate($entities, $perPage, $page);

        return response($renderedData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search training');

        return response([
            'training' => Training::all()->map(fn($item) => [
                'program' => $item->program,
                'type_of_ld' => $item->type_of_ld,
                'sponsored_by' => $item->sponsored_by,
                'conducted_by' => $item->conducted_by,
                'location' => $item->location,
                'description' => $item->description
            ]),
            'programOnly' => Training::generateAutoSuggest('program'),
            'typeOfLdOnly' => Training::generateAutoSuggest('type_of_ld'),
            'sponsoredByOnly' => Training::generateAutoSuggest('sponsored_by'),
            'conductedByOnly' => Training::generateAutoSuggest('conducted_by'),
            'location' => ['LOCAL', 'FOREIGN']
        ], 200);
    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write training');

        $body = $this->updateValidation();

        $this->updateRecord('Training', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete training');

        $this->deleteRecord('Training', $id);

        return response(null, 204);
    }

    public function restore($id){
        $this->checkUserAccess(auth()->user(), 'restore training');

        $this->restoreRecord('Training', $id);

        return response(null, 204);
    }

    //********************
    //* Training Dates

    public function dateSearch($trainingId){
        $this->checkUserAccess(auth()->user(), 'search training');

        $training = Training::findEvenTrashed($trainingId);
        if($training == null)
            return response(['message' => 'no training record found.'], 400);

        // isset date_from, date_to, number_of_hours
        $body = $this->REQUEST->validate([
            'date_from' => 'nullable|date_format:Y-m-d',
            'date_to' => 'nullable|date_format:Y-m-d',
            'number_of_hours' => 'nullable'
        ]);

        if(isset($body['date_from']) && isset($body['date_to']) && isset($body['number_of_hours'])) {
            $singleRecord = $training->employeeTrainings()->whereDates($body['date_from'],$body['date_to'],$body['number_of_hours'])->first();

            if(!$singleRecord)
                return response([
                    'message' => 'No training dates found.'
                ], 400);

            $employeeRecords = $training->employeeTrainings()->whereDates($body['date_from'],$body['date_to'],$body['number_of_hours'])->where('employee_id','!=',null)->get();

            return response([
                'dateToDisplay' => $singleRecord->dateToDisplay,
                'date_from' => $singleRecord->date_from,
                'date_to' => $singleRecord->date_to,
                'number_of_hours' => $singleRecord->number_of_hours,
                'employeesAssignedCount' => $singleRecord->employeesAssignedCount,
                'employeesAssigned' => $employeeRecords->map(function($item) {
                    $employee = $item->employee;

                    return [
                        'id' => $employee->id,
                        'employee_number' => $employee->employee_number,
                        'name' => Str::upper($employee->name),
                        'dateOfBirth' => Carbon::parse($employee->birth_date)->format('F d, Y'),
                        'certificateOfAppearance' => $item->certificateOfAppearanceUrl,
                        'postTrainingReport' => $item->postTrainingReportUrl,
                        'show_pds' => $item->show_pds,

                    ];
                }),
                'isOkToDelete' => $singleRecord->isOkToDelete
            ], 200);
        }

        $filters = $this->REQUEST->validate([
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
        ]);

        $entities = $training->employeeTrainings()
                        ->groupByDates()
                        ->orderBy('date_from','DESC')
                        ->get()
                        ->map(fn($item) => [
                            'dateToDisplay' => $item->dateToDisplay,
                            'date_from' => $item->date_from,
                            'date_to' => $item->date_to,
                            'number_of_hours' => $item->number_of_hours,
                            'employeesAssignedCount' => $item->employeesAssignedCount,
                            'isOkToDelete' => $item->isOkToDelete
                        ]);

        // return response
        $count = $entities ==[]? 0:count($entities);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $renderedData = $this->paginate($entities, $perPage, $page);

        return response($renderedData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function dateParameter($trainingId){
        $this->checkUserAccess(auth()->user(), 'search training');

        $training = Training::findEvenTrashed($trainingId);
        if($training == null)
            return response(['message' => 'no training record found.'], 400);

        // isset date_from, date_to, number_of_hours
        $body = $this->REQUEST->validate([
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d',
            'number_of_hours' => 'required'
        ]);

        $tickEmployeeIds = $training->employeeTrainings()
                                ->whereDates($body['date_from'],$body['date_to'],$body['number_of_hours'])
                                ->where('employee_id','!=',null)
                                ->pluck('employee_id')
                                ->toArray();

        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
        ]);

        $entities = Employee::all()->map(function($item) use ($tickEmployeeIds) {
            return [
                'id' => $item->id,
                'employee_number' => $item->employee_number,
                'name' => Str::upper($item->nameLastNameFirst),
                'dateOfBirth' => Carbon::parse($item->birth_date)->format('F d, Y'),
                'isTick' => in_array($item->id, $tickEmployeeIds)
            ];
        });

        // filter for search value
        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $entities = $entities->filter(function ($item) use ($search) {
                return $this->isMatch($item['employee_number'], $search) ||
                    $this->isMatch($item['name'], $search);
            });
        }

        // Sort alphabetical
        $entities = $entities->sortBy('name')->sortByDesc('isTick');

        // return response
        $count = $entities ==[]? 0:count($entities);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $renderedData = $this->paginate($entities, $perPage, $page);

        return response($renderedData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function dateCreate($trainingId){
        $this->checkUserAccess(auth()->user(), 'write training');

        $training = Training::findEvenTrashed($trainingId);
        if($training == null)
            return response(['message' => 'no training record found.'], 400);

        $body = $this->REQUEST->validate([
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d',
            'number_of_hours' => 'required|numeric|min:1'
        ]);

         // employee training process
         $employeeTraining = EmployeeTraining::firstOrNew([
            'training_id' => $training->id,
            'date_from' => $body['date_from'],
            'date_to' => $body['date_to'],
            'number_of_hours' => $body['number_of_hours'],
        ])->save();

        return response(['message' => 'training dates successfully created.'], 201);

    }

    public function dateAssign($trainingId){
        $this->checkUserAccess(auth()->user(), 'write training');

        $training = Training::findEvenTrashed($trainingId);
        if($training == null)
            return response(['message' => 'no training record found.'], 400);

        $body = $this->REQUEST->validate([
            'employee_ids' => 'nullable|array',
            'employee_ids.*' => 'required|numeric|exists:employees,id',
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d',
            'number_of_hours' => 'required|numeric|min:1'
        ]);

        // Init employeeIds & employee traning query
        $employeeIds = $body['employee_ids'] ?? [];

        $query = $training->employeeTrainings()
                        ->whereDates($body['date_from'], $body['date_to'], $body['number_of_hours']);

        // Delete employee trainings not on employeeIds
        $query->whereArray('employee_id',$employeeIds,'!=')->delete();

        // Create new record based on employeeIds
        collect($employeeIds)->map(function($employeeId) use ($training, $body) {
            $employeeTraining = EmployeeTraining::firstOrNew([
                'training_id' => $training->id,
                'employee_id' => $employeeId,
                'date_from' => $body['date_from'],
                'date_to' => $body['date_to'],
                'number_of_hours' => $body['number_of_hours'],
            ])->save();
        });

        //check assignEmployeeTraings if null
        if(!$query->first()) {
            // create initial employeeTraining
            $employeeTraining = EmployeeTraining::firstOrNew([
                'training_id' => $training->id,
                'date_from' => $body['date_from'],
                'date_to' => $body['date_to'],
                'number_of_hours' => $body['number_of_hours'],
            ])->save();
        }

        return response(null, 204);
    }

    public function dateUpdate($trainingId){
        $this->checkUserAccess(auth()->user(), 'write training');

        $training = Training::findEvenTrashed($trainingId);
        if($training == null)
            return response(['message' => 'no training record found.'], 400);

        $body = $this->REQUEST->validate([
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d',
            'number_of_hours' => 'required|numeric|min:1',
            'updated_date_from' => 'required|date_format:Y-m-d',
            'updated_date_to' => 'required|date_format:Y-m-d',
            'updated_number_of_hours' => 'required|numeric|min:1'
        ]);

        // updating process
        $training->employeeTrainings()
            ->whereDates($body['date_from'], $body['date_to'], $body['number_of_hours'])
            ->get()
            ->map(function($item) use ($body) {
                $item->date_from = $body['updated_date_from'];
                $item->date_to = $body['updated_date_to'];
                $item->number_of_hours = $body['updated_number_of_hours'];

                $item->save();
            });

        return response(null, 204);
    }

    public function dateDelete($trainingId){
        $this->checkUserAccess(auth()->user(), 'delete training');

        $training = Training::findEvenTrashed($trainingId);
        if($training == null)
            return response(['message' => 'no training record found.'], 400);

        $body = $this->REQUEST->validate([
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d',
            'number_of_hours' => 'required|numeric|min:1'
        ]);

        $singleRecord = $training->employeeTrainings()
                            ->whereDates($body['date_from'], $body['date_to'], $body['number_of_hours'])
                            ->first();

        if(!$singleRecord->isOkToDelete)
            return response([
                'message' => 'traning dates not allowed to delete.'
            ], 400);

        
        $singleRecord = $training->employeeTrainings()
                            ->whereDates($body['date_from'], $body['date_to'], $body['number_of_hours'])
                            ->delete();

        return response(null, 204);
    }


    //********************
    //* Training Portal

    public function portalCalendar($employeeTrainingId = null){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal training');

        if($employeeTrainingId != null) {
            $employeeTraining = EmployeeTraining::find($employeeTrainingId);
            if($employeeTraining == null)
                return response(['message' => 'no employee training record found.'], 400);

            $training = $employeeTraining->training;
            if($training == null)
                return response(['message' => 'no training record found.'], 400);

            return response([
                'trainingId' => $training->id,
                'program' => $training->program,
                'date_from' => Carbon::parse($employeeTraining->date_from)->format('F d, Y'),
                'date_to' => Carbon::parse($employeeTraining->date_to)->format('F d, Y'),
                'number_of_hours' => $employeeTraining->number_of_hours,
                'type_of_ld' => $training->type_of_ld,
                'sponsored_by' => $training->sponsored_by,
                'conducted_by' => $training->conducted_by,
                'location' => $training->location,
                'description' => $training->description,
            ], 200);
        }

        $dateToday = Carbon::now()->format('Y-m-d');

        $entities = EmployeeTraining::groupByDates()
                        ->whereDate('date_from','>=',$dateToday)
                        ->orderBy('date_from','ASC')
                        ->get()
                        ->map(fn($item) => [
                            'trainingId' => $item->training->id,
                            'employeeTrainingId' => $item->id,
                            'title' => $item->training->program,
                            'date_from' => $item->date_from,
                            'date_to' => $item->date_to,
                            'start' => $item->date_from,
                            'end' => Carbon::parse($item->date_to)->addDay()->format('Y-m-d'),
                            'number_of_hours' => $item->number_of_hours
                        ]);

        return response($entities, 200);
    }

    public function portalSearch(){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal training');

        $employee = $user->employee;
        if(!$employee)
            return response([
                'message' => 'user has no employee record.'
            ], 400);

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:program,date_from,date_to,number_of_hours,type_of_ld,sponsored_by,conducted_by,location',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $entities = $employee->trainings()
                        ->orderBy('date_from','DESC')
                        ->get()
                        ->map(fn($item) => [
                            'employeeTrainingId' => $item->id,
                            'trainingId' => $item->training->id,
                            'program' => $item->training->program,
                            'date_from' => Carbon::parse($item->date_from)->format('F d, Y'),
                            'date_to' => Carbon::parse($item->date_to)->format('F d, Y'),
                            'number_of_hours' => $item->number_of_hours,
                            'type_of_ld' => $item->training->type_of_ld,
                            'sponsored_by' => $item->training->sponsored_by,
                            'conducted_by' => $item->training->conducted_by,
                            'location' => $item->training->location,
                            'certificateOfAppearance' => $item->certificateOfAppearanceUrl,
                            'postTrainingReport' => $item->postTrainingReportUrl,
                            'isToAttachProof' => !$item->show_pds,
                            'show_pds' => $item->show_pds
                        ]);

         // filter for search value
         if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $entities = $entities->filter(function ($item) use ($search) {
                return $this->isMatch($item['program'], $search) ||
                    $this->isMatch($item['type_of_ld'], $search) ||
                    $this->isMatch($item['sponsored_by'], $search) ||
                    $this->isMatch($item['conducted_by'], $search) ||
                    $this->isMatch($item['location'], $search);
            });
        }

        // filter for asc and desc fields
        if (isset($filters['field'])) {
            $entities = match($filters['order']) {
                 'ASC' => $entities->sortBy($filters['field']),
                 'DESC' => $entities->sortByDesc($filters['field'])
            };
         }

        // return response
        $count = $entities ==[]? 0:count($entities);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $renderedData = $this->paginate($entities, $perPage, $page);

        return response($renderedData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function portalAttach($employeeTrainingId){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal training');

        $employee = $user->employee;
        if(!$employee)
            return response([
                'message' => 'user has no employee record.'
            ], 400);

        $employeeTraining = $employee->trainings()->whereId($employeeTrainingId)->first();
        if($employeeTraining == null)
            return response(['message' => 'no employee training record found.'], 400);


        $body = $this->REQUEST->validate([
            'certificate_of_appearance' => 'required|file',
            'post_training_report' => 'nullable|file'
        ]);

        if($employeeTraining->certificateOfAppearanceUrl)
            $employeeTraining->getMedia('certificate')->first()->delete();

        $employeeTraining
            ->addMedia($body['certificate_of_appearance'])
            ->toMediaCollection('certificate');

        if (isset($body['post_training_report'])) {
            if ($employeeTraining->postTrainingReportUrl)
                $employeeTraining->getMedia('postTraining')->first()->delete();

            $employeeTraining
                ->addMedia($body['post_training_report'])
                ->toMediaCollection('postTraining');
        }

        return response(null, 204);
    }

}