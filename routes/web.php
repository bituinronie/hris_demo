<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\LaborController;
use App\Http\Controllers\Report\HistoryController;
use App\Http\Controllers\Report\TrainingController;
use App\Http\Controllers\Report\SelfServiceController;
use App\Http\Controllers\Report\TimeKeepingController;
use App\Http\Controllers\Report\ApplicationMatrixController;
use App\Http\Controllers\Report\EmployeeManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//* declaration of variables
$reportNamespace = 'App\\Http\\Controllers\\Report';

Route::get('/', function () {
    return view('welcome');
});

//**********************
//* Reports
$prefix = 'generate/report';

// TODO: transfer Application Matrix Reports, Employee Management Reports, History Report, Time Keeping Reports on generateRouteUrl
$generateRouteUrl = function($reportNumber, $uri) use ($prefix) {
    return "$prefix/$reportNumber/$uri/{token}";
};

//* Application Matrix Reports
// Recruitment Matrix
Route::get("$prefix/8/single/am/{token}", [ApplicationMatrixController::class, 'singleAm']);


//* Employee Management Reports
// PDS
Route::get("$prefix/1/single/pds/{token}", [EmployeeManagementController::class, 'singlePds']);
Route::get("$prefix/1/multiple/pds/{token}", [EmployeeManagementController::class, 'multiplePds']); // TODO
Route::get("$prefix/1/portal/pds/{token}", [EmployeeManagementController::class, 'portalPds']);

// Position Description Form
Route::get("$prefix/1/single/pdf/{token}", [EmployeeManagementController::class, 'singlePdf']);
Route::get("$prefix/1/multiple/pdf/{token}", [EmployeeManagementController::class, 'multiplePdf']); // TODO

// Certificate of Employment
Route::get("$prefix/1/single/ce/{token}", [EmployeeManagementController::class, 'singleCe']);
Route::get("$prefix/1/multiple/ce/{token}", [EmployeeManagementController::class, 'multipleCe']); // TODO

// Employment Alphalist
Route::get("$prefix/1/plantilla/ea/{token}", [EmployeeManagementController::class, 'plantillaEa']);
Route::get("$prefix/1/jocos/ea/{token}", [EmployeeManagementController::class, 'joCosEa']);

//* History Reports
// Service Record
Route::get("$prefix/1/single/sr/{token}", [HistoryController::class, 'singleSr']);
Route::get("$prefix/1/multiple/sr/{token}", [HistoryController::class, 'multipleSr']); // TODO

// Manpower Updates
Route::get("$prefix/1/single/mu/{token}", [HistoryController::class, 'singleMu']);

// Manpower Complement
Route::get("$prefix/1/single/mc/{token}", [HistoryController::class, 'singleMc']);

// Statistical Summary
Route::get("$prefix/1/single/ss/{token}", [HistoryController::class, 'singleSs']);

//* Time Keeping Reports
// DTR
Route::get("$prefix/2/single/dtr/{token}", [TimeKeepingController::class, 'singleDtr']);
Route::get("$prefix/2/multiple/dtr/{token}", [TimeKeepingController::class, 'multipleDtr']); // TODO
Route::get("$prefix/2/portal/dtr/{token}", [TimeKeepingController::class, 'portalDtr']);

// Log-in and Log-out Summary
Route::get("$prefix/2/single/bandi-summary/{token}", [TimeKeepingController::class, 'singleBandiSummary']);

// Summary of Tardiness
Route::get("$prefix/2/single/tardiness-summary/{token}", [TimeKeepingController::class, 'singleTardinessSummary']);

// Monthly Attence Report
Route::get("$prefix/2/single/monthly-attendance/{token}", [TimeKeepingController::class, 'singleMonthlyAttendance']);

// Summary of Employees Absences
Route::get("$prefix/2/single/employee-absences/{token}", [TimeKeepingController::class, 'singleEmployeeAbsences']);

//* Self Service Reports
// Leave Application Form
Route::get($generateRouteUrl(3, "single/leave-application-form"), [SelfServiceController::class, 'singleLeaveApplicationForm']);
Route::get($generateRouteUrl(3, "portal/leave-application-form"), [SelfServiceController::class, 'portalLeaveApplicationForm']);

// Leave Ledger
Route::get($generateRouteUrl(3, "single/leave-ledger"), [SelfServiceController::class, 'singleLeaveLedger']);

// Leave Balances Report
Route::get($generateRouteUrl(3, "single/leave-balance"), [SelfServiceController::class, 'singleLeaveBalance']);

// Certification of Leave Credits
Route::get($generateRouteUrl(3, "single/certification-leave-credits"), [SelfServiceController::class, 'singleCertificationLeaveCredits']);

// Certification of No Leave without Pay
Route::get($generateRouteUrl(3, "single/certification-without-pay"), [SelfServiceController::class, 'singleCertificationWithoutPay']);

// Report of Salary Deduction/Cancellation from Restoration to Payroll
Route::get($generateRouteUrl(3, "single/salary-deduction-payroll"), [SelfServiceController::class, 'singleSalaryDeductionPayroll']);

// Monetization
Route::get($generateRouteUrl(3, "single/monetization"), [SelfServiceController::class, 'singleMonetization']);

// TODO: Update Employees Organization
// Route::get($generateRouteUrl(3, "single/update-employees-organization"), [SelfServiceController::class, 'singleUpdateEmployeesOrganization']);

// TODO: Import Organization
// Route::get($generateRouteUrl(3, "template/organization"), [SelfServiceController::class, 'templateOrganzation']);
// Route::post($generateRouteUrl(3, "import/organization"), [SelfServiceController::class, 'templateOrganzation']);

// Summary of Approved/Disapproved/Cancelled leave & CTO requests
Route::get($generateRouteUrl(3, "single/summary-request"), [SelfServiceController::class, 'singleSummaryRequest']);

// Summary of Employees with approved request to render overtime
Route::get($generateRouteUrl(3, "single/summary-employees-render-ot"), [SelfServiceController::class, 'singleSummaryEmployeesRenderOt']);

// Summary of Employees with approved request for night differential pay
Route::get($generateRouteUrl(3, "single/summary-employees-night-differential"), [SelfServiceController::class, 'singleSummaryEmployeesNightDifferential']);

// Monthly Summary of employees with negative VL and SL credits
Route::get($generateRouteUrl(3, "single/summary-employees-negative-leave-credits"), [SelfServiceController::class, 'singleSummaryEmployeesNegativeLeaveCredits']);

// Year-end list of employees unused VL and SL for commutation
Route::get($generateRouteUrl(3, "single/annual-employees-unused-leave"), [SelfServiceController::class, 'singleAnnualEmployeesUnusedLeave']);

//* Training Reports
// Summary of Training
Route::get($generateRouteUrl(4, "single/training-summary"), [TrainingController::class, 'singleTrainingSummary']);

//* Labor Employee Relations Reports
// Summary of Appraisal
Route::get($generateRouteUrl(5, "single/appraisal-summary"), [LaborController::class, 'singleAppraisalSummary']);

// Summary of Awards
Route::get($generateRouteUrl(5, "single/award-summary"), [LaborController::class, 'singleAwardSummary']);

// Summary of Offenses
Route::get($generateRouteUrl(5, "single/offense-summary"), [LaborController::class, 'singleOffenseSummary']);
