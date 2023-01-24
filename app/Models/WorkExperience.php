<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class WorkExperience extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'position',
        'date_from',
        'date_to',
        'company',
        'salary',
        'pay_grade',
        'status_of_appointment',
        'sector',
        'is_government_service',
    ];

    protected $hidden = [
        'employee_id',
    ];

    protected $casts = [
        'date_from' => 'datetime:Y-m-d',
        // 'date_to' => 'datetime:Y-m-d',
        'salary' => 'float',
        'is_government_service' => 'boolean',
    ];

    protected $appends = ['is_new'];

    protected static $logName = 'Work Experience';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName=='created')
            return 'A Work Experience has been assigned to an employees.';
        if ($eventName=='updated')
            return 'A Work Experience of an employees has been updated.';
        if ($eventName=='deleted')
            return 'A Work Experience has been removed from an employees.';
    }

    // date_from
    public function getDateFromAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):null;
    }

    // date_to
    public function getDateToAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):"Present";
    }

    // salary
    public function getSalaryAttribute($salary){
        return $salary != null?number_format($salary,2,".",","):null;
    }

}