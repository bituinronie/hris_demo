<?php

namespace App\Http\Controllers\Api\TimeKeeping;

use Carbon\Carbon;
use App\Models\Dtr;

use App\Traits\CronTrait;
use Illuminate\Http\Request;
use App\Classes\DtrStatistic;
use App\Traits\EmployeeTrait;
use App\Http\Controllers\Controller;

class DtrController extends Controller
{
    use CronTrait, EmployeeTrait;

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'time_in' => 'nullable|date_format:Y-m-d H:i:s',
           'lunch_out' => 'nullable|date_format:Y-m-d H:i:s',
           'lunch_in' => 'nullable|date_format:Y-m-d H:i:s',
           'time_out' => 'nullable|date_format:Y-m-d H:i:s',
           'reason' => 'required',
        ]);

        return $body;
    }

    private function filtersForDtr(){
        $filters = $this->REQUEST->validate([
            'month' => 'nullable|date_format:m',
            'year' => 'nullable|date_format:Y',
            'dateFrom' => 'nullable|date_format:Y-m-d',
            'dateTo' => 'nullable|date_format:Y-m-d',
        ]);

        $year = $filters['year'] ?? date('Y');
        $month = $filters['month'] ?? date('m');

        $dateToParse = "$year-$month-01";

        return (object) [
            'dateFrom'=> $filters['dateFrom'] ?? date('Y-m-01', strtotime($dateToParse)),
            'dateTo'=> $filters['dateTo'] ?? date('Y-m-t', strtotime($dateToParse))
        ];
    }

    private function returnSearchDtr($employeeId){
        // Filters
        $filters = $this->REQUEST->validate([
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer'
        ]);

        $dtrFilters = $this->filtersForDtr();

        $entities = Dtr::select('*')->where('employee_id', $employeeId)->whereBetween('ref_date',[$dtrFilters->dateFrom, $dtrFilters->dateTo])->get();

        $returnEntities = $entities->map(function($item) {
            $data = $item->parseDtr;
            $data->prepend($item->id, 'id');
            $data->put('hasTimeLog', $item->hasTimeLog);

            return $data;
        });

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

    private function returnWeeklyDtr($employeeId){
        // init dates
        $now = Carbon::now();
        $dateFrom = $now->startOfWeek()->format('Y-m-d');
        $dateTo = $now->endOfWeek()->format('Y-m-d');

        $entities = Dtr::select('*')->where('employee_id', $employeeId)->whereBetween('ref_date',[$dateFrom, $dateTo])->get();

        $returnEntities = $entities->map(function($item) {
            return [
                'id' => $item->id,
                'date' => $item->ref_date->format('Y-m-d'),
                'time_in' => $item->time_in?->format('h:i a'),
                'lunch_out' => $item->lunch_out?->format('h:i a'),
                'lunch_in' => $item->lunch_in?->format('h:i a'),
                'time_out' => $item->time_out?->format('h:i a'),
                'hasTimeLog' => $item->hasTimeLog,
            ];
        });

        return response($returnEntities, 200);
    }

    public function search($employeeId = null, $id = null){
        $this->checkUserAccess(auth()->user(), 'search dtr');

        if($employeeId === null)
            return $this->returnResponseAllEmployees();

        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = Dtr::find($id);

            if($entity == null)
                return response(['message' => 'no dtr record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnSearchDtr($employeeId);
    }

    public function stats($employeeId){
        $this->checkUserAccess(auth()->user(), 'search dtr');

        $this->checkEmployeeId($employeeId);

        $dtrFilters = $this->filtersForDtr();

        $stats = Dtr::getStats($employeeId, $dtrFilters->dateFrom, $dtrFilters->dateTo);

        return response($stats, 200);

    }

    public function weekly($employeeId, $id = null){
        $this->checkUserAccess(auth()->user(), 'search dtr');

        $this->checkEmployeeId($employeeId);

        if($id != null) {
            $entity = Dtr::find($id);

            if($entity == null)
                return response(['message' => 'no dtr record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnWeeklyDtr($employeeId);
    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write dtr');

        $body = $this->validation();

        $this->updateRecord('Dtr', $id, $body);

        return response(null, 204);
    }

    public function portalSearch($id = null){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal dtr');

        if(!$employeeId = $user->employee?->id)
            return response('No employee found.', 400);

        if($id != null) {
            $entity = Dtr::find($id);

            if($entity == null)
                return response(['message' => 'no dtr record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnSearchDtr($employeeId);
    }

    public function portalStats(){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal dtr');

        if(!$employeeId = $user->employee?->id)
            return response('No employee found.', 400);

        $dtrFilters = $this->filtersForDtr();

        $stats = Dtr::getStats($employeeId, $dtrFilters->dateFrom, $dtrFilters->dateTo);

        return response($stats, 200);

    }

    public function portalWeekly($id = null){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal dtr');

        if(!$employeeId = $user->employee?->id)
            return response('No employee found.', 400);

        if($id != null) {
            $entity = Dtr::find($id);

            if($entity == null)
                return response(['message' => 'no dtr record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnWeeklyDtr($employeeId);
    }

    public function cronDtrGenerate($employeeId = null){
        $validateData = $this->REQUEST->validate([
            'month' => 'nullable|date_format:m',
            'year' => 'nullable|date_format:Y'
        ]);

        $month = $validateData['month'] ?? date('m');
        $year = $validateData['year'] ?? date('Y');

        $this->generateDtr($employeeId, $month, $year);

        return response(null, 204);
    }

}