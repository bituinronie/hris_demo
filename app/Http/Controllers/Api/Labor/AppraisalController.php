<?php

namespace App\Http\Controllers\Api\Labor;

use App\Models\Appraisal;
use Illuminate\Http\Request;

use App\Traits\ConstantTrait;
use App\Traits\EmployeeTrait;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class AppraisalController extends Controller
{
    use EmployeeTrait, ConstantTrait;

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
            'date' => 'required|date_format:Y-m-d',
            'monthFrom' => 'nullable|date_format:m',
            'monthTo' => 'nullable|date_format:m',
            'remarks' => 'nullable',
            'semester' => 'required|in:1ST,2ND,OTHERS',
        ]);

        if ($body['semester'] == 'OTHERS')
            $this->REQUEST->validate([
                'monthFrom' => 'required',
                'monthTo' => 'required',
                'remarks' => 'required'
            ]);

        return $body;
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search appraisal');

        return response([
            'semester' => ['1ST','2ND','OTHERS'],
            'adjectivalRating' => $this->adjectivalRating,
        ], 200);
    }

    public function stats($id){
        $this->checkUserAccess(auth()->user(), 'search appraisal');

        $entity = Appraisal::find($id);

        if($entity == null)
            return response(['message' => 'no appraisal record found.'], 400);

        return response([
            'numericRating' => $entity->numericRating,
            'adjectivalRating' => $entity->adjectivalRating,
        ], 200);
    }

    public function create($employeeId){
        $this->checkUserAccess(auth()->user(), 'write appraisal');

        $this->checkEmployeeId($employeeId);

        $body = $this->validation();

        $appraisalData = Appraisal::whereYear('date','=',Carbon::parse($body['date'])->format('Y'))
                                ->where('employee_id',$employeeId)
                                ->where('semester',$body['semester'])
                                ->first();

        if(isset($appraisalData->id))
            return response(['message' =>'semester already saved'], 400);

        $body['employee_id'] = $employeeId;

        $this->createRecord('Appraisal', $body);

        return response(['message' => 'appraisal successfully created.'], 201);
    }

    public function search($employeeId = null, $id = null){
        $this->checkUserAccess(auth()->user(), 'search appraisal');

        if($employeeId == null)
            return $this->returnResponseAllEmployees();

        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = Appraisal::find($id);

            if($entity == null)
                return response(['message' => 'no appraisal record found.'], 400);

            return response($entity, 200);
        }

        $query = Appraisal::select('*')->where('employee_id', $employeeId);

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'year' => 'nullable|date_format:Y',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:date,semester',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if (isset($filters['searchValue']))
            $query = $query->filter('semester', $filters['searchValue']);

        if (isset($filters['year']))
            $query = $query->whereYear('date', $filters['year']);

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
        $this->checkUserAccess(auth()->user(), 'write appraisal');

        $body = $this->validation();

        $this->updateRecord('Appraisal', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete appraisal');

        // TODO: check isOkToDelete

        $this->deleteRecord('Appraisal', $id);

        return response(null, 204);
    }
}