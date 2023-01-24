<?php

namespace App\Http\Controllers\Api\History;

use App\Models\Division;
use App\Models\Position;

use Illuminate\Http\Request;
use App\Models\ServiceRecord;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation($divisionId = null){
        $body = $this->REQUEST->validate([
           'code' => 'required|max:50',
           'name' => 'required',
           'description' => 'nullable',
           'office_group' => 'nullable|exists:divisions,id',
        ]);

        // validating code
        $isToValidateCode = true;
        if ($divisionId !== null) {
            $division = Division::find($divisionId);

            if($division?->code == $this->REQUEST->code)
                $isToValidateCode = false;
        }

        if($isToValidateCode)
            $this->REQUEST->validate(['code' => 'unique:divisions']);

        return $body;
    }

    public function create(){
        $this->checkUserAccess(auth()->user(), 'write division');

        $body = $this->validation();

        $this->createRecord('Division', $body);

        return response(['message' => 'division successfully created.'], 201);
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search division');

        return response([
            'office_group' => Division::select('id','code','name')->get()->makeHidden(['is_new','officeGroupData'])
        ], 200);
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search division');

        if($id != null) {
            $entity = Division::find($id);

            if($entity == null)
                return response(['message' => 'no division record found.'], 400);

            return response($entity, 200);
        }

        $query = Division::select('*');

        if($this->userCan(auth()->user(), 'restore division'))
            $query = $query->withTrashed();

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:code,name,description',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if(isset($filters['searchValue'])) {
            $searchVal = $filters['searchValue'];

            $query = $query->where(function($query) use ($searchVal){
                return $query->filter('code', $searchVal)
                            ->orFilter('name', $searchVal);
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
        $this->checkUserAccess(auth()->user(), 'write division');

        $body = $this->validation($id);

        $this->updateRecord('Division', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete division');
        
        // Validate delete
        $isOkOnServiceRecord = !ServiceRecord::where('assigned_to', $id)->exists();
        $isOkOnPosition = !Position::where('division_id', $id)->exists();

        if(!$isOkOnServiceRecord || !$isOkOnPosition)
            return response([
                'message' => 'Division has related record.'
            ], 400);

        $this->deleteRecord('Division', $id);

        return response(null, 204);
    }

    public function restore($id){
        $this->checkUserAccess(auth()->user(), 'restore division');

        $this->restoreRecord('Division', $id);

        return response(null, 204);
    }

}