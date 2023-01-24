<?php
namespace App\Models;

use Carbon\Carbon;
use App\Models\User;

use App\Models\Approver;

use App\Models\Children;

use App\Models\Security;
use App\Models\Education;
use App\Models\Reference;
use App\Traits\ModelTrait;
use App\Models\Eligibility;
use App\Models\LeaveLedger;
use Illuminate\Support\Str;
use App\Models\Volunteering;
use App\Models\ServiceRecord;
use App\Models\WorkExperience;
use App\Models\EmployeeSchedule;
use App\Models\EmployeeTraining;
use App\Traits\LeaveLedgerTrait;
use App\Traits\Scopes\ModelScope;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model implements HasMedia
{
    use HasFactory, ModelScope, ModelAttribute, SoftDeletes, LogsActivity, ModelTrait, InteractsWithMedia, LeaveLedgerTrait;

    protected $fillable = [
        'user_id',
        'employee_number',
        'last_name',
        'first_name',
        'middle_name',
        'name_extension',
        'birth_date',
        'birth_place',
        'gender',
        'civil_status',
        'civil_status_others',
        'height',
        'weight',
        'blood_type',
        'gsis',
        'pagibig',
        'philhealth',
        'sss',
        'tin',
        'citizenship',
        'citizenship_by',
        'citizenship_by_country',
        'residential_housenum',
        'residential_street',
        'residential_subdivision',
        'residential_barangay',
        'residential_city',
        'residential_province',
        'residential_zipcode',
        'permanent_housenum',
        'permanent_street',
        'permanent_subdivision',
        'permanent_barangay',
        'permanent_city',
        'permanent_province',
        'permanent_zipcode',
        'telephone',
        'mobile',
        'email',
        'spouse_last_name',
        'spouse_first_name',
        'spouse_middle_name',
        'spouse_name_extension',
        'spouse_occupation',
        'spouse_telephone',
        'spouse_employer_business',
        'spouse_business_address',
        'father_last_name',
        'father_first_name',
        'father_middle_name',
        'father_name_extension',
        'mother_last_name',
        'mother_first_name',
        'mother_middle_name',
        'is_affiliated_third',
        'affiliated_third',
        'is_affiliated_fourth',
        'affiliated_fourth',
        'is_found_guilty',
        'found_guilty',
        'is_criminally_charged',
        'criminally_charged_date',
        'criminally_charged_status',
        'is_convicted',
        'convicted',
        'is_separated_service',
        'separated_service',
        'is_candidate',
        'candidate',
        'is_resigned',
        'resigned',
        'is_immigrant',
        'immigrant',
        'is_indigenous',
        'indigenous',
        'is_disabled',
        'disabled',
        'is_solo',
        'solo',
        'government_id_type',
        'government_id_number',
        'issued_date',
        'issued_place',
        'memberships',
        'skills',
        'recognitions',
    ];

    protected $appends = ['role', 'username','is_new'];

    protected $hidden = [
        'user_id',
        'user',
        'generate_password',
    ];

    protected $casts = [
        'birth_date' => 'datetime:Y-m-d',
        'criminally_charged_date' => 'datetime:Y-m-d',
        'issued_date' => 'datetime:Y-m-d',
        'is_affiliated_third' => 'boolean',
        'is_affiliated_fourth' => 'boolean',
        'is_found_guilty' => 'boolean',
        'is_criminally_charged' => 'boolean',
        'is_convicted' => 'boolean',
        'is_separated_service' => 'boolean',
        'is_candidate' => 'boolean',
        'is_resigned' => 'boolean',
        'is_immigrant' => 'boolean',
        'is_indigenous' => 'boolean',
        'is_disabled' => 'boolean',
        'is_solo' => 'boolean',

        'memberships' => 'array',
        'skills' => 'array',
        'recognitions' => 'array',
    ];

    protected static $logName = 'Employee';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Employee is $eventName";
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function security(){
        return $this->hasOne(Security::class,'employee_id','id');
    }

    public function childrens(){
        return $this->hasMany(Children::class);
    }

    public function education(){
        return $this->hasMany(Education::class);
    }

    public function eligibilities(){
        return $this->hasMany(Eligibility::class);
    }

    public function workExperiences(){
        return $this->hasMany(WorkExperience::class);
    }

    public function volunteerings(){
        return $this->hasMany(Volunteering::class);
    }

    public function trainings(){
        return $this->hasMany(EmployeeTraining::class);
    }

    public function appraisals(){
        return $this->hasMany(Appraisal::class);
    }

    public function references(){
        return $this->hasMany(Reference::class);
    }

    public function schedules(){
        return $this->hasMany(EmployeeSchedule::class, 'employee_id', 'id');
    }

    public function serviceRecords(){
        return $this->hasMany(ServiceRecord::class, 'employee_id', 'id');
    }

    public function dtrs(){
        return $this->hasMany(Dtr::class);
    }

    public function timeLogs(){
        return $this->hasMany(TimeLog::class);
    }

    public function approver(){
        return $this->belongsTo(Approver::class);
    }

    public function leaveLedgers(){
        return $this->hasMany(LeaveLedger::class, 'employee_id', 'id');
    }

    protected static function boot(){
        parent::boot();

        // TODO: auto generate dtr for current month

        static::deleting(function($employee) {
            // Delete employee related records
            if ($employee->isForceDeleting()) {
                $employee->security()->delete();
            
                $employee->childrens()->delete();
            
                $employee->education()->delete();
            
                $employee->eligibilities()->delete();
            
                $employee->workExperiences()->delete();
            
                $employee->volunteerings()->delete();
            
                $employee->trainings()->delete();
            
                $employee->references()->delete();
            
                $employee->schedules()->delete();
            
                $employee->serviceRecords()->forceDelete();

                $employee->dtrs()->delete();

                $employee->timeLogs()->delete();
            }
        });
    }

    public static function findByRfid($rfid){
        $security = Security::where('rfid', $rfid)->first();
        if ($security === null)
            return null;

        $employee = Employee::find($security->employee_id);

        return $employee;
    }

    public static function findByFaceData($facedata){
        $security = Security::where('face_template', $facedata)->first();
        if ($security === null)
            return null;

        $employee = Employee::find($security->employee_id);

        return $employee;
    }

    public static function findByUserId($userId){
        $employee = Employee::where('user_id', $userId)->first();
        return $employee;
    }

    public static function getTodaySchedule($employeeId){
        $employeeSchedule = self::getScheduleByDate($employeeId, date('Y-m-d'));

        return [
            'id' => $employeeSchedule?->id,
            'code' => $employeeSchedule?->code,
            'description' => $employeeSchedule?->description,
            'time_in' => $employeeSchedule?->time_in?->copy()->format('H:i:s'),
            'lunch_out' => $employeeSchedule?->lunch_out?->copy()->format('H:i:s'),
            'lunch_in' => $employeeSchedule?->lunch_in?->copy()->format('H:i:s'),
            'time_out' => $employeeSchedule?->time_out?->copy()->format('H:i:s'),
        ];
    }

    public static function getScheduleByDate($employeeId, $date, $isStrict = false){
        $employee = Employee::find($employeeId);
        $employeeSchedule = $employee->schedules()->whereDate('effective_date', '<=', $date)->orderBy('effective_date', 'DESC')->first();
        if ($employeeSchedule === null)
            return null;

        // special schedule condition
        if($employeeSchedule->schedule_type === 'SPECIAL') {
            $startDate = $employeeSchedule->effective_date->copy()->format('Y-m-d');
            $endDate = $employeeSchedule->effective_date->copy()->format('Y-m-t');

            $datePassed = Carbon::parse($date);

            if(!$datePassed->between($startDate, $endDate))
                return null;
        }

        // init schedule Data
        $scheduleData = $employeeSchedule->schedule ?? $employeeSchedule->specialScheduleModel;
        $day = Str::lower(Carbon::parse($date)->format('D'));

        $schedule = (object) match($employeeSchedule->schedule_type) {
            'SPECIAL' => [
                'id' => $scheduleData->id,
                'code' => Str::upper($scheduleData->code),
                'description' => Str::upper($scheduleData->description),
                'time_in' => $employeeSchedule->special_schedule->{$date}->time_in?Carbon::parse($employeeSchedule->special_schedule->{$date}->time_in):null,
                'lunch_out' => $employeeSchedule->special_schedule->{$date}->lunch_out?Carbon::parse($employeeSchedule->special_schedule->{$date}->lunch_out):null,
                'lunch_in' => $employeeSchedule->special_schedule->{$date}->lunch_in?Carbon::parse($employeeSchedule->special_schedule->{$date}->lunch_in):null,
                'time_out' => $employeeSchedule->special_schedule->{$date}->time_out?Carbon::parse($employeeSchedule->special_schedule->{$date}->time_out):null,
                'flexi_from' => null,
                'flexi_to' => null,
                'isFlexi' => false
            ],
            'REGULAR' => [
                'id' => $scheduleData->id,
                'code' => Str::upper($scheduleData->code),
                'description' => Str::upper($scheduleData->description),
                'time_in' => $scheduleData->{$day.'_time_in'},
                'lunch_out' => $scheduleData->{$day.'_lunch_out'},
                'lunch_in' => $scheduleData->{$day.'_lunch_in'},
                'time_out' => $scheduleData->{$day.'_time_out'},
                'flexi_from' => $scheduleData->flexi_from,
                'flexi_to' => $scheduleData->flexi_to,
                'isFlexi' => $scheduleData->isFlexi
            ]
        };

        if(is_null($schedule->time_in) && is_null($schedule->time_out)) {
            if ($isStrict)
                return null;
        }

        // hasLunch
        $hasLunch = $schedule->lunch_out && $schedule->lunch_in;

        // schedule work minutes
        $workMinutes = $hasLunch ? 
            (
                $schedule->time_in?->copy()?->diffInMinutes($schedule->lunch_out) +
                $schedule->lunch_in?->copy()?->diffInMinutes($schedule->time_out)
            ): 
            $schedule->time_in?->copy()?->diffInMinutes($schedule->time_out);

        // schedule lunch minutes
        $lunchMinutes = $hasLunch?$schedule->lunch_out->copy()->diffInMinutes($schedule->lunch_in):0;

        return (object) [
            'id' => $schedule->id,
            'employeeScheduleId' => $employeeSchedule->id,
            'effectiveDate' => $employeeSchedule->effective_date->toDateString(),
            'code' => $schedule->code,
            'description' => $schedule->description,
            'time_in' => $schedule->time_in,
            'lunch_out' => $schedule->lunch_out,
            'lunch_in' => $schedule->lunch_in,
            'time_out' => $schedule->time_out,
            'flexi_from' => $schedule->flexi_from,
            'flexi_to' => $schedule->flexi_to,
            'isFlexi' => $schedule->isFlexi,
            'hasLunch' => $hasLunch,
            'workMinutes' => $workMinutes,
            'lunchMinutes' => $lunchMinutes,
            'isSpecial' => $employeeSchedule->schedule_type == 'SPECIAL',
        ];
    }

    public static function getLeavesByDate($employeeId, $date, $template = null){
        $employee = self::find($employeeId);

        $leaves = $employee
                    ->leaveLedgers()
                    ->whereDate('from', '<=', $date)
                    ->whereDate('to', '>=', $date)
                    ->where('credit','<=',0)
                    ->get()
                    ->filter(fn($item) => in_array($item->requestType->category,['LEAVES','OB','OT']))
                    ->map(function($item) use ($date, $template) {
                        $schedule = self::getScheduleByDate($item->employee_id, $date);

                        $bandi = $template ?? [
                            'time_in' => $schedule->time_in,
                            'lunch_out' => $schedule->lunch_out,
                            'lunch_in' => $schedule->lunch_in,
                            'time_out' => $schedule->time_out,
                        ];

                        // TODO: OB

                        return [
                            'id' => $item->id,
                            'type' => Str::upper($item->requestType->description),
                            'bandi' => (object) $bandi
                        ];
                    });

        return ( (object) $leaves->first() ) ?? null;
    }

    public function scopeMembershipsParams(){
        $collection = $this->all()->pluck('memberships');
        return $collection->unique()->collapse();
    }

    public function scopeSkillsParams(){
        $collection = $this->all()->pluck('skills');
        return $collection->unique()->collapse();
    }

    public function scopeRecognitionsParams(){
        $collection = $this->all()->pluck('recognitions');
        return $collection->unique()->collapse();
    }

    // generate username
    public function getGenerateUsernameAttribute(){
        return Str::lower(
            preg_replace("/[^ñÑA-Za-z0-9]/", '',
                "{$this->last_name}{$this->employee_number}"
            )
        );
    }

    // generate password
    public function getGeneratePasswordAttribute(){
        return Str::lower(
            preg_replace("/(\W)+/", '',
                "{$this->first_name}{$this->employee_number}"
            )
            
        );
    }

    // name
    public function getNameAttribute(){
        $name = $this->first_name;
        if($this->middle_name != null)
            $name .= " ".$this->middle_name[0]."."; // get the first letter
        $name .= " {$this->last_name} {$this->name_extension}";

        return trim($name, ' ');
    }

    // name
    public function getNameLastNameFirstAttribute(){
        $name = "{$this->last_name}, {$this->first_name}";

        if($this->middle_name != null)
            $name .= " ".$this->middle_name[0]."."; // get the first letter

        if($this->name_extension != null)
            $name .= " {$this->name_extension}";

        return trim($name, ' ');
    }

    // status title
    public function getStatusTitleAttribute(){
        if($this->gender == "MALE"){
            $title = "Mr.";
        }else {
            $title = "Mrs.";
            if($this->civil_status ==  'MARRIED')
                $title = "Ms.";
        }

        return $title;
    }

    public function getUsernameAttribute(){
        return $this->user->username ?? null;
    }

    // group
    public function getGroupAttribute(){
        $isRecordExists = $this->serviceRecords()->exists();
        if(!$isRecordExists)
            return null;

        $serviceRecord = $this->serviceRecords()->orderBy('date_from','DESC')->first();

        return $serviceRecord->group->code;
    }

    // group id
    public function getGroupIdAttribute(){
        $isRecordExists = $this->serviceRecords()->exists();
        if(!$isRecordExists)
            return null;

        $serviceRecord = $this->serviceRecords()->orderBy('date_from','DESC')->first();

        return $serviceRecord->group->id;
    }

    // division
    public function getDivisionAttribute(){
        $isRecordExists = $this->serviceRecords()->exists();
        if(!$isRecordExists)
            return null;

        $serviceRecord = $this->serviceRecords()->orderBy('date_from','DESC')->first();

        return $serviceRecord->assignedTo->name ?? $serviceRecord->divisionOnPrint;
    }

    //date_hired
    public function getDateHiredAttribute()
    {
        return $this->serviceRecords()->where('date_hired',true)->first()->date_from ?? null;
    }

    // date last promotion
    public function getDateLastPromotionAttribute(){
        return $this->serviceRecords()->where('remark_id', 3)->orderBy('date_from', 'DESC')->first()->date_from ?? null;
    }

    // birth_date
    public function getBirthDateAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):null;
    }

    // criminally_charged_date
    public function getCriminallyChargedDateAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):null;
    }

    // issued_date
    public function getIssuedDateAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):null;
    }

    // role
    public function getRoleAttribute(){
        $role = $this->user->roles()->first()->name;
        unset($this->users);
        return $role;
    }

    // permissions
    public function getPermissionsAttribute(){
        $permissions = $this->user->permissions()->select('id', 'name')->get()->map(function($item, $key) {
            unset($item->pivot);
            return $item;
        });

        unset($this->users);

        return $permissions;
    }

    public function getDpUrlAttribute(){
        return $this->getMedia('dp')->first()?->getFullUrl();
    }

    public function getDesignationAttribute()
    {
        return ServiceRecord::getRecord($this->id)->designation ?? null;
    }

    public function getDesignationNameAttribute()
    {
        return ServiceRecord::getRecord($this->id)->positionName ?? null;
    }

    public function getPlaceOfWorkAttribute()
    {
        return ServiceRecord::getRecord($this->id)->place_of_work ?? null;
    }

    public function getLeavesToApproveAttribute(){
        return Approver::where(fn($query) =>
            $query->where('leaves_1', $this->id)
                ->orWhere('leaves_2', $this->id)
                ->orWhere('leaves_3', $this->id)
        )->get()->map(fn($item) => [
            'sequence' => 
                ($item->leaves_1 == $this->id ? 1 : null) ??
                ($item->leaves_2 == $this->id ? 2 : null) ??
                ($item->leaves_3 == $this->id ? 3 : null),
            'employeeId' => $item->employee->id,
        ]);
    }

    public function getObToApproveAttribute(){
        return Approver::where(fn($query) =>
            $query->where('ob_1', $this->id)
                ->orWhere('ob_2', $this->id)
                ->orWhere('ob_3', $this->id)
        )->get()->map(fn($item) => [
            'sequence' => 
                ($item->ob_1 == $this->id ? 1 : null) ??
                ($item->ob_2 == $this->id ? 2 : null) ??
                ($item->ob_3 == $this->id ? 3 : null),
            'employeeId' => $item->employee->id,
        ]);
    }

    public function getOvertimeToApproveAttribute(){
        return Approver::where(fn($query) =>
            $query->where('overtime_1', $this->id)
                ->orWhere('overtime_2', $this->id)
                ->orWhere('overtime_3', $this->id)
        )->get()->map(fn($item) => [
            'sequence' => 
                ($item->overtime_1 == $this->id ? 1 : null) ??
                ($item->overtime_2 == $this->id ? 2 : null) ??
                ($item->overtime_3 == $this->id ? 3 : null),
            'employeeId' => $item->employee->id,
        ]);
    }

    public function getRequestToApproveAttribute(){
        return Approver::where(fn($query) =>
            $query->where('request_1', $this->id)
                ->orWhere('request_2', $this->id)
                ->orWhere('request_3', $this->id)
        )->get()->map(fn($item) => [
            'sequence' => 
                ($item->request_1 == $this->id ? 1 : null) ??
                ($item->request_2 == $this->id ? 2 : null) ??
                ($item->request_3 == $this->id ? 3 : null),
            'employeeId' => $item->employee->id,
        ]);
    }

    public function getHasApproverAttribute(){
        return $this->approver?true:false;
    }

    public function getIsOkToRequestAttribute(){
        return $this->approver?true:false;
    }

    public function getHasApproverListAttribute(){
        return LeaveLedger::whereIn('status',[1,2,3,5])->get()
                ->filter(function($item){
                    return $this->isToApprove($this, $item);
                })->first() ? true : false;
    }
}