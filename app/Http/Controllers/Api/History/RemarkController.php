<?php

namespace App\Http\Controllers\Api\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Remark;

class RemarkController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation($id){
        $entity = Remark::find($id);
        if($entity?->code != $this->REQUEST->code)
            $this->REQUEST->validate([ 'code' => 'required|unique:remarks' ]);

        $body = $this->REQUEST->validate([
           'code' => 'required',
           'description' => 'required',
        ]);

        return $body;
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search remark');

        if($id != null) {
            $entity = Remark::find($id);

            if($entity == null)
                return response(['message' => 'no remark record found.'], 400);

            return response($entity, 200);
        }

        $query = Remark::select('*');

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:code,description',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if (isset($filters['searchValue'])) {
            $searchVal = $filters['searchValue'];

            $query = $query->where(function($query) use ($searchVal){
                return $query->filter('code', $searchVal)
                            ->orFilter('description', $searchVal);
            });
        }

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
        $this->checkUserAccess(auth()->user(), 'write remark');

        $body = $this->validation($id);

        $this->updateRecord('Remark', $id, $body);

        return response(null, 204);
    }

}