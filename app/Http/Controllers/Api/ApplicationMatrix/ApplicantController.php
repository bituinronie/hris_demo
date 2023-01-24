<?php

namespace App\Http\Controllers\Api\ApplicationMatrix;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Applicant;

class ApplicantController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'firstName' => 'required',
           'lastName' => 'required',
           'middleName' => 'nullable',
           'nameExtension' => 'nullable|max:10|in:Jr,Sr,I,II,III',

           'civilStatus' => 'required|in:SINGLE,MARRIED,WIDOWED,SEPARATED,OTHERS',
           'birthdate' => 'required|date_format:Y-m-d',
           'height' => 'required|numeric',
           'gender' => 'required|in:MALE,FEMALE',
           'address' => 'required',
           'contactNumber' => 'required|max:25',
           'email' => 'required|email',

           'currentPosition' => 'nullable',
           'employmentStatus' => 'nullable',
           'yearsInCurrentPosition' => 'nullable',

           'college' => 'nullable|array',
           'college.*.course' => 'required|string',
           'college.*.school' => 'required|string',
           'college.*.yearGraduated' => 'nullable|date_format:Y',
           'college.*.units' => 'nullable|integer',

           'workExperience' => 'nullable|array',
           'workExperience.*.position' => 'required|string',
           'workExperience.*.company' => 'required|string',
           'workExperience.*.dateFrom' => 'required|date_format:Y-m',
           'workExperience.*.dateTo' => 'nullable|date_format:Y-m',
        //    'workExperience.*.dateOfEmployment' => 'required|string',

           'training' => 'nullable|array',
           'training.*.title' => 'required|string',
           'training.*.hours' => 'required|integer',
           'training.*.year' => 'required|date_format:Y',

           'eligibility' => 'nullable|array',
           'eligibility.*' => 'nullable|string',

           'positionTitle' => 'required',
           'vacantOnPositions' => 'required',
           'placeOfAssignment' => 'required',
           'dateOfPublication' => 'nullable|date_format:Y-m-d',
           'positionEducation' => 'required',
           'positionTraining' => 'required',
           'positionExperience' => 'required',
           'positionEligibility' => 'required',

           'dateReceived' => 'required|date_format:Y-m-d',
           'remarks' => 'nullable|string',
        ]);

        return $body;
    }

    private function renderData($column){
        return [
            'id' => $column->id,
            'dateReceived' => $column->dateReceived->format('F d, Y'),
            'fullName' => $column->fullName,
            'civilStatus' => $column->civilStatus,
            'age' => $column->age,
            'height' => $column->heightInFeet,
            'gender' => $column->gender,
            'address' => $column->address,
            'contactNumber' => $column->contactNumber,
            'email' => $column->email,

            'positionTitle' => $column->positionTitle,
            'remarks' => $column->remarks,
            'created_at' => $column->created_at,
            'updated_at' => $column->updated_at,
            'isNew' => $column->is_new
        ];
    }

    public function create(){
        $this->checkUserAccess(auth()->user(), 'write applicant');

        $body = $this->validation();

        $this->createRecord('Applicant', $body);

        return response(['message' => 'applicant successfully created.'], 201);
    }

    public function parameter(){
        return response([
            'nameExtension' => ['Jr','Sr','I','II','III'],
            'civilStatus' => ['SINGLE','MARRIED','WIDOWED','SEPARATED','OTHERS'],
            'gender' => ['MALE','FEMALE'],
            'positionTitle' => Applicant::select('positionTitle','vacantOnPositionS','placeOfAssignment','dateOfPublication','positionEducation','positionTraining','positionExperience','positionEligibility')
                                    ->groupBy('positionTitle','vacantOnPositionS','placeOfAssignment','dateOfPublication','positionEducation','positionTraining','positionExperience','positionEligibility')
                                    ->get()
                                    ->map(fn($item) => [
                                        'positionTitle' => $item->positionTitle,
                                        'vacantOnPositions' => $item->vacantOnPositions,
                                        'placeOfAssignment' => $item->placeOfAssignment,
                                        'dateOfPublication' => $item->dateOfPublication?->format('Y-m-d'),
                                        'positionEducation' => $item->positionEducation,
                                        'positionTraining' => $item->positionTraining,
                                        'positionExperience' => $item->positionExperience,
                                        'positionEligibility' => $item->positionEligibility
                                    ])
        ],200);
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search applicant');

        if($id != null) {
            $entity = Applicant::find($id);

            if($entity == null)
                return response(['message' => 'no applicant record found.'], 400);

            return response($entity, 200);
        }

        $returnEntities = Applicant::all()->map(fn($item) => $this->renderData($item));

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:fullName,civilStatus,age,height,gender,address,contactNumber,email,positionTitle',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        // filter for search value
        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];

            $returnEntities = $returnEntities->filter(function ($item) use ($search) {
                return $this->isMatch($item['fullName'], $search) ||
                    $this->isMatch($item['civilStatus'], $search) ||
                    $this->isMatch($item['age'], $search) ||
                    $this->isMatch($item['height'], $search) ||
                    $this->isMatch($item['gender'], $search) ||
                    $this->isMatch($item['address'], $search) ||
                    $this->isMatch($item['contactNumber'], $search) ||
                    $this->isMatch($item['email'], $search) ||
                    $this->isMatch($item['positionTitle'], $search);

            });
        }

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

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write applicant');

        $body = $this->validation();

        $this->updateRecord('Applicant', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete applicant');

        $this->deleteRecord('Applicant', $id);

        return response(null, 204);
    }

}