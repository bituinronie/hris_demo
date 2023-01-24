<?php

namespace App\Http\Controllers\Api\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FundingSource;

class FundingSourceController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation($id = null){
        $body = $this->REQUEST->validate([
           'code' => 'required|max:150',
           'description' => 'required',
        ]);

        // validating code
        $isToValidateCode = true;
        if ($id != null) {
            $fundingSource = FundingSource::find($id);

            if($fundingSource?->code == $body['code'])
                $isToValidateCode = false;
        }

        if($isToValidateCode)
            $this->REQUEST->validate(['code' => 'unique:funding_sources']);


        return $body;
    }

    public function create(){
        $this->checkUserAccess(auth()->user(), 'write funding source');

        $body = $this->validation();

        $this->createRecord('FundingSource', $body);

        return response(['message' => 'fundingsource successfully created.'], 201);
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search funding source');

        if($id != null) {
            $entity = FundingSource::find($id);

            if($entity == null)
                return response(['message' => 'no funding source record found.'], 400);

            return response($entity, 200);
        }

        $query = FundingSource::select('*');

        if($this->userCan(auth()->user(), 'restore funding source'))
            $query = $query->withTrashed();

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:code,description',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if(isset($filters['searchValue'])) {
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
        $this->checkUserAccess(auth()->user(), 'write funding source');

        $body = $this->validation($id);

        $this->updateRecord('FundingSource', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete funding source');

        $this->deleteRecord('FundingSource', $id);

        return response(null, 204);
    }

    public function restore($id){
        $this->checkUserAccess(auth()->user(), 'restore funding source');

        $this->restoreRecord('FundingSource', $id);

        return response(null, 204);
    }

}