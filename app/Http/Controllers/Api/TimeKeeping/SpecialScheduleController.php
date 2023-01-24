<?php

namespace App\Http\Controllers\Api\TimeKeeping;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

use App\Models\SpecialSchedule;
use App\Http\Controllers\Controller;

class SpecialScheduleController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation($specialScheduleId = null){
        $body = $this->REQUEST->validate([
            'code' => 'required|max:50',
            'description' => 'required|max:150',
            'ref_date' => 'required|date_format:Y-m-01',
            'template' => 'required|array',
        ]);

        $period = CarbonPeriod::create($body['ref_date'], date('Y-m-t', strtotime($body['ref_date'])));

        // Iterate over the period
        foreach ($period as $date) {
            $dateKey = $date->format('Y-m-d');
            
            $this->REQUEST->validate([
                "template.$dateKey" => 'required|array',
                "template.$dateKey.time_in" => 'nullable|date_format:H:i:s',
                "template.$dateKey.lunch_out" => 'nullable|date_format:H:i:s',
                "template.$dateKey.lunch_in" => 'nullable|date_format:H:i:s',
                "template.$dateKey.time_out" => 'nullable|date_format:H:i:s',
            ]);

            if(!isset($body['template'][$dateKey]['time_in']))
                $body['template'][$dateKey]['time_in'] = null;
            
            if(!isset($body['template'][$dateKey]['lunch_out']))
                $body['template'][$dateKey]['lunch_out'] = null;
            
            if(!isset($body['template'][$dateKey]['lunch_in']))
                $body['template'][$dateKey]['lunch_in'] = null;
            
            if(!isset($body['template'][$dateKey]['time_out']))
                $body['template'][$dateKey]['time_out'] = null;
        }

        $isCodeCheck = true;
        if($specialScheduleId) {
            $schedule = SpecialSchedule::find($specialScheduleId);
            if($schedule?->code == $this->REQUEST?->code)
                $isCodeCheck = false;
        }

        if($isCodeCheck)
            $this->REQUEST->validate(['code' => 'unique:special_schedules']);


        return $body;
    }

    private function renderData($column){
        return [
            'id' => $column->id,
            'code' => $column->code,
            'description' => $column->description,
            'ref_date' => $column->ref_date->format('Y-m-d'),
            'template' => $column->template,
            'created_at' => $column->created_at,
            'updated_at' => $column->updated_at,
            'deleted_at' => $column->deleted_at,
            'isNew' => $column->is_new,
            'isDeleted' => $column->is_deleted,
        ];
    }

    public function create(){
        $this->checkUserAccess(auth()->user(), 'write schedule');

        $body = $this->validation();

        $this->createRecord('SpecialSchedule', $body);

        return response(['message' => 'specialschedule successfully created.'], 201);
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search schedule');

        if($id != null) {
            $entity = SpecialSchedule::find($id);

            if($entity == null)
                return response(['message' => 'no special schedule record found.'], 400);

            return response($this->renderData($entity), 200);
        }

        $query = SpecialSchedule::select('*');

        if($this->userCan(auth()->user(), 'restore schedule'))
            $query = $query->withTrashed();

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'ref_date' => 'nullable|date_format:Y-m-01',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:code,description,ref_date',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        if(isset($filters['ref_date']))
            $query = $query->where('ref_date', $filters['ref_date']);

        if (isset($filters['searchValue'])) {
            $searchVal = $filters['searchValue'];

            $query = $query->where(function($query) use ($searchVal){
                return $query->filter('code', $searchVal)
                            ->orFilter('description', $searchVal);
            });
        }

        if (isset($filters['field']))
           $query = $query->orderBy($filters['field'], $filters['order']);

        // end query
        $entities = $query->get();

        // return response
        $count = $entities ==[]? 0:count($entities);
        $renderedData = $entities->map(function ($item, $key) {
            return $this->renderData($item);
        });

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
        $this->checkUserAccess(auth()->user(), 'write schedule');

        $body = $this->validation($id);

        $this->updateRecord('SpecialSchedule', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete schedule');

        $this->deleteRecord('SpecialSchedule', $id);

        return response(null, 204);
    }

    public function restore($id){
        $this->checkUserAccess(auth()->user(), 'restore schedule');

        $this->restoreRecord('SpecialSchedule', $id);

        return response(null, 204);
    }

}