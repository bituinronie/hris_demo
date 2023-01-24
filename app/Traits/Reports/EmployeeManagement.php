<?php
namespace App\Traits\Reports;

use Mpdf\Mpdf;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Str;
use App\Models\ServiceRecord;
use App\Traits\ConstantTrait;
use Illuminate\Support\Collection;
use App\Classes\Reports\EmployeeManagementTemplate;

/**
 * Employee Management Trait
 */
trait EmployeeManagement
{
    use ConstantTrait;

    public $PDS_SETTING = [
        'format' => 'Legal',
        'margin_left' => 2.81,
        'margin_right' => 2.81,
        'margin_top' => 1,
        'margin_bottom' => 1
    ];

    public $PDF_SETTING = [
        'format' => 'A4',
        'margin_left' => 2.81,
        'margin_right' => 2.81,
        'margin_top' => 2.3,
        'margin_bottom' => 2.3
    ];

    public $CE_SETTING = [
        'format' => [215.9, 279.4],
        'margin_left' => 20,
        'margin_right' => 20,
        'margin_top' => 10,
        'margin_bottom' => 8
    ];

    public $EA_SETTING = [
        'format' => [279.4, 215.9],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 5
    ];

    //* Validation
    public function checkEmployeeId($employeeId){
        if($employeeId == null)
            return false;

        return Employee::find($employeeId)?true:false;
    }

    public function checkPositionId($positionId){
        if($positionId == null)
            return false;

        return Position::find($positionId)?true:false;
    }

    public function pds($id){
        $data = $this->pdsData($id);

        $report = new Mpdf($this->PDS_SETTING);

        $template = new EmployeeManagementTemplate;
        $report->WriteHTML($template->pds($data));

        return $report;
    }

    public function pdf($id, $employeeName = '', $supervisorName = ''){
        $data = $this->pdfData($id);
        $data->employeeName = $employeeName;
        $data->supervisorName = $supervisorName;

        $report = new Mpdf($this->PDS_SETTING);
        
        $template = new EmployeeManagementTemplate;
        $report->WriteHTML($template->pdf($data));

        return $report;
    }

    public function ce($id, $name1 = '', $position1 = '', $division1 = '',$name2 = '', $position2 = '', $division2 = ''){
        $data = $this->ceData($id);
        $data->name1 = Str::upper($name1);
        $data->position1 = Str::upper($position1);
        $data->division1 = Str::upper($division1);
        $data->name2 = Str::upper($name2);
        $data->position2 = Str::upper($position2);
        $data->division2 = Str::upper($division2);

        $report = new Mpdf($this->CE_SETTING);
        
        $template = new EmployeeManagementTemplate;
        $report->WriteHTML($template->ce($data));

        return $report;
    }

    public function pea($prepared = '', $preparedPosition = '', $supervisor = '', $supervisorPosition = '', $remarkId = null, $dateOfEmployment = null, $placeOfWork = null, $gender = null, $employeeGroupId = null){

        $data = $this->peaData($remarkId, $dateOfEmployment, $placeOfWork, $gender, $employeeGroupId);

        $data->prepared = Str::upper($prepared);
        $data->preparedPosition = Str::upper($preparedPosition);
        $data->supervisor = Str::upper($supervisor);
        $data->supervisorPosition = Str::upper($supervisorPosition);

        $report = new Mpdf($this->EA_SETTING);
        $report->setAutoTopMargin = 'stretch';
        $report->setAutoBottomMargin = 'stretch';
        
        $template = new EmployeeManagementTemplate;
        $report->WriteHTML($template->pea($data));

        return $report;
    }

    public function jcea($prepared = '', $preparedPosition = '', $supervisor = '', $supervisorPosition = ''){
        $data = $this->jceaData();
        $data->prepared = Str::upper($prepared);
        $data->preparedPosition = Str::upper($preparedPosition);
        $data->supervisor = Str::upper($supervisor);
        $data->supervisorPosition = Str::upper($supervisorPosition);

        $report = new Mpdf($this->EA_SETTING);
        
        $template = new EmployeeManagementTemplate;
        $report->WriteHTML($template->jocosea($data));

        return $report;
    }

