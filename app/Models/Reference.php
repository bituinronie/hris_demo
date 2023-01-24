<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class Reference extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'name',
        'address',
        'telephone',
    ];

    protected $hidden = [
        'employee_id',
    ];

    protected $casts = [
    ];

    protected $appends = ['is_new'];

    protected static $logName = 'Reference';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName=='created')
            return 'A Reference has been assigned to an employees.';
        if ($eventName=='updated')
            return 'A Reference of an employees has been updated.';
        if ($eventName=='deleted')
            return 'A Reference has been removed from an employees.';
    }

}