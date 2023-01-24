<?php

namespace App\Http\Controllers\Api\History;

use App\Models\Position;
use App\Models\SalaryGrade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalaryGradeController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'salary_grade' => 'required',
           'step' => 'required',
           'salary' => 'required|numeric',
        ]);

        return $body;
    }

    private function createValidation($tranche){
        $body = collect($this->REQUEST->validate([
            '*' => 'array|required',
            '*.salary_grade' => 'required',
            '*.step' => 'required',
            '*.salary' => 'required'
        ]))->map(function($item) use($tranche) {
            return [
                'tranche' => $tranche,
                'salary_grade' => $item['salary_grade'],
                'step' => $item['step'],
                'salary' => $item['salary'],
            ];
        });

        return $body;
    }

    public function create($tranche = null){
        $this->checkUserAccess(auth()->user(), 'write salary grade');

        if($tranche === null) {
            $newTranche = $this->initNewTranche();

            return response([
                'message' => 'new tranche on salary grade successfully created.',
                'data' => $newTranche
            ], 201);
        }

        $body = $this->createValidation($tranche);

        $body->map(fn($item) => SalaryGrade::updateOrCreate([
            'tranche' => $item['tranche'],
            'salary_grade' => $item['salary_grade'],
            'step' => $item['step']
        ],[
            'salary' => $item['salary']
        ]));

        return response(['message' => 'salarygrade successfully created.'], 201);
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search salary grade');

        return response([
            'tranche' => SalaryGrade::groupBy('tranche')->pluck('tranche')
        ], 200);
    }

    public function search($tranche, $id = null){
        $this->checkUserAccess(auth()->user(), 'search salary grade');

        if($id != null) {
            $entity = SalaryGrade::find($id);

            if($entity == null)
                return response(['message' => 'no salary grade record found.'], 400);

            return response($entity, 200);
        }

        $query = SalaryGrade::select('*')->where('tranche', $tranche);

        if($this->userCan(auth()->user(), 'restore salary grade'))
            $query = $query->withTrashed();

        // Filters
        $filters = $this->REQUEST->validate([
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:salary_grade,step,salary',
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

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write salary grade');

        $body = $this->validation();

        $this->updateRecord('SalaryGrade', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete salary grade');

        // Validate delete
        $isOkOnPosition = !Position::where('salary_grade_id', $id)->exists();

        if(!$isOkOnPosition)
            return response([
                'message' => 'Salary Grade has related records.'
            ], 400);

        $this->deleteRecord('SalaryGrade', $id);

        return response(null, 204);
    }

    public function restore($id){
        $this->checkUserAccess(auth()->user(), 'restore salary grade');

        $this->restoreRecord('SalaryGrade', $id);

        return response(null, 204);
    }

    private function initNewTranche()
    {
        // get the last salary grade record based on last trache
        $lastTranche = SalaryGrade::orderBy('tranche', 'DESC')->first()->tranche ?? 0;

        // increment tranche
        $newTranche = $lastTranche+1;

        // create record based on incremented tranche
        $newRecord = [
            'tranche' => $newTranche,
            'salary_grade' => 1,
            'step' => 1,
            'salary' => 0.00
        ];

        $this->createRecord('SalaryGrade', $newRecord);

        // return new tranche
        return $newTranche;
    }

}