    private function pdsData($id){
        $employee = Employee::find($id);

        // employee
        $pdsData = (object) $employee->makeHidden(['id', 'is_new','created_at','updated_at','deleted_at','role','username'])->toPDS()->toArray();

        // init variables
        $hiddenAttr = ['id', 'is_new','created_at','updated_at'];

        $limitQuery= function($model, $limit) {
            return $model->limit($limit)->get();
        };

        $mapFuction = function($item, $key) {
            return (object) $item->toPDS()->toArray();
        };

        // primary children
        $primaryChildrenQuery = $limitQuery($employee->childrens(), 12);
        $pdsData->children = $primaryChildrenQuery->makeHidden($hiddenAttr)->map($mapFuction)->toArray();
        // additional children
        $primaryChildrenId = $primaryChildrenQuery->map(function($item) { return $item->id; })->toArray();
        $additionalChildrenQuery = $employee->childrens()->whereArray('id',$primaryChildrenId,'!=')->get();
        $pdsData->additional_children = $additionalChildrenQuery->makeHidden($hiddenAttr)->map($mapFuction)->toArray();

        // primary education
        $levels = ['ELEMENTARY','SECONDARY','VOCATIONAL','COLLEGE','GRADUATE STUDIES'];
        $primaryEducationId = array_map(function($level) use ($employee) {
            return $employee->education()->where('level', $level)->orderDesc('attended_from')->first()->id ?? null;
        }, $levels);

        $primaryEducationQuery = $employee->education()->whereIn('id', $primaryEducationId)->orderDesc('attended_from')->get();
        $pdsData->education = (object) $primaryEducationQuery->makeHidden($hiddenAttr)->mapWithKeys(function($item, $key) {
            return (object) [$item->toArray()['level'] => (object) $item->toPDS()->toArray()];
        })->toArray();

        // additional education
        $additionalEducationQuery = $employee->education()->whereArray('id',$primaryEducationId,'!=')->orderDesc('attended_from')->get();
        $pdsData->additional_education = $additionalEducationQuery->makeHidden($hiddenAttr)->map($mapFuction)->toArray();

        // eligibility
        $primaryEligibilityQuery = $limitQuery($employee->eligibilities()->orderDesc('date_conferment'), 7);
        $pdsData->eligibility = $primaryEligibilityQuery->makeHidden($hiddenAttr)->map($mapFuction)->toArray();
        // additional eligibility
        $primaryEligibilityId = $primaryEligibilityQuery->map(function($item) { return $item->id; })->toArray();
        $additionalEligibilityQuery = $employee->eligibilities()->whereArray('id',$primaryEligibilityId,'!=')->orderDesc('date_conferment')->get();
        $pdsData->additional_eligibility = $additionalEligibilityQuery->makeHidden($hiddenAttr)->map($mapFuction)->toArray();

        // workExperience
        $primaryWorkExperienceQuery = $limitQuery($employee->workExperiences()->orderDesc('date_from'), 28);
        $pdsData->workExperience = $primaryWorkExperienceQuery->makeHidden($hiddenAttr)->map($mapFuction)->toArray();
        // additional workExperience
        $primaryWorkExperienceId = $primaryWorkExperienceQuery->map(function($item) { return $item->id; })->toArray();
        $additionalWorkExperienceQuery = $employee->workExperiences()->whereArray('id',$primaryWorkExperienceId,'!=')->orderDesc('date_from')->get();
        $pdsData->additional_workExperience = $additionalWorkExperienceQuery->makeHidden($hiddenAttr)->map($mapFuction)->toArray();

        // volunteering
        $primaryVolunteeringQuery = $limitQuery($employee->volunteerings()->orderDesc('date_from'), 7);
        $pdsData->volunteering = $primaryVolunteeringQuery->makeHidden($hiddenAttr)->map($mapFuction)->toArray();
        // additional volunteering
        $primaryVolunteeringId = $primaryVolunteeringQuery->map(function($item) { return $item->id; })->toArray();
        $additionalVolunteeringQuery = $employee->volunteerings()->whereArray('id',$primaryVolunteeringId,'!=')->orderDesc('date_from')->get();
        $pdsData->additional_volunteering = $additionalVolunteeringQuery->makeHidden($hiddenAttr)->map($mapFuction)->toArray();

        // training
        $primaryTrainingQuery = $employee->trainings()->limit(21)->orderDesc('date_from')->get()->filter(fn($item) => $item->isAllowedOnPds);
        $pdsData->training = $primaryTrainingQuery->map(function($item, $key) {
            return (object) collect($item->employeeRecord)->toPDS()->toArray();
        })->toArray();
        // additional training
        $primaryTrainingId = $primaryTrainingQuery->map(function($item) { return $item->id; })->toArray();
        $additionalTrainingQuery = $employee->trainings()->whereArray('id',$primaryTrainingId,'!=')->orderDesc('date_from')->get()->filter(fn($item) => $item->isAllowedOnPds);
        $pdsData->additional_training = $additionalTrainingQuery->makeHidden($hiddenAttr)->map(function($item, $key) {
            return (object) collect($item->employeeRecord)->toPDS()->toArray();
        })->toArray();

        // additional membership
        $membership = collect($pdsData->memberships);
        unset($pdsData->memberships);
        $pdsData->additional_membership = $membership->splice(7)->toArray();
        // membership
        $pdsData->membership = $membership->toArray();

        // additional skill
        $skill = collect($pdsData->skills);
        unset($pdsData->skills);
        $pdsData->additional_skill = $skill->splice(7)->toArray();
        // skill
        $pdsData->skill = $skill->toArray();

        // additional recognition
        $recognition = collect($pdsData->recognitions);
        unset($pdsData->recognitions);
        $pdsData->additional_recognition = $recognition->splice(7)->toArray();
        // recognition
        $pdsData->recognition = $recognition->toArray();

        // reference
        $primaryReferenceQuery = $limitQuery($employee->references(), 3);
        $pdsData->reference = $primaryReferenceQuery->makeHidden($hiddenAttr)->map($mapFuction)->toArray();
        // additional workExperience
        $primaryReferenceId = $primaryReferenceQuery->map(function($item) { return $item->id; })->toArray();
        $additionalReferenceQuery = $employee->references()->whereArray('id',$primaryReferenceId,'!=')->get();
        $pdsData->additional_reference = $additionalReferenceQuery->makeHidden($hiddenAttr)->map($mapFuction)->toArray();

        return $pdsData;
    }

