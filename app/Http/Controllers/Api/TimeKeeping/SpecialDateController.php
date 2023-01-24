<?php

namespace App\Http\Controllers\Api\TimeKeeping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SpecialDate;

class SpecialDateController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'reference_date' => 'required|date_format:Y-m-d',
           'reference_time' => 'nullable|date_format:H:i:s',
           'type' => 'required|in:SPECIAL,LEGAL,SUSPENSION,FLAG_CEREMONY,CALAMITY',
           'description' => 'nullable',
           'employee_group_id' => 'nullable|exists:employee_groups,id',
           'is_fixed' => 'required',
           'is_required' => 'nullable',
           'use_description' => 'required',
        ]);

        return $body;
    }

    private function renderData($column, $year = null){
        return [
            'id' => $column->id,
            'reference_date' => $year != null
                                    ?$column->reference_date->setYear($year)->toDateString()
                                    :$column->reference_date->toDateString(), // setting year to year set on params
            'reference_time' => $column->reference_time?->toTimeString(),
            'type' => $column->type,
            'description' => $column->description,
            'employee_group' => $column->employeeGroup,
            'is_fixed' => $column->is_fixed,
            'is_required' => $column->is_required,
            'use_description' => $column->use_description,
            'created_at' => $column->created_at,
            'updated_at' => $column->updated_at,
            'deleted_at' => $column->deleted_at,
            'isNew' => $column->is_new,
            'isDeleted' => $column->is_deleted,
        ];
    }

    public function create(){
        $this->checkUserAccess(auth()->user(), 'write special date');

        $body = $this->validation();

        $this->createRecord('SpecialDate', $body);

        return response(['message' => 'specialdate successfully created.'], 201);
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search special date');

        if($id != null) {
            $entity = SpecialDate::find($id);

            if($entity == null)
                return response(['message' => 'no special date record found.'], 400);

            return response($this->renderData($entity), 200);
        }

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'year' => 'nullable|date_format:Y',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:reference_date,reference_time,type,description',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $year = $filters['year'] ?? date('Y');

        $query = SpecialDate::initAnnual($year)->orderBy('created_at','DESC');

        if($this->userCan(auth()->user(), 'restore special date'))
            $query = $query->withTrashed();

        // end query
        $entities = $query->get();

        // return response
        $count = $entities ==[]? 0:count($entities);
        $renderedData = $entities->map(function ($item, $key) use ($year) {
            return $this->renderData($item, $year);
        });

        // filtering data
        // default sort for listing desc
        $renderedData = $renderedData->sortByDesc('reference_date');

        // sorting by searchValue
        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $renderedData = $renderedData->filter(function ($item) use ($search) {
                return $this->isMatch($item['description'], $search) ||
                    $this->isMatch($item['type'], $search);
            });
        }

        // filter for asc and desc fields
        if (isset($filters['field'])) {
            $renderedData = match($filters['order']) {
                 'ASC' => $renderedData->sortBy($filters['field']),
                 'DESC' => $renderedData->sortByDesc($filters['field'])
            };
        }

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $postRenderData = $this->paginate($renderedData, $perPage, $page);

        return response($postRenderData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write special date');

        $body = $this->validation();

        $this->updateRecord('SpecialDate', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete special date');

        $this->deleteRecord('SpecialDate', $id);

        return response(null, 204);
    }

    public function restore($id){
        $this->checkUserAccess(auth()->user(), 'restore special date');

        $this->restoreRecord('SpecialDate', $id);

        return response(null, 204);
    }

}