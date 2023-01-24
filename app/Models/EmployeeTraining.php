<?php
namespace App\Models;

use App\Models\Training;
use App\Traits\ModelTrait;

use Illuminate\Support\Carbon;
use App\Traits\Scopes\ModelScope;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeTraining extends Model implements HasMedia
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait, InteractsWithMedia;

    protected $fillable = [
        'employee_id',
        'training_id',
        'date_from',
        'date_to',
        'number_of_hours',
        'show_pds',
    ];

    protected $hidden = [
        'employee_id',
        'training_id',
    ];

    protected $casts = [
        'date_from' => 'datetime:Y-m-d',
        'date_to' => 'datetime:Y-m-d',
        'number_of_hours' => 'integer',
        'show_pds' => 'boolean',
    ];

    protected static $logName = 'Employee Training';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName=='created')
            return 'A Employee Training has been assigned to an employees.';
        if ($eventName=='updated')
            return 'A Employee Training of an employees has been updated.';
        if ($eventName=='deleted')
            return 'A Employee Training has been removed from an employees.';
    }

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // date_from
    public function getDateFromAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):null;
    }

    // date_to
    public function getDateToAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):null;
    }

    public function getEmployeeRecordAttribute()
    {
        $training = $this->training;

        $location = null;
        if($training->is_foreign !== null)
            $location = $training->is_foreign?'FOREIGN':'LOCAL';

        return [
            'id' => $this->id,
            'program' => $training->program,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'number_of_hours' => $this->number_of_hours,
            'type_of_ld' => $training->type_of_ld,
            'sponsored_by' => $training->sponsored_by,
            'conducted_by' => $training->conducted_by,
            'location' => $location,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'show_pds' => $this->show_pds,
            'isNew' => $this->is_new
        ];
    }

    public function getDateToDisplayAttribute(){
        if($this->date_from == $this->date_to)
            return Carbon::parse($this->date_from)->format('F d, Y');

        return Carbon::parse($this->date_from)->format('F d, Y')." to ".Carbon::parse($this->date_to)->format('F d, Y');
    }

    public function scopeWhereDates($query, $dateFrom, $dateTo, $numberOfHours){
        return $query->where('date_from', $dateFrom)->where('date_to', $dateTo)->where('number_of_hours', $numberOfHours);
    }

    public function scopeGroupByDates($query){
        return $query->groupBy('date_from','date_to','number_of_hours');
    }

    public function getEmployeesAssignedCountAttribute(){
        return EmployeeTraining::where('training_id', $this->training_id)->where('employee_id','!=',null)->whereDates($this->date_from, $this->date_to, $this->number_of_hours)->get()->count();
    }

    public function getCertificateOfAppearanceUrlAttribute(){
        return $this->getMedia('certificate')->first()?->getFullUrl();
    }

    public function getPostTrainingReportUrlAttribute(){
        return $this->getMedia('postTraining')->first()?->getFullUrl();
    }

    public function getIsAllowedOnPdsAttribute(){
        if ($this->show_pds)
            return true;

        if ($this->certificateOfAppearanceUrl)
            return true;

        return false;
    }

    public function getIsOkToDeleteAttribute(){
        return $this->employeesAssignedCount <= 0;
    }

    public function getRecordedEmployeesCountAttribute(){
        return EmployeeTraining::where('training_id', $this->training_id)->where('employee_id','!=',null)->whereDates($this->date_from, $this->date_to, $this->number_of_hours)->get()->filter(fn($item) => $item->isAllowedOnPds)->count();
    }
}