    private function pdfData($id){
        $position = Position::find($id);
        $append = ['immediateSupervisorName','supervisedPositionTitleOnPrint','supervisedItemNumberOnPrint','sgOnPrint','salaryOnPrint','divisionOnPrint','equipmentsOnPrint'];
        $hidden = ['id','immediateSupervisor','supervised_position_title','supervised_item_number','equipments','div','sg','is_new','created_at','updated_at','deleted_at'];
        $pdfData = (object) $position->append($append)->makeHidden($hidden)->toPDF()->toArray();

        return $pdfData;
    }

    private function ceData($id){
        $employee = Employee::find($id);
        $data = (object) [
            'employee' => (object)[
                'fullName' => '',
                'position'  => '',
                'dateFrom' => '',
                'dateTo' => '',
                'supervisor'  => '',
                'status' => '',

            ]
        ];

        // date from
        $data->employee->dateFrom = $employee->date_hired?date('F d, Y', strtotime($employee->date_hired)):'';
        $srData = ServiceRecord::getRecord($employee->id); // init sr

        // date to
        if($srData != null && $data->employee->dateFrom != '')
            $data->employee->dateTo = $srData->date_to? date('F d, Y', strtotime($srData->date_to)):"Present";

        // full name
        $data->employee->fullName = "{$employee->statusTitle} ".ucwords(strtolower($employee->name));

        // supervisor
        $data->employee->supervisor = ucwords(strtolower($srData?->supervisorName));

        // position
        $data->employee->position = $srData->positionName ?? '';

        // status
        $data->employee->status = $srData->employmentStatusName ?? '';

  
        // TODO: Appraisals
        // $appraisalData = Appraisal::where('employee_id',$employeeData->id)->get();
        // $data['appraisal'] = [];
  
        // foreach ($appraisalData as $appraisal) {
        //     $mfos = $appraisal->mfo;
        //     $total = 0;
        //     $averages = [];
  
        //     $mfoVal = [];
        //     if(isset($mfos[0])){
        //         foreach ($mfos as $mfo) {
        //             $averageVal = [];
        //             $average = null;
  
        //             if($mfo->Q != null)
        //                 $averageVal[] = $mfo->Q;
        //             if($mfo->E != null)
        //                 $averageVal[] = $mfo->E;
        //             if($mfo->T != null)
        //                 $averageVal[] = $mfo->T;
  
        //             if(isset($averageVal[0])){
        //                 $averageVal = array_filter($averageVal);
        //                 $average = array_sum($averageVal)/count($averageVal);
        //                 $average = round($average, 3);
        //             }
  
        //             $mfoVal[] = [
        //                 'id' => $mfo->id,
        //                 'number' => $mfo->number,
        //                 'title' => $mfo->title,
        //                 'description' => $mfo->description,
        //                 'Q' => $mfo->Q,
        //                 'E' => $mfo->E,
        //                 'T' => $mfo->T,
        //                 'average' => $average
        //             ];
  
        //             if($average != null)
        //                 $averages[] = round($average, 3);
        //         }
        //         if($averages != []){
        //             $averages = array_filter($averages);
        //             $total = array_sum($averages)/count($averages);
        //         }
        //     }
  
        //     if(round($total) === 5){
        //       $rating = "(O)";
        //     }elseif(round($total) >= 4){
        //       $rating = "(VS)";
        //     }elseif(round($total) >= 3){
        //       $rating = "(S)";
        //     }elseif(round($total) >= 2){
        //       $rating = "(US)";
        //     }elseif(round($total) >= 1){
        //       $rating = "(P)";
        //     }else {
        //       $rating = "(NA)";
        //     }
  
        //     if($appraisal->semester == "1st"){
        //       $data['appraisal'][] = [
        //         'year' => "January to June ".date('Y',strtotime($appraisal->date)),
        //         'average' => number_format((float)$total, 3, '.', ''),
        //         'rating' => $rating
        //       ];
        //     }else {
        //       $data['appraisal'][] = [
        //         'year' => "July to December ".date('Y',strtotime($appraisal->date)),
        //         'average' => number_format((float)$total, 3, '.', ''),
        //         'rating' => $rating
        //     ];
        //     }
  
        // }
  
        // TODO: Offenses
        // $offenses = $employeeData->offenses;
  
        // foreach ($offenses as $offense) {
        //   $data['offense'][] =  [
        //     'nature_of_charge' =>  $offense->offense." (".date("F d, Y", strtotime($offense->memo_date)).")",
        //     'status' => ucwords($offense->status),
        //     'disiplinary_action' => $offense->corrective_action_taken
        //   ];
        // }
        

        // TODO: Leave and Absences Breakdown
        // $leaveLedgerData = LeaveLedger::select('employee_id','request_type_id','remarks','credit','status')
        // ->where('employee_id',$id)
        // ->where('credit','<=',0)
        // ->get();
  
        // $data['dtr'] = [
        //   'l' =>  0,
        //   'vl' =>  0,
        //   'sl' => 0,
        //   'spl' => 0,
        //   'fl' => 0,
        //   'sopl' => 0
        // ];
  
        // if($employeeData->gender == "Male"){
        //   $data['dtr']['pl'] =  0;
        // }elseif($employeeData->gender == "Female"){
        //   $data['dtr']['ml'] =  0;
        // }
        // $conditionStatus = ['manual', 'automatic', 'approved'];
  
        // foreach ($leaveLedgerData as $leaveLedger) {
        //   if(in_array($leaveLedger->status, $conditionStatus) == false)
        //     continue;
  
        //   $requestType = RequestType::find($leaveLedger['request_type_id']);
        //   $key = strtolower($requestType->code);
  
        //   if(!isset($data['dtr'][$key]))
        //     continue;
  
        //   if($leaveLedger->remarks == "DEDUCTED DUE TO FL;" || $leaveLedger->remarks == "DEDUCTED DUE TO SPL;")
        //     continue;
  
        //   if($leaveLedger->remarks != null){
        //     if(strpos($leaveLedger->remarks, "UT;") != false){
        //       $data['dtr']['l'] += abs($leaveLedger->credit);
        //     }elseif(strpos($leaveLedger->remarks, "LATE;") != false){
        //       $data['dtr']['l'] += abs($leaveLedger->credit);
        //     }
        //   }else{
        //     $data['dtr'][$key] += abs($leaveLedger->credit);
        //   }
        // }
  
        // foreach ($data['dtr'] as $key => $value) {
        //   $data['dtr'][$key] = round($value,3);
        // }
  
        return $data;
    }

