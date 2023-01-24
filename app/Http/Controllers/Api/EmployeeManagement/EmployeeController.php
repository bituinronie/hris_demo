<?php

namespace App\Http\Controllers\Api\EmployeeManagement;

use App\Models\Setting;
use App\Models\Employee;

use Illuminate\Http\Request;
use App\Models\EmployeeGroup;
use App\Traits\EmployeeTrait;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class EmployeeController extends Controller
{
    use EmployeeTrait;

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation($status = 'CREATE', $employeeId = null){
        // update validation
        if($status == 'UPDATE')
            $this->REQUEST->validate([ 'isResetPassword' => 'required|boolean' ]);

        $isEmailCheck = true;
        $isEmployeeNumberCheck = true;

        if($status == 'PORTAL' || $status == 'UPDATE') {
            // email validation
            // get id to update
            $employee = Employee::find($employeeId);
            $user = $employee->user;

            if($user->email == $this->REQUEST->email)
                $isEmailCheck = false;

            if($employee->employee_number == $this->REQUEST->employee_number)
                $isEmployeeNumberCheck = false;
        }

        // post validation for email and employee number uniqueness
        if($isEmailCheck)
            $this->REQUEST->validate(['email' => 'unique:users']);

        if($isEmployeeNumberCheck)
            $this->REQUEST->validate(['employee_number' => 'unique:employees']);

        // parsed body response
        $body = $this->REQUEST->validate([
            'employee_number' => 'required|max:10',
            'last_name' => 'required|max:75',
            'first_name' => 'required|max:75',
            'middle_name' => 'nullable|max:75',
            'name_extension' => 'nullable|max:10|in:Jr,Sr,I,II,III',
            'birth_date' => 'required|date_format:Y-m-d',
            'birth_place' => 'nullable',
            'gender' => 'required|in:MALE,FEMALE',

            'civil_status' => 'required|in:SINGLE,MARRIED,WIDOWED,SEPARATED,OTHERS',
            'civil_status_others' => 'nullable|string',

            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'gsis' => 'nullable|max:20',
            'pagibig' => 'nullable|max:20',
            'philhealth' => 'nullable|max:20',
            'sss' => 'nullable|max:20',
            'tin' => 'nullable|max:20',
            'citizenship' => 'nullable|in:FILIPINO,DUAL_CITIZEN',
            'citizenship_by' => 'nullable|in:BIRTH,NATURALIZATION',
            'citizenship_by_country' => 'nullable|max:100',
            'residential_housenum' => 'nullable|max:100',
            'residential_street' => 'nullable|max:100',
            'residential_subdivision' => 'nullable|max:100',
            'residential_barangay' => 'nullable|max:100',
            'residential_city' => 'nullable|max:100',
            'residential_province' => 'nullable|max:100',
            'residential_zipcode' => 'nullable|max:4',
            'permanent_housenum' => 'nullable|max:100',
            'permanent_street' => 'nullable|max:100',
            'permanent_subdivision' => 'nullable|max:100',
            'permanent_barangay' => 'nullable|max:100',
            'permanent_city' => 'nullable|max:100',
            'permanent_province' => 'nullable|max:100',
            'permanent_zipcode' => 'nullable|max:4',
            'telephone' => 'nullable|max:20',
            'mobile' => 'nullable|max:20',
            'email' => 'required|email',
            'spouse_last_name' => 'nullable|max:75',
            'spouse_first_name' => 'nullable|max:75',
            'spouse_middle_name' => 'nullable|max:75',
            'spouse_name_extension' => 'nullable|max:10',
            'spouse_occupation' => 'nullable|max:100',
            'spouse_telephone' => 'nullable|max:15',
            'spouse_employer_business' => 'nullable',
            'spouse_business_address' => 'nullable',
            'father_last_name' => 'nullable|max:75',
            'father_first_name' => 'nullable|max:75',
            'father_middle_name' => 'nullable|max:75',
            'father_name_extension' => 'nullable|max:10',
            'mother_last_name' => 'nullable|max:75',
            'mother_first_name' => 'nullable|max:75',
            'mother_middle_name' => 'nullable|max:75',
            'is_affiliated_third' => 'nullable',
            'affiliated_third' => 'nullable',
            'is_affiliated_fourth' => 'nullable',
            'affiliated_fourth' => 'nullable',
            'is_found_guilty' => 'nullable',
            'found_guilty' => 'nullable',
            'is_criminally_charged' => 'nullable',
            'criminally_charged_date' => 'nullable|date_format:Y-m-d',
            'criminally_charged_status' => 'nullable',
            'is_convicted' => 'nullable',
            'convicted' => 'nullable',
            'is_separated_service' => 'nullable',
            'separated_service' => 'nullable',
            'is_candidate' => 'nullable',
            'candidate' => 'nullable',
            'is_resigned' => 'nullable',
            'resigned' => 'nullable',
            'is_immigrant' => 'nullable',
            'immigrant' => 'nullable',
            'is_indigenous' => 'nullable',
            'indigenous' => 'nullable',
            'is_disabled' => 'nullable',
            'disabled' => 'nullable',
            'is_solo' => 'nullable',
            'solo' => 'nullable',
            'government_id_type' => 'nullable|max:100',
            'government_id_number' => 'nullable|max:100',
            'issued_date' => 'nullable|date_format:Y-m-d',
            'issued_place' => 'nullable',

            'memberships' => 'nullable|array',
            'memberships.*' => 'required|string',
            'skills' => 'nullable|array',
            'skills.*' => 'required|string',
            'recognitions' => 'nullable|array',
            'recognitions.*' => 'required|string'
        ]);

        return $body;
    }

    private function getParameter(){
        return [
            'name_extension' => ['Jr','Sr','I','II','III'],
            'gender' => ['MALE','FEMALE'],
            'civil_status' => ['SINGLE','MARRIED','WIDOWED','SEPARATED','OTHERS'],
            'blood_type' => ['A+','A-','B+','B-','AB+','AB-','O+','O-'],
            'citizenship' => ['FILIPINO','DUAL_CITIZEN'],
            'citizenship_by' => ['BIRTH','NATURALIZATION'],
            'memberships' => Employee::membershipsParams(),
            'skills' => Employee::skillsParams(),
            'recognitions' => Employee::recognitionsParams(),
        ];
    }

    public function create(){
        $this->checkUserAccess(auth()->user(), 'write employee');

        $body = $this->validation();

        $employee = $this->createRecord('Employee', $body);

        // create user record
        $userBody = [
            'username' => $employee->generate_username,
            'password' => Hash::make($employee->generate_password),
            'email' => $employee->email,
            'isActive' => true
        ];

        $user = $this->createRecord('User', $userBody);

        // linking user to employee
        activity()->disableLogging(); // for user_id update only
        $employee->user_id = $user->id;
        $employee->save();
        activity()->enableLogging(); // resume logging

        // assigning permissions and roles
        $user->syncRoles(['Employee']);
        $user->syncPermissionByRole();

        return response([
            'message' => 'employee successfully created.',
            'data' => $employee->id
        ], 201);
    }

    public function search($id = null){
        $this->checkUserAccess(auth()->user(), 'search employee');

        if($id != null) {
            $entity = Employee::find($id);

            if($entity == null)
                return response(['message' => 'no employee record found.'], 400);

            return response($entity, 200);
        }

        return $this->returnResponseAllEmployees();
    }

    public function searchParameter(){
        $this->checkUserAccess(auth()->user(), 'search employee');

        return response($this->getParameter(), 200);
    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write employee');

        $body = $this->validation('UPDATE', $id); // status = 'UPDATE', $id = employee id

        $employee = $this->updateRecord('Employee', $id, $body);

        // update user record
        $userBody = [
            'username' => $employee->generate_username,
            'email' => $employee->email
        ];

        // reset password
        if($this->REQUEST->isResetPassword) {
            $userBody['password'] = Hash::make($employee->generate_password);
            $userBody['shouldChange'] = true;
        }

        $user = $this->updateRecord('User', $employee->user_id, $userBody);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete employee');

        $this->deleteRecord('Employee', $id);

        return response(null, 204);
    }

    public function restore($id){
        $this->checkUserAccess(auth()->user(), 'restore employee');

        $this->restoreRecord('Employee', $id);

        return response(null, 204);
    }

    public function portalSearch(){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');

        $employeeId = $user->employee->id ?? null;
        if($employeeId == null)
            return response(['message' => 'No employee record'], 400);

        $entity = $user->employee;

        return response($entity, 200);

    }

    public function portalParameter(){
        $this->checkUserAccess(auth()->user(), 'portal employee');

        return response($this->getParameter(), 200);
    }

    public function portalUpdate(){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');
        // is setting update employee
        $isUpdateEmployee = Setting::isUpdateEmployee();
        if(!$isUpdateEmployee)
            return response(['message' => 'Unauthorized'], 401);

        $id = $user->employee->id ?? null;
        if($id == null)
            return response(['message' => 'No employee record'], 400);

        $body = $this->validation('PORTAL', $id); // status = 'PORTAL', $id = employee id

        $employee = $this->updateRecord('Employee', $id, $body);

        // update user record
        $userBody = [
            'username' => $employee->generate_username,
            'email' => $employee->email
        ];

        $user = $this->updateRecord('User', $employee->user_id, $userBody);

        return response(null, 204);
    }

    // Display Picture
    public function dpSearch($id){
        $this->checkUserAccess(auth()->user(), 'search employee');

        $employee = Employee::find($id);
        if($employee == null)
            return response([
                'message' => 'Employee not found.'
            ], 400);

        return response([
            'message' => $employee->dpUrl
        ], 200);
    }

    public function dpChange($id){
        $this->checkUserAccess(auth()->user(), 'write employee');

        $validateData = $this->REQUEST->validate([
            'picture' => 'required|mimes:jpeg,jpg,png'
        ]);

        $employee = Employee::find($id);
        if($employee == null)
            return response([
                'message' => 'Employee not found.'
            ], 400);

        if($employee->dpUrl != null)
            $employee->getMedia('dp')->first()->delete();

        $employee
            ->addMedia($validateData['picture'])
            ->toMediaCollection('dp');

        return response(null, 204);
    }

    public function portalDpSearch(){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');

        $employee = $user->employee ?? null;
        if($employee == null)
            return response(['message' => 'No employee record'], 400);

        return response([
            'message' => $employee->dpUrl
        ], 200);
    }

    
    public function portalDpChange(){
        $user = auth()->user();

        $this->checkUserAccess($user, 'portal employee');

        // is setting update employee
        $isUpdateEmployee = Setting::isUpdateEmployee();
        if(!$isUpdateEmployee)
            return response(['message' => 'Unauthorized'], 401);

        $employee = $user->employee ?? null;
        if($employee == null)
            return response(['message' => 'No employee record'], 400);

        $validateData = $this->REQUEST->validate([
            'picture' => 'required|mimes:jpeg,jpg,png'
        ]);

        if($employee->dpUrl != null)
            $employee->getMedia('dp')->first()->delete();

        $employee
            ->addMedia($validateData['picture'])
            ->toMediaCollection('dp');

        return response(null, 204);
    }

}