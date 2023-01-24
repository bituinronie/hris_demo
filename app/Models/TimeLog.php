<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class TimeLog extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'ref_date',
        'post_date',
        'type',
        'uploaded',
        'name',
    ];

    protected $hidden = [
        'employee_id',
    ];

    protected $casts = [
        'ref_date' => 'datetime:Y-m-d',
        'post_date' => 'datetime:Y-m-d H:i:s',
        'uploaded' => 'boolean',
    ];

    protected static $logName = 'Time Log';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Time Log is $eventName";
    }

    public static function getLastLog($employeeId){
        return TimeLog::where('employee_id', $employeeId)->orderBy('created_at','desc')->first();
    }

}