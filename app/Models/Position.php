<?php
namespace App\Models;

use App\Models\Division;
use App\Traits\ModelTrait;

use App\Models\SalaryGrade;

use App\Traits\ConstantTrait;
use App\Models\EmploymentStatus;

use App\Traits\Scopes\ModelScope;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory, ModelScope, ModelAttribute, SoftDeletes, LogsActivity, ModelTrait, ConstantTrait;

    protected $fillable = [
        'title',
        'former_position',
        'item_number',
        'place_of_work',
        'salary_grade_id',
        'supervisor_id',
        'division_id',
        'classification',
        'level',
        'employment_status_id',
        'funding_source_id',
        'supervised_position_title',
        'supervised_item_number',
        'contact_internal_executive',
        'contact_internal_supervisor',
        'contact_internal_non_supervisor',
        'contact_internal_staff',
        'contact_external_public',
        'contact_external_agencies',
        'contact_external_others',
        'office_work',
        'field_work',
        'other_work',
        'general_function',
        'job_summary',
        'education',
        'experience',
        'training',
        'eligibility',
        'core_compentencies',
        'core_competency_level',
        'leadership_competencies',
        'leadership_compentency_level',
        'percentage_working_time',
        'duties_responsibilities',
        'duties_competency_level',
        'equipments',
    ];

    protected $hidden = [
        'employment_status_id',
        'funding_source_id',
        'salary_grade_id',
        'salaryGrade',
        'division',
        'supervisor_id',
        'division_id',
    ];

    protected $casts = [
        'equipments' => 'array',
    ];

    protected $appends = [
        'is_new',
        'sg',
        'div',
        'immediateSupervisor',
        'nextSupervisorName',
        'positionName',
        'employmentStatus',
        'fundingSource',
    ];

    protected static $logName = 'Position';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Position is $eventName";
    }

    public function salaryGrade()
    {
        return $this->belongsTo(SalaryGrade::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Position::class, 'supervisor_id', 'id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function serviceRecords()
    {
        return $this->hasMany(ServiceRecord::class);
    }

    public function status()
    {
        return $this->belongsTo(EmploymentStatus::class, 'employment_status_id', 'id');
    }

    public function fundingSourceModel()
    {
        return $this->belongsTo(FundingSource::class, 'funding_source_id', 'id');
    }

    public function getEmploymentStatusAttribute(){
        return $this->status()->select('id','code','description')->first()?->makeHidden('is_new');
    }

    public function getEmploymentStatusDescriptionAttribute(){
        return $this->status->description;
    }

    public function getFundingSourceAttribute(){
        return $this->fundingSourceModel()->select('id','code','description')->first()?->makeHidden('is_new');
    }

    public function getFundingSourceDescriptionAttribute(){
        return $this->fundingSourceModel->description;
    }

    public function getSgAttribute(){
        $salaryGrade = $this->salaryGrade;

        return [
            'salary_grade_id' => $salaryGrade->id ?? null,
            'sg' => $salaryGrade->salary_grade ?? null,
            'salary' => $salaryGrade->salary ?? null
        ];
    }

    public function getSgOnPrintAttribute(){
        $salaryGrade = $this->salaryGrade;
        return isset($salaryGrade->salary_grade)?"SG-{$salaryGrade->salary_grade}":null;
    }

    public function getSalaryAttribute(){
        $salaryGrade = $this->salaryGrade;

        return $salaryGrade->salary ?? null;
    }

    public function getSalaryOnPrintAttribute(){
        $salaryGrade = $this->salaryGrade;

        return isset($salaryGrade->salary)? 'P '.number_format($salaryGrade->salary,2,".",","):null;
    }

    public function getDivAttribute(){
        $division = $this->division;

        return [
            'division_id' => $division->id ?? null,
            'name' => $division->name ?? null
        ];
    }

    public function getDivisionOnPrintAttribute(){
        $division = $this->division;
        return $division->name ?? null;
    }

    public function getPositionNameAttribute(){
        $formerPosition = $this->former_position != null && $this->title != $this->former_position?" ({$this->former_position})":'';

        return "{$this->title}$formerPosition";
    }

    public function getImmediateSupervisorAttribute(){
        $supervisor = $this->supervisor()->first();
        return [
            'supervisor_id' => $supervisor->id ?? null,
            'name' => $supervisor->positionName ?? null
        ];
    }

    public function getImmediateSupervisorNameAttribute(){
        return $this->supervisor()->first()->positionName ?? null;
    }

    public function getNextSupervisorNameAttribute(){
        $supervisor = $this->supervisor()->first();
        $nextSupervisor = $supervisor?->supervisor()?->first();

        return $nextSupervisor->positionName ?? null;
    }

    public function getEmployeeAssignedToAttribute(){
        $serviceRecords = $this->serviceRecords()->orderBy('date_from','DESC')->get();
        if(empty($serviceRecords))
            return null;

        $employeeId = null;
        $dateToday = date('Y-m-d');
        
        $employee = null;
        foreach ($serviceRecords as $record) {
            if($record['date_to'] != null) {
                if(strtotime($record['date_to']) > strtotime($dateToday))
                    continue;
            }

            if(in_array($record['remark_id'], $this->remarkIdNotApplied))
                continue;

            $employee = $record->employee;
            break;
        }

        return $employee;
    }

    public function getEquipmentsOnPrintAttribute(){
        $equipments = $this->equipments;
        if ($equipments == null)
            return null;

        $equStr = "";
        $arrCount = count($equipments);
        for ($i=0; $i < $arrCount; $i++) {
            if($i == $arrCount-1){
                if($i > 0)
                    $equStr .= " and ";

                $equStr .= $equipments[$i];
            }else{
                if($i != 0)
                    $equStr .= ", ";

                $equStr .= $equipments[$i];
            }
        }

        return $equStr;
    }

    public function getSupervisedPositionTitleOnPrintAttribute(){
        return str_replace('\n', '<br>', $this->supervised_position_title);
    }

    public function getSupervisedItemNumberOnPrintAttribute(){
        return str_replace('\n', '<br>', $this->supervised_item_number);
    }

    public function getSsDescriptionAttribute(){
        $returnString = "({$this->title})";

        if($this->sgOnPrint)
            $returnString .= " ($this->sgOnPrint)";

        return $returnString;
    }

    public function scopeSupervisorParams(){
        $allPositions = $this->all();

        return $allPositions->map(function($item, $key) {
            return [
                'id' => $item->id,
                'positionName' => $item->positionName,
                'immediateSupervisorName' => $item->immediateSupervisorName,
            ];
        });
    }

    public function scopeEquipmentsParams(){
        $collection = $this->all()->pluck('equipments');
        return $collection->unique()->collapse();
    }

    public function scopeServiceRecordParams(){
        $allPositions = $this->orderBy('created_at','DESC')->get();

        return $allPositions->map(function($item, $key) {

            // getting supervisor
            $supervisorPosition = $item->supervisor;
            $employeeRecord = $supervisorPosition->employeeAssignedTo ?? null;

            $supervisor = null;
            if($employeeRecord != null)
                $supervisor = [
                    'employee_id' => $employeeRecord->id,
                    'name' => $employeeRecord->name
                ];

            // higher supervisor
            $higherSupervisorPosition = $supervisorPosition->supervisor ?? null;
            $employeeRecord = $higherSupervisorPosition->employeeAssignedTo ?? null;

            $higherSupervisor = null;
            if($employeeRecord != null)
                $higherSupervisor = [
                    'employee_id' => $employeeRecord->id,
                    'name' => $employeeRecord->name
                ];

            return [
                'id' => $item->id,
                'positionName' => $item->positionName,
                'item_number' => $item->item_number,
                'salary' => $item->salary,
                'division' => $item->div,
                'supervisor' => $supervisor,
                'higherSupervisor' => $higherSupervisor,
                'classification' => $item->classification,
                'level' => $item->level,
                'employmentStatus' => $item->employmentStatus,
                'fundingSource' => $item->fundingSource,
            ];
        });
    }

    public function getStepsAttribute(){
        return SalaryGrade::select('id','step','salary')->where('tranche',$this->salaryGrade->tranche)->where('salary_grade', $this->salaryGrade->salary_grade)->orderBy('salary_grade','ASC')->get()->map(fn($item)=>[
            'salary_grade_id' => $item->id,
            'step' => $item->step,
            'salary' => $item->salary
        ]);
    }
}