<?php

namespace App\Http\Controllers\Api\Labor;

use App\Models\Mfo;
use App\Models\Appraisal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MfoController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'number' => 'required',
           'title' => 'required',
           'description' => 'nullable',
           'Q' => 'nullable|numeric|min:1|max:5',
           'E' => 'nullable|numeric|min:1|max:5',
           'T' => 'nullable|numeric|min:1|max:5',
        ]);

        return $body;
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search appraisal');

        return response([
            'autoSuggest' => Mfo::select('title', 'description')->groupBy('title', 'description')->get()->makeHidden(['is_new', 'averageRating', 'adjectivalRating']),
        ], 200);
    }

    public function create($appraisalId){
        $this->checkUserAccess(auth()->user(), 'write appraisal');

        $body = $this->validation();
        $body['appraisal_id'] = $appraisalId;

        $this->createRecord('Mfo', $body);

        return response(['message' => 'mfo successfully created.'], 201);
    }

    public function search($appraisalId, $id = null){
        $this->checkUserAccess(auth()->user(), 'search appraisal');

        $appraisal = Appraisal::find($appraisalId);

        if($appraisal == null)
            return response(['message' => 'no appraisal found.'], 400);

        if($id != null) {
            $entity = Mfo::find($id);

            if($entity == null)
                return response(['message' => 'no mfo record found.'], 400);

            return response($entity, 200);
        }

        $query = Mfo::select('*')->where('appraisal_id', $appraisalId);

        // Filters
        $filters = $this->REQUEST->validate([
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

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
        $this->checkUserAccess(auth()->user(), 'write appraisal');

        $body = $this->validation();

        $this->updateRecord('Mfo', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete appraisal');

        $this->deleteRecord('Mfo', $id);

        return response(null, 204);
    }

}