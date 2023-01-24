<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class Eligibility extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'type',
        'rating',
        'date_conferment',
        'place_conferment',
        'license_number',
        'license_validity',
    ];

    protected $hidden = [
        'employee_id',
    ];

    protected $casts = [
        'date_conferment' => 'datetime:Y-m-d',
        'license_validity' => 'datetime:Y-m-d',
    ];

    protected $appends = ['is_new'];

    protected static $logName = 'Eligibility';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName=='created')
            return 'A Eligibility has been assigned to an employees.';
        if ($eventName=='updated')
            return 'A Eligibility of an employees has been updated.';
        if ($eventName=='deleted')
            return 'A Eligibility has been removed from an employees.';
    }

    // date_conferment
    public function getDateConfermentAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):null;
    }

    // license_validity
    public function getLicenseValidityAttribute($date){
        return $date != null?date('Y-m-d', strtotime($date)):null;
    }

    public function getRatingAttribute($rating){
        return $rating != null?$rating:'N/A';
    }

}