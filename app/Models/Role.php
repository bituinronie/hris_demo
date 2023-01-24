<?php

namespace App\Models;

use App\Traits\ModelTrait;
use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRole
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected static $logName = 'Role';

    protected $appends = ['is_new', 'permissions'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Role is $eventName";
    }

    public function getPermissionsAttribute(){
        return $this->permissions()->pluck('name');
    }
}
