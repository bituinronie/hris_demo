<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//* declaration of variables
$namespace = 'App\\Http\\Controllers\\Api';

//**********************
//* Authentications
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => $namespace
], function ($r) {
    $r->post('login', 'AuthController@login');
    $r->post('logout', 'AuthController@logout');
    $r->post('refresh', 'AuthController@refresh');
    $r->get(null, 'AuthController@user');
    $r->put('change-password', 'AuthController@changePassword');
});

//**********************
//* Forgot Password
Route::group([
    'middleware' => 'api',
    'prefix' => 'forgot-password',
    'namespace' => $namespace
], function ($r) {
    $r->post('send', 'ForgotPasswordController@send');
});

//**********************
//* Tokens
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'token',
    'namespace' => $namespace
], function ($r) {
    $r->post('generate', 'TokenController@generate');
    $r->get('check/{token}', 'TokenController@check');

    $r->get('report/parameter/{employeeId?}', 'TokenController@reportParameter');
    $r->get('report/plain-parameter/', 'TokenController@reportPlainParameter');
    $r->get('service-record/parameter/', 'TokenController@serviceRecordParameter');
    $r->get('employees/parameter/', 'TokenController@employeesParameter');
});

//**********************
//* Activity Logs
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'logs',
    'namespace' => $namespace
], function ($r) {
    $r->get('search', 'ActivityLogController@search');
    $r->get('parameter', 'ActivityLogController@parameter');
});

//**********************
//* Settings
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'setting',
    'namespace' => $namespace
], function ($r) {
    $r->get('{key}', 'SettingController@search');
    $r->put('{key}', 'SettingController@update');
});

//**********************
//* Roles
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'role',
    'namespace' => $namespace
], function ($r) {
    $r->get('search/{id?}', 'RoleController@search');
    $r->get('parameter', 'RoleController@parameter');
    $r->post('create', 'RoleController@create');
    $r->put('update/{id}', 'RoleController@update');
});

//**********************
//* EmployeeGroup
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'employee-group',
    'namespace' => $namespace . '\EmployeeManagement'
], function ($r) {
    $r->post('create', 'EmployeeGroupController@create');
    $r->get('search/{id?}', 'EmployeeGroupController@search');
    $r->put('update/{id}', 'EmployeeGroupController@update');
    $r->delete('delete/{id}', 'EmployeeGroupController@delete');
    $r->post('restore/{id}', 'EmployeeGroupController@restore');
});

//**********************
//* Employee
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'employee',
    'namespace' => $namespace . '\EmployeeManagement'
], function ($r) {
    $r->post('create', 'EmployeeController@create');
    $r->get('search/{id?}', 'EmployeeController@search');
    $r->get('parameter', 'EmployeeController@searchParameter');
    $r->put('update/{id}', 'EmployeeController@update');
    $r->delete('delete/{id}', 'EmployeeController@delete');
    $r->post('restore/{id}', 'EmployeeController@restore');

    $r->get('dp/search/{id}', 'EmployeeController@dpSearch');
    $r->post('dp/change/{id}', 'EmployeeController@dpChange');

    $r->get('portal/search', 'EmployeeController@portalSearch');
    $r->get('portal/parameter', 'EmployeeController@portalParameter');
    $r->put('portal/update', 'EmployeeController@portalUpdate');

    $r->get('portal/dp/search', 'EmployeeController@portalDpSearch');
    $r->post('portal/dp/change', 'EmployeeController@portalDpChange');
});

//**********************
//* Children
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'employee/children',
    'namespace' => $namespace . '\EmployeeManagement'
], function ($r) {
    $r->post('create/{employeeId}', 'ChildrenController@create');
    $r->get('search/{employeeId}/{childrenId?}', 'ChildrenController@search');
    $r->put('update/{childrenId}', 'ChildrenController@update');
    $r->delete('delete/{childrenId}', 'ChildrenController@delete');

    $r->get('portal/search/{childrenId?}', 'ChildrenController@portalSearch');
    $r->post('portal/create', 'ChildrenController@portalCreate');
    $r->put('portal/update/{childrenId}', 'ChildrenController@portalUpdate');
    $r->delete('portal/delete/{childrenId}', 'ChildrenController@portalDelete');
});

