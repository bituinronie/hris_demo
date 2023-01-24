<?php

namespace App\Http\Controllers\Api\EmployeeManagement;

use App\Models\Role;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation($userId = null){
        $body = $this->REQUEST->validate([
           'username' => 'nullable',
           'email' => 'required',
           'isActive' => 'required|boolean',
        ]);

        $cred = $this->REQUEST->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name'
        ]);

        // validating code
        $isToValidateUsername = true;
        $isToValidateEmail = true;
        if ($userId !== null) {
            $user = User::find($userId);

            if(!$user->employee) {
                $this->REQUEST->validate([
                    'username' => 'required'
                ]);

                if($user?->username == $this->REQUEST->username)
                    $isToValidateUsername = false;
            }else {
                $isToValidateUsername = false;

                unset($body['username']);
            }

            if($user?->email == $this->REQUEST->email)
                $isToValidateEmail = false;
        }else {
            $this->REQUEST->validate(['password' => 'required']);
        }

        if($isToValidateUsername)
            $this->REQUEST->validate(['username' => 'unique:users']);

        if($isToValidateEmail)
            $this->REQUEST->validate(['email' => 'unique:users']);


        // hasing password
        $password = $this->REQUEST->password ?? null;
        if ($password !== null) {
            $body['password'] = Hash::make($password);
            $body['shouldChange'] = true;
        }

        return [
            'user' => $body,
            'cred' => $cred
        ];
    }

    private function renderData($column, $withAddt = false){
        $data = [
            'id' => $column->id,
            'employee_number' => $column->employeeNumber,
            'employee_name' => $column->employeeName,
            'username' => $column->username,
            'email' => $column->email,
            'isActive' => $column->isActive,
            'role' => $column->role,
            'created_at' => $column->created_at,
            'updated_at' => $column->updated_at,
            'is_new' => $column->is_new,
        ];

        if ($withAddt) {
            $data['permissions'] = $column->permissionsArray;
        }

        return $data;
    }

    public function parameter(){
        return response([
            'role' => Role::all()->pluck('name'),
            'permissions' => Permission::all()->pluck('name'),
            'roles_with_permissions' => Role::all()->mapWithKeys(function($item, $key) {
                return [$item->name => $item->permissions()->pluck('name')];
            }),
        ],200);
    }

    public function create(){
        $this->checkUserAccess(auth()->user(), 'write user');

        $body = $this->validation();

        $user = $this->createRecord('User', $body['user']);

        $user->syncRoles([ $body['cred']['role'] ]);
        $user->syncPermissions($body['cred']['permissions']);

        return response(['message' => 'user successfully created.'], 201);
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search user');

        if($id != null) {
            $entity = User::find($id);

            if($entity == null)
                return response(['message' => 'no user record found.'], 400);

            return response($this->renderData($entity, true), 200);
        }

        $entities = User::select('*')->orderBy('created_at','DESC')->get();
        $returnEntities = $entities->map(function($item, $key) {
            return $this->renderData($item);
        });

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'hasEmployee' => 'nullable|boolean',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:employee_number,employee_name,username,email,isActive,role',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        // filter for search value
        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $returnEntities = $returnEntities->filter(function ($item) use ($search) {
                return $this->isMatch($item['employee_number'], $search) ||
                    $this->isMatch($item['employee_name'], $search) ||
                    $this->isMatch($item['username'], $search) ||
                    $this->isMatch($item['email'], $search) ||
                    $this->isMatch($item['role'], $search);
            });
        }

        // filter for show_pds
        if (isset($filters['hasEmployee'])) {
            if($filters['hasEmployee'])
                $returnEntities = $returnEntities->whereNotNull('employee_number');
            else
                $returnEntities = $returnEntities->whereNull('employee_number');

        }
        // filter for asc and desc fields
        if (isset($filters['field'])) {
            $returnEntities = match($filters['order']) {
                 'ASC' => $returnEntities->sortBy($filters['field']),
                 'DESC' => $returnEntities->sortByDesc($filters['field'])
            };
         }

        // return response
        $count = $returnEntities ==[]? 0:count($returnEntities);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $renderedData = $this->paginate($returnEntities, $perPage, $page);

        return response($renderedData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write user');

        $body = $this->validation($id);

        $user = $this->updateRecord('User', $id, $body['user']);

        $user->syncRoles([ $body['cred']['role'] ]);
        $user->syncPermissions($body['cred']['permissions']);

        return response(null, 204);
    }

}