    public function peaData($remarkId, $dateOfEmployment, $placeOfWork, $gender, $employeeGroupId){
        $employees = Employee::select('*')->orderBy('last_name','ASC')->get();

        $filteredEmployees = $employees->filter(function($employee) use ($remarkId, $dateOfEmployment, $placeOfWork, $gender, $employeeGroupId) {
            $employeeRecord = ServiceRecord::getRecord($employee->id);
            if ($employeeRecord == null)
                return false;

            if(in_array($employeeRecord->remark_id, $this->remarkIdNotApplied))
                return false;

            if($remarkId) {
                if($remarkId != $employeeRecord->remark_id)
                    return false;
            }

            if($dateOfEmployment) {
                if($dateOfEmployment != $employee->dateHired)
                    return false;
            }

            if($placeOfWork) {
                if($placeOfWork != $employeeRecord->place_of_work)
                    return false;
            }

            if($gender) {
                if($gender != $employee->gender)
                    return false;
            }

            if($employeeGroupId) {
                if($employeeGroupId != $employeeRecord->employee_group_id)
                    return false;
            }

            return true;
        })->flatten();

        $returnData = (object) $filteredEmployees->mapToGroups(function($employee) {
            $employeeRecord = ServiceRecord::getRecord($employee->id);

            return [
                Str::upper($employee->division) => (object) [
                    'name' => Str::upper($employee->nameLastNameFirst),
                    'position' => Str::upper($employee->designationName),
                    'sg' => $employeeRecord->designation?->sg['sg'],
                    'item_number' => Str::upper($employeeRecord?->designation?->item_number),
                    'employmentStatus' => Str::upper($employeeRecord?->employmentStatus['name']),
                    'dateHired' => $employee->dateHired,
                    'dateLastPromotion' => $employee->dateLastPromotion
                ]
            ];
        })->toArray();

        return (object) [
            'data' => $returnData
        ];
    }

    public function jceaData(){
        $employees = Employee::select('*')->orderBy('last_name','ASC')->get();

        $filteredEmployees = $employees->filter(function($employee) {
            $employeeRecord = ServiceRecord::getRecord($employee->id);
            if ($employeeRecord == null)
                return false;

            // check remark Id & check employment status
            return !in_array($employeeRecord->remark_id, $this->remarkIdNotApplied) &&
                    ($employeeRecord->employment_status_id == 10 || $employeeRecord->employment_status_id == 11);
        })->flatten();

        $returnData = (object) $filteredEmployees->map(function($employee) {
            return (object) [
                'surname' => Str::upper($employee->last_name),
                'first_name' => Str::upper($employee->first_name),
                'mi' => $employee->middle_name?Str::upper($employee->middle_name[0]):'-',
                'position' => Str::upper($employee->designationName),
                'sex' => $employee->gender[0],
                'office' => Str::upper($employee->placeOfWork),
                'report_at'  => Str::upper($employee->group),
                'dateHired' => $employee->dateHired,
            ];
        })->toArray();

        return (object) [
            'data' => $returnData
        ];
    }
}
