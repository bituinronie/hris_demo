<?php
namespace App\Models;

use App\Casts\AsObject;
use App\Traits\ModelTrait;

use App\Traits\Scopes\ModelScope;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;

use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialSchedule extends Model
{
    use HasFactory, ModelScope, ModelAttribute, SoftDeletes, LogsActivity, ModelTrait;

    protected $fillable = [
        'code',
        'description',
        'ref_date',
        'template',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'ref_date' => 'datetime:Y-m-d',
        'template' => AsObject::class,
    ];

    protected static $logName = 'Special Schedule';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Special Schedule is $eventName";
    }

}