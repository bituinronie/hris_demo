<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct(
        public Request $REQUEST
    ){}

    private function validation($id = null){
        // init permissions validation
        $permissionNames = Permission::pluck('name');

        $validationNames = "";
        foreach ($permissionNames as $name) {
            $validationNames .= "$name,";
        }
        $validationNames = trim($validationNames, ',');

        // body validation
        $body = $this->REQUEST->validate([
            'name' => 'required',
            'permissions' => 'nullable|array',
            'permissions.*' => "in:$validationNames"
        ]);

        // name validation
        if($id == null) {
            $this->REQUEST->validate( [ 'name' => 'unique:roles' ] );
        }else {
            $role = Role::find($id);

            if($role->name != $body['name']) {
                $this->REQUEST->validate( [ 'name' => 'unique:roles' ] );
            }
        }

        return $body;
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search role');

        if($id != null) {
            $entity = Role::find($id);

            if($entity == null)
                return response(['message' => 'no role found.'], 400);

            return response($entity, 200);
        }

        $query = Role::select('*');

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable',
            'field' => 'nullable|in:name',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        $filters['perPage'] = $filters['perPage'] ?? 10;

        if(isset($filters['searchValue']))
            $query = $query->where('name','LIKE','%'.$filters['searchValue'].'%');

        if (isset($filters['field']))
           $entities = $query->orderBy($filters['field'], $filters['order'])->paginate(10);

        // return response
        $count = $query->get() ==[]? 0:count($query->get());

        // paginate
        $entities = $query->paginate($filters['perPage']);

        return response($entities)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);

    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search role');
        
        return response()->json([
            'permissions' => Permission::pluck('name')
        ], 200);
    }

    public function create(){
        $this->checkUserAccess(auth()->user(), 'write role');

        $body = $this->validation();

        $role = Role::create(['name' => $body['name']]);
        $role->givePermissionTo($body['permissions']);

        return response(['message' => 'role successfully created.'], 201);
    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write role');

        $role = Role::find($id);

        if($role == null)
            return response(['message' => 'no role found.'], 400);

        $body = $this->validation($id);

        $role->name = $body['name'];
        $role->save();
        $role->syncPermissions($body['permissions']);

        return response(null, 204);
    }


}
