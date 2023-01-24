<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class Remark extends Model
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

    protected static $logName = 'Remark';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Remark is $eventName";
    }

}