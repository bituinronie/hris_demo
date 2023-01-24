<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class Volunteering extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'organization',
        'date_from',
        'date_to',
        'number_of_hours',
        'position',
        'nature_of_work',
    ];

    protected $hidden = [
        'employee_id',
    ];

    protected $casts = [
        'date_from' => 'datetime:Y-m-d',
        'date_to' => 'datetime:Y-m-d',
    ];

    protected $appends = ['is_new'];

    protected static $logName = 'Volunteering';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName=='created')
            return 'A Volunteering has been assigned to an employees.';
        if ($eventName=='updated')
            return 'A Volunteering of an employees has been updated.';
        if ($eventName=='deleted')
            return 'A Volunteering has been removed from an employees.';
    }

}