//**********************
//* Education
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'employee/education',
    'namespace' => $namespace . '\EmployeeManagement'
], function ($r) {
    $r->post('create/{employeeId}', 'EducationController@create');
    $r->get('search/{employeeId}/{educationId?}', 'EducationController@search');
    $r->get('parameter', 'EducationController@searchParameter');
    $r->put('update/{educationId}', 'EducationController@update');
    $r->delete('delete/{educationId}', 'EducationController@delete');

    $r->get('portal/search/{educationId?}', 'EducationController@portalSearch');
    $r->post('portal/create', 'EducationController@portalCreate');
    $r->get('portal/parameter', 'EducationController@portalParameter');
    $r->put('portal/update/{educationId}', 'EducationController@portalUpdate');
    $r->delete('portal/delete/{educationId}', 'EducationController@portalDelete');
});

//**********************
//* Eligibility
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'employee/eligibility',
    'namespace' => $namespace . '\EmployeeManagement'
], function ($r) {
    $r->post('create/{employeeId}', 'EligibilityController@create');
    $r->get('search/{employeeId}/{eligibilityId?}', 'EligibilityController@search');
    $r->get('parameter', 'EligibilityController@searchParameter');
    $r->put('update/{eligibilityId}', 'EligibilityController@update');
    $r->delete('delete/{eligibilityId}', 'EligibilityController@delete');

    $r->get('portal/search/{eligibilityId?}', 'EligibilityController@portalSearch');
    $r->post('portal/create', 'EligibilityController@portalCreate');
    $r->get('portal/parameter', 'EligibilityController@portalParameter');
    $r->put('portal/update/{eligibilityId}', 'EligibilityController@portalUpdate');
    $r->delete('portal/delete/{eligibilityId}', 'EligibilityController@portalDelete');
});

//**********************
//* WorkExperience
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'employee/work-experience',
    'namespace' => $namespace . '\EmployeeManagement'
], function ($r) {
    $r->post('create/{employeeId}', 'WorkExperienceController@create');
    $r->get('search/{employeeId}/{workExpId?}', 'WorkExperienceController@search');
    $r->get('parameter', 'WorkExperienceController@searchParameter');
    $r->put('update/{workExpId}', 'WorkExperienceController@update');
    $r->delete('delete/{workExpId}', 'WorkExperienceController@delete');

    $r->get('portal/search/{workExpId?}', 'WorkExperienceController@portalSearch');
    $r->post('portal/create', 'WorkExperienceController@portalCreate');
    $r->get('portal/parameter', 'WorkExperienceController@portalParameter');
    $r->put('portal/update/{workExpId}', 'WorkExperienceController@portalUpdate');
    $r->delete('portal/delete/{workExpId}', 'WorkExperienceController@portalDelete');
});

//**********************
//* Volunteering
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'employee/volunteering',
    'namespace' => $namespace . '\EmployeeManagement'
], function ($r) {
    $r->post('create/{employeeId}', 'VolunteeringController@create');
    $r->get('search/{employeeId}/{volunteeringId?}', 'VolunteeringController@search');
    $r->get('parameter', 'VolunteeringController@searchParameter');
    $r->put('update/{volunteeringId}', 'VolunteeringController@update');
    $r->delete('delete/{volunteeringId}', 'VolunteeringController@delete');

    $r->get('portal/search/{volunteeringId?}', 'VolunteeringController@portalSearch');
    $r->post('portal/create', 'VolunteeringController@portalCreate');
    $r->get('portal/parameter', 'VolunteeringController@portalParameter');
    $r->put('portal/update/{volunteeringId}', 'VolunteeringController@portalUpdate');
    $r->delete('portal/delete/{volunteeringId}', 'VolunteeringController@portalDelete');
});

