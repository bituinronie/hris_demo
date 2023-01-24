<?php

namespace App\Http\Controllers\Api\SelfService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RequestType;

class RequestTypeController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation($id){
        $body = $this->REQUEST->validate([
           'code' => 'required|max:150',
           'description' => 'required',
           'filing_period_type' => 'required|in:BEFORE,EITHER,AFTER,MONTH,FROM_TO,ANYTIME',

           'filing_period_month' => 'nullable|array',
           'filing_period_month.*' => 'nullable|string|date_format:m',

           'filing_period_days' => 'nullable|numeric|min:1',

           'filing_period_from' => 'nullable|string|date_format:m-d',
           'filing_period_to' => 'nullable|string|date_format:m-d',


           'request_limit_min' => 'nullable|numeric',
           'request_limit_max' => 'nullable|numeric',

           'category' => 'required|in:LEAVES,OB,OVERTIME',
           'based_on' => 'required|in:SCHEDULE,CALENDAR',
        ]);

        // unique code
        $isToCheckCode = true;
        $entity = RequestType::findOrFail($id);

        if($entity->code == $body['code'])
            $isToCheckCode = false;

        if($isToCheckCode)
            $this->REQUEST->validate(['code' => 'unique:request_types']);

        return $body;
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search request type');

        if($id != null) {
            $entity = RequestType::find($id);

            if($entity == null)
                return response(['message' => 'no request type record found.'], 400);

            return response($entity, 200);
        }

        $query = RequestType::select('*');

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:code,description,filing_period_type,filing_period_days,request_limit_min,request_limit_max,category,based_on',
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
        $this->checkUserAccess(auth()->user(), 'write request type');

        $body = $this->validation($id);

        $this->updateRecord('RequestType', $id, $body);

        return response(null, 204);
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search request type');
        
        return response([
            'filling_period_type' => ['BEFORE','EITHER','AFTER','MONTH','FROM_TO','ANYTIME'],
            'category' => ['LEAVES','OB','OVERTIME'],
            'based_on' => [
                'SCHEDULE',
                'CALENDAR'
            ]
        ], 200);
    }

}