<?php

namespace App\Http\Controllers\Api\History;

use App\Models\Division;
use App\Models\Position;

use App\Models\SalaryGrade;
use Illuminate\Http\Request;
use App\Models\ServiceRecord;
use App\Models\EmploymentStatus;
use App\Models\FundingSource;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation($positionId = null){
        $body = $this->REQUEST->validate([
           'title' => 'required',
           'former_position' => 'nullable',
           'item_number' => 'nullable|max:30',
           'place_of_work' => 'nullable',

           'salary_grade_id' => 'required|exists:salary_grades,id',

           'supervisor_id' => 'nullable|exists:positions,id',

           'division_id' => 'required|exists:divisions,id',

           'classification' => 'required|in:KEY,TECHNICAL,SUPPORT TO THE TECHNICAL,ADMINISTRATIVE',
           'level' => 'required|in:1ST,2ND,3RD',

           'employment_status_id' => 'required|exists:employment_statuses,id',
           'funding_source_id' => 'required|exists:funding_sources,id',

           'supervised_position_title' => 'nullable',
           'supervised_item_number' => 'nullable',

           'contact_internal_executive' => 'nullable|in:OCCASIONAL,FREQUENT',
           'contact_internal_supervisor' => 'nullable|in:OCCASIONAL,FREQUENT',
           'contact_internal_non_supervisor' => 'nullable|in:OCCASIONAL,FREQUENT',
           'contact_internal_staff' => 'nullable|in:OCCASIONAL,FREQUENT',
           'contact_external_public' => 'nullable|in:OCCASIONAL,FREQUENT',
           'contact_external_agencies' => 'nullable|in:OCCASIONAL,FREQUENT',
           'contact_external_others' => 'nullable|max:150',
           'office_work' => 'nullable|in:OCCASIONAL,FREQUENT',
           'field_work' => 'nullable|in:OCCASIONAL,FREQUENT',
           'other_work' => 'nullable',
           'general_function' => 'nullable',
           'job_summary' => 'nullable',
           'education' => 'nullable',
           'experience' => 'nullable',
           'training' => 'nullable',
           'eligibility' => 'nullable',
           'core_compentencies' => 'nullable',
           'core_competency_level' => 'nullable',
           'leadership_competencies' => 'nullable',
           'leadership_compentency_level' => 'nullable',
           'percentage_working_time' => 'nullable',
           'duties_responsibilities' => 'nullable',
           'duties_competency_level' => 'nullable',
           'equipments' => 'nullable|array',
           'equipments.*' => 'required|string',
        ]);

        $isItemNumberCheck = true;
        if($positionId) {
            $position = Position::find($positionId);
            if($position?->item_number == $this->REQUEST?->item_number)
                $isItemNumberCheck = false;
        }

        if($isItemNumberCheck)
            $this->REQUEST->validate(['item_number' => 'unique:positions']);

        return $body;
    }

    private function renderData($entity)
    {
        return [
            'id' => $entity->id,
            'name' => $entity->positionName,
            'item_number' => $entity->item_number,
            'isDeleted' => $entity->is_deleted,
            'is_new' => $entity->is_new
        ];
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search position');

        return response([
            'place_of_work' => Position::groupBy('place_of_work')->pluck('place_of_work'),
            'salary_grade' => SalaryGrade::parameterSG(),
            'supervisor' => Position::supervisorParams(),
            'division' => Division::select('id AS division_id','code','name')->get()->makeHidden('is_new'),
            'classification' =>  ['KEY','TECHNICAL','SUPPORT TO THE TECHNICAL','ADMINISTRATIVE'],
            'level' => ['1ST','2ND','3RD'],
            'employment_status' => EmploymentStatus::select('id','code', 'description')->get()->makeHidden('is_new'),
            'funding_source' => FundingSource::select('id','code', 'description')->get()->makeHidden(['is_new','is_deleted']),
            'equipments' => Position::equipmentsParams(),
        ], 200);
    }

    public function create(){
        $this->checkUserAccess(auth()->user(), 'write position');

        $body = $this->validation();

        $this->createRecord('Position', $body);

        return response(['message' => 'position successfully created.'], 201);
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search position');

        if($id != null) {
            $entity = Position::find($id);

            if($entity == null)
                return response(['message' => 'no position record found.'], 400);

            return response($entity, 200);
        }

        $query = Position::select('*');
        if($this->userCan(auth()->user(), 'restore position'))
            $query = $query->withTrashed();


        $entities = $query->get();
        $returnEntities = $entities->map(function($item, $key) {
            return $this->renderData($item);
        });

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:name,item_number,is_new',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        // filter for search value
        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $returnEntities = $returnEntities->filter(function ($item) use ($search) {
                return $this->isMatch($item['name'], $search) ||
                    $this->isMatch($item['item_number'], $search);
            });
        }

        // filter for asc and desc fields
        if (isset($filters['field'])) {
            $returnEntities = match($filters['order']) {
                 'ASC' => $returnEntities->sortBy($filters['field']),
                 'DESC' => $returnEntities->sortByDesc($filters['field'])
            };
         }

        // count
        $count = $entities == [] ? 0 : count($entities);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $postRenderData = $this->paginate($returnEntities, $perPage, $page);

        return response($postRenderData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write position');

        $body = $this->validation($id);

        $this->updateRecord('Position', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete position');

        // Validate delete
        $isOkOnServiceRecord = !ServiceRecord::where('position_id',$id)->exists();

        if(!$isOkOnServiceRecord)
            return response([
                'message' => 'Position has related record.'
            ], 400);

        $this->deleteRecord('Position', $id);

        return response(null, 204);
    }

    public function restore($id){
        $this->checkUserAccess(auth()->user(), 'restore position');

        $this->restoreRecord('Position', $id);

        return response(null, 204);
    }

}