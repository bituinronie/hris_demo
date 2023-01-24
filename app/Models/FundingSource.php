<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class FundingSource extends Model
{
    use HasFactory, ModelScope, ModelAttribute, SoftDeletes, LogsActivity, ModelTrait;

    protected $fillable = [
        'code',
        'description',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $appends = ['is_new','is_deleted'];

    protected static $logName = 'Funding Source';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Funding Source is $eventName";
    }

}