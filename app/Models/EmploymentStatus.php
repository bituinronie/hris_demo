<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class EmploymentStatus extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'code',
        'description',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = ['is_new'];

    protected static $logName = 'Employment Status';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Employment Status is $eventName";
    }

}