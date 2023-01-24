<?php
namespace App\Models;

use App\Models\Employee;
use App\Traits\ModelTrait;

use App\Traits\Scopes\ModelScope;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;

use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeGroup extends Model
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

    protected $appends = ['is_new'];

    protected static $logName = 'Employee Group';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Employee Group is $eventName";
    }

    public function serviceRecords()
    {
        return $this->hasMany(ServiceRecord::class);
    }

    public static function findByCode($code){
        return self::where('code', $code)->first();
    }
}