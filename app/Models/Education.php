<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class Education extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'level',
        'school_name',
        'course',
        'attended_from',
        'attended_to',
        'graduated',
        'highest_level',
        'year_graduated',
        'honors',
    ];

    protected $hidden = [
        'employee_id',
    ];

    protected $casts = [
        'graduated' => 'boolean',
    ];

    protected $appends = ['is_new'];

    protected static $logName = 'Education';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName=='created')
            return 'A Education has been assigned to an employees.';
        if ($eventName=='updated')
            return 'A Education of an employees has been updated.';
        if ($eventName=='deleted')
            return 'A Education has been removed from an employees.';
    }

}