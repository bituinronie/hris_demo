<?php
namespace App\Models;

use App\Casts\AsObject;

use App\Traits\ModelTrait;
use App\Traits\Scopes\ModelScope;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeSchedule extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'schedule_type',
        'schedule_id',
        'special_schedule_id',
        'effective_date',
    ];

    protected $hidden = [
        'employee_id',
        'schedule_id',
        'special_schedule_id',
    ];

    protected $casts = [
        'effective_date' => 'datetime:Y-m-d',
        'special_schedule' => AsObject::class ,
    ];

    protected static $logName = 'Employee Schedule';

    public function getDescriptionForEvent(string $eventName)
    {
        if ($eventName == 'created')
            return 'A Employee Schedule has been assigned to an employees.';
        if ($eventName == 'updated')
            return 'A Employee Schedule of an employees has been updated.';
        if ($eventName == 'deleted')
            return 'A Employee Schedule has been removed from an employees.';
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class , 'schedule_id', 'id');
    }

    public function specialScheduleModel()
    {
        return $this->belongsTo(SpecialSchedule::class , 'special_schedule_id', 'id');
    }

    // 'special_schedule'
    public function getSpecialScheduleAttribute()
    {
        return $this->specialScheduleModel->template;
    }

    public function getCodeAttribute()
    {
        return $this->schedule_type == 'REGULAR' ? $this->schedule->code : $this->specialScheduleModel->code;
    }

    public function getDescriptionAttribute()
    {
        return $this->schedule_type == 'REGULAR' ? $this->schedule->description : $this->specialScheduleModel->description;
    }

}