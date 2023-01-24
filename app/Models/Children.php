<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class Children extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'name',
        'birth_date',
    ];

    protected $hidden = [
        'employee_id'
    ];

    protected $casts = [
        'birth_date' => 'datetime:Y-m-d'
    ];

    protected $appends = ['is_new'];

    protected static $logName = 'Children';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName=='created')
            return 'A Children has been assigned to an employees.';
        if ($eventName=='updated')
            return 'A Children of an employees has been updated.';
        if ($eventName=='deleted')
            return 'A Children has been removed from an employees.';
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    // birth_date
    public function getBirthDateAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):null;
    }
}