//**********************
//* Training
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'training',
    'namespace' => $namespace . '\TrainingManagement'
], function ($r) {
    $r->get('search/{trainingId?}', 'TrainingController@search');
    $r->get('parameter', 'TrainingController@parameter');
    $r->post('create', 'TrainingController@create');
    $r->put('update/{trainingId}', 'TrainingController@update');
    $r->delete('delete/{trainingId}', 'TrainingController@delete');
    $r->post('restore/{trainingId}', 'TrainingController@restore');

    $r->get('date/search/{trainingId}', 'TrainingController@dateSearch');
    $r->get('date/parameter/{trainingId}', 'TrainingController@dateParameter');
    $r->post('date/create/{trainingId}', 'TrainingController@dateCreate');
    $r->post('date/assign/{trainingId}', 'TrainingController@dateAssign');
    $r->put('date/update/{trainingId}', 'TrainingController@dateUpdate');
    $r->delete('date/delete/{trainingId}', 'TrainingController@dateDelete');

    $r->get('portal/calendar/{trainingId?}', 'TrainingController@portalCalendar');
    $r->get('portal/search', 'TrainingController@portalSearch');
    $r->post('portal/attach/{employeeTrainingId}', 'TrainingController@portalAttach');
});

//**********************
//* Reference
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'employee/reference',
    'namespace' => $namespace . '\EmployeeManagement'
], function ($r) {
    $r->post('create/{employeeId}', 'ReferenceController@create');
    $r->get('search/{employeeId}/{referenceId?}', 'ReferenceController@search');
    $r->put('update/{referenceId}', 'ReferenceController@update');
    $r->delete('delete/{referenceId}', 'ReferenceController@delete');

    $r->get('portal/search/{referenceId?}', 'ReferenceController@portalSearch');
    $r->post('portal/create', 'ReferenceController@portalCreate');
    $r->put('portal/update/{referenceId}', 'ReferenceController@portalUpdate');
    $r->delete('portal/delete/{referenceId}', 'ReferenceController@portalDelete');
});

//**********************
//* EmployeeTraining
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'employee/training',
    'namespace' => $namespace . '\EmployeeManagement'
], function ($r) {
    $r->post('create/{employeeId}', 'EmployeeTrainingController@create');
    $r->get('search/{employeeId}/{employeeTrainingId?}', 'EmployeeTrainingController@search');
    $r->get('parameter', 'EmployeeTrainingController@searchParameter');
    $r->put('update/{employeeTrainingId}', 'EmployeeTrainingController@update');
    $r->delete('delete/{employeeTrainingId}', 'EmployeeTrainingController@delete');

    $r->get('portal/search/{employeeTrainingId?}', 'EmployeeTrainingController@portalSearch');
    $r->post('portal/create', 'EmployeeTrainingController@portalCreate');
    $r->get('portal/parameter', 'EmployeeTrainingController@portalParameter');
    $r->put('portal/update/{employeeTrainingId}', 'EmployeeTrainingController@portalUpdate');
    $r->delete('portal/delete/{employeeTrainingId}', 'EmployeeTrainingController@portalDelete');
});

//**********************
//* Division
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'division',
    'namespace' => $namespace . '\History'
], function ($r) {
    $r->post('create', 'DivisionController@create');
    $r->get('search/{id?}', 'DivisionController@search');
    $r->get('parameter', 'DivisionController@parameter');
    $r->put('update/{id}', 'DivisionController@update');
    $r->delete('delete/{id}', 'DivisionController@delete');
    $r->post('restore/{id}', 'DivisionController@restore');
});

//**********************
//* SalaryGrade
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'salary-grade',
    'namespace' => $namespace . '\History'
], function ($r) {
    $r->get('parameter', 'SalaryGradeController@parameter');
    $r->post('create/{tranche?}', 'SalaryGradeController@create');
    $r->get('search/{tranche}/{id?}', 'SalaryGradeController@search');
    $r->put('update/{id}', 'SalaryGradeController@update');
    $r->delete('delete/{id}', 'SalaryGradeController@delete');
});

