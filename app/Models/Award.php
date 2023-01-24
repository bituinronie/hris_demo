<?php
namespace App\Models;

use Carbon\Carbon;
use App\Traits\ModelTrait;

use App\Traits\Scopes\ModelScope;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Award extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'date_awarded',
        'type',
        'activity',
        'remarks',
    ];

    protected $hidden = [
        'employee_id',
    ];

    protected $casts = [
        'date_awarded' => 'datetime:Y-m-d'
    ];

    protected $appends = ['is_new', 'dateAwardedOnDisplay'];

    protected static $logName = 'Award';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName == 'created')
            return 'A Award has been assigned to an employees.';
        if ($eventName == 'updated')
            return 'A Award of an employees has been updated.';
        if ($eventName == 'deleted')
            return 'A Award has been removed from an employees.';
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getDateAwardedAttribute($date)
    {
        return $date != null ? date('Y-m-d', strtotime($date)) : null;
    }

    public function getDateAwardedOnDisplayAttribute()
    {
        return Carbon::parse($this->date_awarded)->format('F d, Y');
    }

}