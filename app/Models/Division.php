<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class Division extends Model
{
    use HasFactory, ModelScope, ModelAttribute, SoftDeletes, LogsActivity, ModelTrait;

    protected $fillable = [
        'code',
        'name',
        'description',
        'office_group',
    ];

    protected $hidden = [
        'office_group',
        'officeGroup'
    ];

    protected $casts = [
    ];

    protected $appends = ['is_new','officeGroupData','is_deleted'];

    protected static $logName = 'Division';

    public function officeGroup()
    {
        return $this->belongsTo(Division::class, 'office_group', 'id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Division is $eventName";
    }

    public function getOfficeGroupDataAttribute()
    {
        $officeGroup = $this->officeGroup;
        if ($officeGroup === null)
            return null;

        return [
            'office_group' => $officeGroup->id,
            'code' => $officeGroup->code,
            'name' => $officeGroup->name
        ];
    }

}