//**********************
//* Position
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'position',
    'namespace' => $namespace . '\History'
], function ($r) {
    $r->post('create', 'PositionController@create');
    $r->get('parameter', 'PositionController@parameter');
    $r->get('search/{id?}', 'PositionController@search');
    $r->put('update/{id}', 'PositionController@update');
    $r->delete('delete/{id}', 'PositionController@delete');
    $r->post('restore/{id}', 'PositionController@restore');
});

//**********************
//* EmploymentStatus
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'employment-status',
    'namespace' => $namespace . '\History'
], function ($r) {
    $r->get('search/{id?}', 'EmploymentStatusController@search');
    $r->put('update/{id}', 'EmploymentStatusController@update');
});

//**********************
//* Remark
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'remark',
    'namespace' => $namespace . '\History'
], function ($r) {
    $r->get('search/{id?}', 'RemarkController@search');
    $r->put('update/{id}', 'RemarkController@update');
});

//**********************
//* ServiceRecord
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'service-record',
    'namespace' => $namespace . '\History'
], function ($r) {
    $r->post('create/{employeeId}', 'ServiceRecordController@create');
    $r->get('latest/{employeeId}', 'ServiceRecordController@latest');
    $r->get('parameter', 'ServiceRecordController@parameter');
    $r->get('parameter/position', 'ServiceRecordController@parameterPosition');
    $r->get('parameter/step/{positionId}', 'ServiceRecordController@parameterStep');
    $r->get('search/{employeeId?}/{id?}', 'ServiceRecordController@search');
    $r->put('update/{id}', 'ServiceRecordController@update');
    $r->post('attach/{id}', 'ServiceRecordController@attach');
    $r->delete('delete/{id}', 'ServiceRecordController@delete');
    $r->post('restore/{id}', 'ServiceRecordController@restore');
});

//**********************
//* User
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'user',
    'namespace' => $namespace . '\EmployeeManagement'
], function ($r) {
    $r->post('create', 'UserController@create');
    $r->get('search/{id?}', 'UserController@search');
    $r->get('parameter', 'UserController@parameter');
    $r->put('update/{id}', 'UserController@update');
});

//**********************
//* Schedule
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'schedule',
    'namespace' => $namespace . '\TimeKeeping'
], function ($r) {
    $r->post('create', 'ScheduleController@create');
    $r->get('parameter', 'ScheduleController@parameter');
    $r->get('search/{id?}', 'ScheduleController@search');
    $r->put('update/{id}', 'ScheduleController@update');
    $r->delete('delete/{id}', 'ScheduleController@delete');
    $r->post('restore/{id}', 'ScheduleController@restore');
});

//**********************
//* SpecialSchedule
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'special-schedule',
    'namespace' => $namespace . '\TimeKeeping'
], function ($r) {
    $r->post('create', 'SpecialScheduleController@create');
    $r->get('search/{id?}', 'SpecialScheduleController@search');
    $r->put('update/{id}', 'SpecialScheduleController@update');
    $r->delete('delete/{id}', 'SpecialScheduleController@delete');
    $r->post('restore/{id}', 'SpecialScheduleController@restore');
});

//**********************
//* SpecialDate
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'special-date',
    'namespace' => $namespace . '\TimeKeeping'
], function ($r) {
    $r->post('create', 'SpecialDateController@create');
    $r->get('search/{id?}', 'SpecialDateController@search');
    $r->put('update/{id}', 'SpecialDateController@update');
    $r->delete('delete/{id}', 'SpecialDateController@delete');
    $r->post('restore/{id}', 'SpecialDateController@restore');
});

//**********************
//* EmployeeSchedule
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'employee/schedule',
    'namespace' => $namespace . '\TimeKeeping'
], function ($r) {
    $r->post('create/{employeeId}', 'EmployeeScheduleController@create');
    $r->post('mass', 'EmployeeScheduleController@mass');
    $r->get('parameter', 'EmployeeScheduleController@parameter');
    $r->get('special-schedule/parameter', 'EmployeeScheduleController@specialScheduleParameter');
    $r->get('search/{employeeId?}', 'EmployeeScheduleController@search');
    $r->get('today/{employeeId}', 'EmployeeScheduleController@today');
    $r->put('update/{employeeScheduleId}', 'EmployeeScheduleController@update');
    $r->delete('delete/{employeeScheduleId}', 'EmployeeScheduleController@delete');

    $r->get('portal/search', 'EmployeeScheduleController@portalSearch');
    $r->get('portal/today', 'EmployeeScheduleController@portalToday');
});

