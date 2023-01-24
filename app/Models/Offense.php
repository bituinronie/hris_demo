<?php
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Support\Carbon;

use App\Traits\Scopes\ModelScope;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offense extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'recieved_date',
        'type',
        'offense',
        'corrective_action_taken',
        'status',
        'remarks',
        'memo_date',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'recieved_date' => 'datetime:Y-m-d',
        'memo_date' => 'datetime:Y-m-d'
    ];

    protected $appends = ['is_new', 'receivedDateOnDisplay', 'memoDateOnDisplay'];

    protected static $logName = 'Offense';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName == 'created')
            return 'A Offense has been assigned to an employees.';
        if ($eventName == 'updated')
            return 'A Offense of an employees has been updated.';
        if ($eventName == 'deleted')
            return 'A Offense has been removed from an employees.';
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getReceivedDateAttribute($date)
    {
        return $date != null ? date('Y-m-d', strtotime($date)) : null;
    }

    public function getReceivedDateOnDisplayAttribute()
    {
        return Carbon::parse($this->received_date)->format('F d, Y');
    }

    public function getMemoDateAttribute($date)
    {
        return $date != null ? date('Y-m-d', strtotime($date)) : null;
    }

    public function getMemoDateOnDisplayAttribute()
    {
        return Carbon::parse($this->memo_date)->format('F d, Y');
    }
}