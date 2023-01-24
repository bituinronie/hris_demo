<?php
namespace App\Models;

use App\Traits\ModelTrait;
use App\Models\EmployeeGroup;

use App\Traits\ConstantTrait;

use Illuminate\Support\Carbon;
use App\Traits\Scopes\ModelScope;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceRecord extends Model implements HasMedia
{
    use HasFactory, ModelScope, ModelAttribute, SoftDeletes, LogsActivity, ModelTrait, InteractsWithMedia, ConstantTrait;

    protected $fillable = [
        'employee_id',
        'date_from',
        'date_to',
        'employee_group_id',
        'position_id',
        'positionOnPrint',
        'salary',
        'assigned_to',
        'divisionOnPrint',
        'assigned_supervisor',
        'supervisorOnPrint',
        'date_seperation',
        'cause',
        'employment_status_id',
        'funding_source_id',
        'remark_id',
        'awol_at',
        'show_in_reports',
        'is_uniformed',
        'cancellation_reason',
        'is_exempted',
        'date_hired',
        'place_of_work',
        'is_wfh',
        'classification',
        'level',
        'attachment'
    ];

    protected $hidden = [
        'employee_id',
        'employee_group_id',
        'position_id',
        'assigned_to',
        'assigned_supervisor',
        'group',
        'designation',
        'employmentStatus',
        'assignedTo',
        'assignedSupervisor',
        'status',
        'remarkModel',
    ];

    protected $casts = [
        'awol_at' => 'array',
        'date_from' => 'datetime:Y-m-d',
        'date_to' => 'datetime:Y-m-d',
        'date_seperation' => 'datetime:Y-m-d',
        'show_in_reports' => 'boolean',
        'is_uniformed' => 'boolean',
        'is_exempted' => 'boolean',
        'date_hired' => 'boolean',
        'is_wfh' => 'boolean',
    ];

    static public $temporaryAttachment = null;

    protected $appends = ['position','division','supervisor','employee_group','employment_status','remark','is_new'];

    protected static $logName = 'Service Record';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName=='created')
            return 'A Service Record has been assigned to an employees.';
        if ($eventName=='updated')
            return 'A Service Record of an employees has been updated.';
        if ($eventName=='deleted')
            return 'A Service Record has been removed from an employees.';
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function group()
    {
        return $this->belongsTo(EmployeeGroup::class,'employee_group_id','id');
    }

    public function designation()
    {
        return $this->belongsTo(Position::class,'position_id','id');
    }

    public function status()
    {
        return $this->belongsTo(EmploymentStatus::class,'employment_status_id','id');
    }

    public function remarkModel()
    {
        return $this->belongsTo(Remark::class,'remark_id','id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(Division::class, 'assigned_to', 'id');
    }

    public function assignedSupervisor()
    {
        return $this->belongsTo(Employee::class, 'assigned_supervisor', 'id');
    }

    protected static function boot(){
        parent::boot();

        ServiceRecord::creating(function($model) {
             // preparing proof
             if(isset($model->attachment)) {
                self::$temporaryAttachment = $model->attachment;
            }

            unset($model->attachment);
        });

        ServiceRecord::updating(function($model) {
            // preparing proof
            if(isset($model->attachment)) {
                self::$temporaryAttachment = $model->attachment;
            }

            unset($model->attachment);
        });

        ServiceRecord::created(function($model) {
            // Proof Attatchment
            if(self::$temporaryAttachment) {
                $model->addMedia(self::$temporaryAttachment)
                    ->toMediaCollection('attachment');

                self::$temporaryAttachment = null;
            }
        });

        ServiceRecord::updated(function($model) {
            // Proof Attatchment
            if(self::$temporaryAttachment) {
                if($model->attachmentUrl != null)
                    $model->getMedia('attachment')->first()->delete();

                $model->addMedia(self::$temporaryAttachment)
                    ->toMediaCollection('attachment');

                self::$temporaryAttachment = null;
            }
        });
    }


    public static function getRecord($employeeId, $date = null, $isStrict = false){
        if($date == null) {
            $entity = ServiceRecord::where('employee_id', $employeeId)->orderBy('date_from','DESC')->first();
        }else {
            $entities = ServiceRecord::where('employee_id', $employeeId)->orderBy('date_from', 'DESC')->get()->filter(function($item) use($date) {

                $dateSent = Carbon::parse($date);

                if($item->date_to == null) {
                    $dateFrom = Carbon::parse($item->date_from);
                    if($dateFrom->timestamp <= $dateSent->timestamp)
                        return true;
                }else {
                    if($dateSent->between($item->date_from, $item->date_to))
                        return true;
                }

                return false;
            });

            $entity = $entities->first() ?? null;
        }

        if ($entity) {

            if ($isStrict) {
                if (in_array($entity->remark_id, self::$remarkIdNotAppliedOnStatic))
                    return false;
            }

            return $entity;
        }

        return null;
    }

    // date_from
    public function getDateFromAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):null;
    }

    // date_to
    public function getDateToAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):null;
    }

    // position name
    public function getPositionNameAttribute(){
        $position = $this->designation;

        return $position->position_name ?? $this->positionOnPrint;
    }

    // position on print
    public function getDesignationOnPrintAttribute(){
        $position = $this->positionName;

        return preg_replace("/\([^)]+\)/", "", $position);
    }

    // position
    public function getPositionAttribute(){
        $position = $this->designation;
        if($position == null)
            return null;

        return [
            'position_id' => $position->id,
            'name' => $position->position_name,
            'salary' => $position->salary,

        ];
    }

    // division name
    public function getDivisionNameAttribute(){
        $division = $this->assignedTo;
        return $division->name ?? $this->divisionOnPrint;
    }

    // division
    public function getDivisionAttribute(){
        $division = $this->assignedTo;
        if($division == null)
            return null;

        return [
            'assigned_to' => $division->id,
            'name' => $division->name
        ];
    }

    // employee group name
    public function getEmployeeGroupNameAttribute(){
        $employeeGroup = $this->group;
        return $employeeGroup->description;
    }

    // employee group
    public function getEmployeeGroupAttribute(){
        $employeeGroup = $this->group;
        return [
            'employee_group_id' => $employeeGroup->id,
            'name' => $employeeGroup->description,
        ];
    }

    // supervisor name
    public function getSupervisorNameAttribute(){
        $employee = $this->assignedSupervisor;
        return $employee->name ?? $this->supervisorOnPrint;
    }

    // supervisor
    public function getSupervisorAttribute(){
        $employee = $this->assignedSupervisor;
        if($employee == null)
            return null;

        return [
            'assigned_supervisor' => $employee->id,
            'name' => $employee->name
        ];
    }

    // employment status name
    public function getEmploymentStatusNameAttribute(){
        $employmentStatus = $this->status;
        return $employmentStatus->description;
    }

    public function scopeGetDateHired($query, $employeeId = null){
        if($employeeId == null)
            $employeeId = $this->employee_id;
        return $this->where('employee_id', $employeeId)->where('date_hired',true)->first()->date_from ?? null;
    }

    // employment status
    public function getEmploymentStatusAttribute(){
        $employmentStatus = $this->status;
        return [
            'employment_status_id' => $employmentStatus->id,
            'name' => $employmentStatus->description
        ];
    }

    // remark name
    public function getRemarkNameAttribute(){
        $remark = $this->remarkModel;
        return !is_null($remark)?$remark->description:"";
    }

    // remark
    public function getRemarkAttribute(){
        $remark = $this->remarkModel;
        return !is_null($remark)?[
            'remark_id' => $remark->id,
            'name' => $remark->description
        ]:['remark_id' => null,'name'=>''];
    }

    // remark on print
    public function getRemarkOnPrintAttribute(){
        $remark = $this->remarkModel;

        return match ($remark->id) {
            26,27 => $remark->cancellation_reason,
            default => $remark->description
        };
    }

    // date_from on print
    public function getDateFromOnPrintAttribute(){
        $dateFrom = $this->date_from;

        return date('d-M-y', strtotime($dateFrom));
    }

    // date_to on print
    public function getDateToOnPrintAttribute(){
        $dateTo = $this->date_to;

        if ($dateTo == null)
            return 'present';

        return date('d-M-y', strtotime($dateTo));
    }

    // date_seperation on print
    public function getDateSeperationOnPrintAttribute(){
        $dateSeperation = $this->date_seperation;

        if ($dateSeperation == null)
            return null;

        return date('d-M-y', strtotime($dateSeperation));
    }

    // salary
    public function getSalaryOnPrintAttribute(){
        $salary = $this->salary;

        return number_format($salary, 2, '.', ',');
    }

    public function scopeToPrint(){
        return [
            'id' => $this->id,
            'from' => $this->dateFromOnPrint,
            'to' => $this->dateToOnPrint,
            'designation' => $this->designationOnPrint,
            'status' => $this->employmentStatusName,
            'salary' => $this->salaryOnPrint,
            'division' => $this->divisionName,
            'supervisor' => $this->supervisorName,
            'date' => $this->dateSeperationOnPrint,
            'cause' => $this->cause,
            'awol_at' => $this->awol_at,
            'remark' => $this->remarkOnPrint,
            'employement_status_id' => $this->employment_status_id
        ];
    }

    public function getAttachmentUrlAttribute(){
        return $this->getMedia('attachment')->first()?->getFullUrl();
    }
}