//**********************
//* Dtr
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'dtr',
    'namespace' => $namespace . '\TimeKeeping'
], function ($r) {
    $r->get('search/{employeeId?}/{id?}', 'DtrController@search');
    $r->get('stats/{employeeId}', 'DtrController@stats');
    $r->get('weekly/{employeeId}/{id?}', 'DtrController@weekly');
    $r->get('time-log/{id}', 'TimeLogController@dtrLog');
    $r->put('update/{id}', 'DtrController@update');

    $r->get('portal/search/{id?}', 'DtrController@portalSearch');
    $r->get('portal/stats', 'DtrController@portalStats');
    $r->get('portal/weekly/{id?}', 'DtrController@portalWeekly');
    $r->get('portal/time-log/{id}', 'TimeLogController@portalDtrLog');
});

//**********************
//* CRON
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'cron',
    'namespace' => $namespace
], function ($r) {
    //* Dtr
    $r->post('dtr/generate/{employeeId?}', 'TimeKeeping\DtrController@cronDtrGenerate');

    //* Request
    $r->post('request/automatic', 'SelfService\RequestController@cronAutomatic');
    $r->post('request/earn/{employeeId?}', 'SelfService\RequestController@cronEarn');
    $r->post('request/annual/{employeeId?}', 'SelfService\RequestController@cronAnnual');
});

//**********************
//* Kiosk
Route::group([
    'middleware' => 'api',
    'prefix' => 'kiosk',
    'namespace' => $namespace,
], function ($r) {
    $r->post('get-token', 'KioskController@getToken');
    $r->get('test-token', 'KioskController@testToken');
    $r->post('logout-token', 'KioskController@logoutToken');
    $r->post('time-log/save', 'KioskController@timeLogSave');
    $r->get('dtr/{id}', 'KioskController@dtr');
    // $r->get('employee/search/{id}', 'KioskController@employeeSearch');
    $r->get('employee/{id?}', 'KioskController@employee');
    // $r->get('employee/kiosk/{kiosk_name}','KioskController@getEmployeeByKiosk');
    $r->get('employee-schedule/{id}', 'KioskController@employeeSchedule');
    $r->get('schedule/{id?}', 'KioskController@schedule');
    $r->get('monthly-schedule/{id?}', 'KioskController@monthlySchedule');
    $r->post('register', 'KioskController@register');
    $r->get('employee/rfid/{id}', 'KioskController@employeeRfid');
    $r->post('employee/facedata/', 'KioskController@employeeFaceData');
    $r->get('employee/id/{id}', 'KioskController@employeeById');
});

//**********************
//* RequestType
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'request-type',
    'namespace' => $namespace . '\SelfService'
], function ($r) {
    $r->get('parameter', 'RequestTypeController@parameter');
    $r->get('search/{id?}', 'RequestTypeController@search');
    $r->put('update/{id}', 'RequestTypeController@update');
});

//**********************
//* Approver
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'approver',
    'namespace' => $namespace . '\SelfService'
], function ($r) {
    $r->get('parameter', 'ApproverController@parameter');
    $r->get('search/{employeeId?}', 'ApproverController@search');
    $r->put('mass', 'ApproverController@mass');
    $r->put('update/{employeeId}', 'ApproverController@update');
});

//**********************
//* FundingSource
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'funding-source',
    'namespace' => $namespace . '\History'
], function ($r) {
    $r->post('create', 'FundingSourceController@create');
    $r->get('search/{id?}', 'FundingSourceController@search');
    $r->put('update/{id}', 'FundingSourceController@update');
    $r->delete('delete/{id}', 'FundingSourceController@delete');
    $r->post('restore/{id}', 'FundingSourceController@restore');
});

