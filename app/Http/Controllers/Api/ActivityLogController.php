<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function __construct(
        public Request $REQUEST
    ){}

    /**
     * TODO: Render data to return object
     * 
     * @param Activity $entity
     * 
     * @return Collection
     */
    public function renderData($entity){
        $username = $entity->causer != null ? $entity->causer->username: null;

        $properties = $entity->properties;
        $properties->transform(function($i) {
            unset($i['updated_at']);
            unset($i['created_at']);
            unset($i['deleted_at']);

            return $i;
        });

        return [
            'id' => $entity->id,
            'modelName' => $entity->log_name,
            'description' => $entity->description,
            'causeBy' => $username,
            'happenedAt' => $entity->created_at != null ? date('Y-m-d H:i:s', strtotime($entity->created_at)) : null,
            'properties' => $properties,
            'isNew' => $entity->is_new
        ];
    }

    public function search(){
        $this->checkUserAccess(auth()->user(), 'search log');

        $query = Activity::select('*')->orderBy('created_at','DESC');

        // Filters
        $filters = $this->REQUEST->validate([
            'modelName' => 'nullable',
            'from' => 'nullable|date_format:Y-m-d',
            'to' => 'required_unless:from,!=,null|date_format:Y-m-d|after_or_equal:from',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:modelName,description,causeBy,happenedAt',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        // modelName filter
        if (isset($filters['modelName']))
           $query = $query->where('log_name', $filters['modelName']);

        // from and to filter
        if (isset($filters['from'])) 
           $query = $query->whereDate('created_at', '>=', $filters['from'])->whereDate('created_at', '<=', $filters['to']);

        $entities = $query->get();

        $renderedData = $entities->map(function ($item, $key) {
            return $this->renderData($item);
        });

        if (isset($filters['field'])) {
           $renderedData = match($filters['order']) {
                'ASC' => $renderedData->sortBy($filters['field']),
                'DESC' => $renderedData->sortByDesc($filters['field'])
           };
        }

        // count
        $count = $entities == [] ? 0 : count($entities);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $postRenderData = $this->paginate($renderedData, $perPage, $page);

        return response($postRenderData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search log');

        return response()->json([
            'modelName' => Activity::groupBy('log_name')->pluck('log_name')
        ],200);
    }
}
