<?php

namespace App\Http\Controllers\Api\TimeKeeping;

use App\Models\Setting;
use App\Models\Schedule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation($scheduleId = null){
        $body = $this->REQUEST->validate([
           'code' => 'required|max:50',
           'description' => 'required|max:150',
           'mon_time_in' => 'nullable|date_format:H:i:s',
           'mon_lunch_out' => 'nullable|date_format:H:i:s',
           'mon_lunch_in' => 'nullable|date_format:H:i:s',
           'mon_time_out' => 'nullable|date_format:H:i:s',
           'tue_time_in' => 'nullable|date_format:H:i:s',
           'tue_lunch_out' => 'nullable|date_format:H:i:s',
           'tue_lunch_in' => 'nullable|date_format:H:i:s',
           'tue_time_out' => 'nullable|date_format:H:i:s',
           'wed_time_in' => 'nullable|date_format:H:i:s',
           'wed_lunch_out' => 'nullable|date_format:H:i:s',
           'wed_lunch_in' => 'nullable|date_format:H:i:s',
           'wed_time_out' => 'nullable|date_format:H:i:s',
           'thu_time_in' => 'nullable|date_format:H:i:s',
           'thu_lunch_out' => 'nullable|date_format:H:i:s',
           'thu_lunch_in' => 'nullable|date_format:H:i:s',
           'thu_time_out' => 'nullable|date_format:H:i:s',
           'fri_time_in' => 'nullable|date_format:H:i:s',
           'fri_lunch_out' => 'nullable|date_format:H:i:s',
           'fri_lunch_in' => 'nullable|date_format:H:i:s',
           'fri_time_out' => 'nullable|date_format:H:i:s',
           'sat_time_in' => 'nullable|date_format:H:i:s',
           'sat_lunch_out' => 'nullable|date_format:H:i:s',
           'sat_lunch_in' => 'nullable|date_format:H:i:s',
           'sat_time_out' => 'nullable|date_format:H:i:s',
           'sun_time_in' => 'nullable|date_format:H:i:s',
           'sun_lunch_out' => 'nullable|date_format:H:i:s',
           'sun_lunch_in' => 'nullable|date_format:H:i:s',
           'sun_time_out' => 'nullable|date_format:H:i:s',
           'flexi_from' => 'nullable|date_format:H:i:s',
           'flexi_to' => 'nullable|date_format:H:i:s',
        ]);

        $isCodeCheck = true;
        if($scheduleId) {
            $schedule = Schedule::find($scheduleId);
            if($schedule?->code == $this->REQUEST?->code)
                $isCodeCheck = false;
        }

        if($isCodeCheck)
            $this->REQUEST->validate(['code' => 'unique:schedules']);


        return $body;
    }

    private function renderData($column){
        return [
            'id' => $column->id,
            'code' => $column->code,
            'description' => $column->description,
            'mon_time_in' => $column->mon_time_in?->toTimeString(),
            'mon_lunch_out' => $column->mon_lunch_out?->toTimeString(),
            'mon_lunch_in' => $column->mon_lunch_in?->toTimeString(),
            'mon_time_out' => $column->mon_time_out?->toTimeString(),
            'tue_time_in' => $column->tue_time_in?->toTimeString(),
            'tue_lunch_out' => $column->tue_lunch_out?->toTimeString(),
            'tue_lunch_in' => $column->tue_lunch_in?->toTimeString(),
            'tue_time_out' => $column->tue_time_out?->toTimeString(),
            'wed_time_in' => $column->wed_time_in?->toTimeString(),
            'wed_lunch_out' => $column->wed_lunch_out?->toTimeString(),
            'wed_lunch_in' => $column->wed_lunch_in?->toTimeString(),
            'wed_time_out' => $column->wed_time_out?->toTimeString(),
            'thu_time_in' => $column->thu_time_in?->toTimeString(),
            'thu_lunch_out' => $column->thu_lunch_out?->toTimeString(),
            'thu_lunch_in' => $column->thu_lunch_in?->toTimeString(),
            'thu_time_out' => $column->thu_time_out?->toTimeString(),
            'fri_time_in' => $column->fri_time_in?->toTimeString(),
            'fri_lunch_out' => $column->fri_lunch_out?->toTimeString(),
            'fri_lunch_in' => $column->fri_lunch_in?->toTimeString(),
            'fri_time_out' => $column->fri_time_out?->toTimeString(),
            'sat_time_in' => $column->sat_time_in?->toTimeString(),
            'sat_lunch_out' => $column->sat_lunch_out?->toTimeString(),
            'sat_lunch_in' => $column->sat_lunch_in?->toTimeString(),
            'sat_time_out' => $column->sat_time_out?->toTimeString(),
            'sun_time_in' => $column->sun_time_in?->toTimeString(),
            'sun_lunch_out' => $column->sun_lunch_out?->toTimeString(),
            'sun_lunch_in' => $column->sun_lunch_in?->toTimeString(),
            'sun_time_out' => $column->sun_time_out?->toTimeString(),
            'flexi_from' => $column->flexi_from?->toTimeString(),
            'flexi_to' => $column->flexi_to?->toTimeString(),
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

        $this->createRecord('Schedule', $body);

        return response(['message' => 'schedule successfully created.'], 201);
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search schedule');
        return response([
            'flexi' => Setting::flexiSetting()
        ], 200);
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search schedule');

        if($id != null) {
            $entity = Schedule::find($id);

            if($entity == null)
                return response(['message' => 'no schedule record found.'], 400);

            return response($this->renderData($entity), 200);
        }

        $query = Schedule::select('*');

        if($this->userCan(auth()->user(), 'restore schedule'))
            $query = $query->withTrashed();

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:code,description,mon_time_in,mon_lunch_out,mon_lunch_in,mon_time_out,tue_time_in,tue_lunch_out,tue_lunch_in,tue_time_out,wed_time_in,wed_lunch_out,wed_lunch_in,wed_time_out,thu_time_in,thu_lunch_out,thu_lunch_in,thu_time_out,fri_time_in,fri_lunch_out,fri_lunch_in,fri_time_out,sat_time_in,sat_lunch_out,sat_lunch_in,sat_time_out,sun_time_in,sun_lunch_out,sun_lunch_in,sun_time_out,flexi_from,flexi_to',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

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

        $this->updateRecord('Schedule', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete schedule');

        $this->deleteRecord('Schedule', $id);

        return response(null, 204);
    }

    public function restore($id){
        $this->checkUserAccess(auth()->user(), 'restore schedule');

        $this->restoreRecord('Schedule', $id);

        return response(null, 204);
    }

}