//**********************
//* Request
Route::group([
    'middleware' => 'api',
    'prefix' => 'request',
    'namespace' => $namespace . '\SelfService'
], function ($r) {
    //* Admin
    $r->get('search/{employeeId?}/{leaveLedgerId?}', 'RequestController@search');
    $r->get('parameter', 'RequestController@parameter');
    $r->get('balance/{employeeId}', 'RequestController@balance');
    $r->post('create/{employeeId}', 'RequestController@create');
    $r->post('update/{leaveLedgerId}', 'RequestController@update');
    $r->post('compute/{employeeId}', 'RequestController@compute');
    $r->post('cancel/{leaveLedgerId}', 'RequestController@cancel');

    //* Portal
    $r->get('portal/search', 'RequestController@portalSearch');
    $r->get('portal/parameter', 'RequestController@portalParameter');
    $r->get('portal/balance', 'RequestController@portalBalance');
    $r->post('portal/create', 'RequestController@portalCreate');
    $r->post('portal/compute', 'RequestController@portalCompute');
    $r->post('portal/cancel/{leaveLedgerId}', 'RequestController@portalCancel');
    $r->post('portal/proof/{leaveLedgerId}', 'RequestController@portalProof');

    //* Approver
    $r->get('approver/search', 'RequestController@approverSearch');
    $r->get('approver/parameter', 'RequestController@approverParameter');
    $r->post('approver/approve/{leavLedgerId}', 'RequestController@approverApprove');
    $r->post('approver/disapprove/{leavLedgerId}', 'RequestController@approverDisapprove');

    //* Token
    $r->post('token/approve/{token}', 'RequestController@tokenApprove');
    $r->post('token/disapprove/{token}', 'RequestController@tokenDisapprove');
});


//**********************
//* Applicant
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'applicant',
    'namespace' => $namespace . '\ApplicationMatrix'
], function ($r) {
    $r->post('create', 'ApplicantController@create');
    $r->get('parameter', 'ApplicantController@parameter');
    $r->get('search/{id?}', 'ApplicantController@search');
    $r->put('update/{id}', 'ApplicantController@update');
    $r->delete('delete/{id}', 'ApplicantController@delete');
});

//**********************
//* Award
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'award',
    'namespace' => $namespace . '\Labor'
], function ($r) {
    $r->get('parameter', 'AwardController@parameter');
    $r->post('create/{employeeId}', 'AwardController@create');
    $r->get('search/{employeeId?}/{id?}', 'AwardController@search');
    $r->put('update/{id}', 'AwardController@update');
    $r->delete('delete/{id}', 'AwardController@delete');
});

//**********************
//* Offense
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'offense',
    'namespace' => $namespace . '\Labor'
], function ($r) {
    $r->get('parameter', 'OffenseController@parameter');
    $r->post('create/{employeeId}', 'OffenseController@create');
    $r->get('search/{employeeId?}/{id?}', 'OffenseController@search');
    $r->put('update/{id}', 'OffenseController@update');
    $r->delete('delete/{id}', 'OffenseController@delete');
});

//**********************
//* Appraisal
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'appraisal',
    'namespace' => $namespace . '\Labor'
], function ($r) {
    $r->post('create/{employeeId}', 'AppraisalController@create');
    $r->get('parameter', 'AppraisalController@parameter');
    $r->get('stats/{id}', 'AppraisalController@stats');
    $r->get('search/{employeeId?}/{id?}', 'AppraisalController@search');
    $r->put('update/{id}', 'AppraisalController@update');
    $r->delete('delete/{id}', 'AppraisalController@delete');

    $r->post('mfo/create/{appraisalId}', 'MfoController@create');
    $r->get('mfo/parameter', 'MfoController@parameter');
    $r->get('mfo/search/{appraisalId}/{id?}', 'MfoController@search');
    $r->put('mfo/update/{id}', 'MfoController@update');
    $r->delete('mfo/delete/{id}', 'MfoController@delete');
});
