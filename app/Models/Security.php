<?php
namespace App\Models;

use App\Casts\Blob;
use App\Traits\ModelTrait;

use App\Traits\Scopes\ModelScope;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Security extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'employee_id',
        'rfid',
        'template1',
        'template1_number',
        'template2',
        'template2_number',
        'finger_mask',
        'face_template',
        'kiosk_name'
    ];

    protected $hidden = [
        'employee_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        // 'template1' => Blob::class,
        // 'template2' => Blob::class,
        // 'face_template' => Blob::class,
        'kiosk_name' => 'array'
    ];

    protected static $logName = 'Security';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName=='created')
            return 'A Security has been assigned to an employees.';
        if ($eventName=='updated')
            return 'A Security of an employees has been updated.';
    }

    public function getRfidAttribute($rfid){
        return $rfid == null ? '' : $rfid;
    }

    public function getTemplate1NumberAttribute($template1Number){
        return is_null($template1Number) ? -1 : $template1Number;
    }

    public function getTemplate2NumberAttribute($template2Number){
        return is_null($template2Number) ? -1 : $template2Number;
    }

    public function getFingerMaskAttribute($fingerMask){
        return is_null($fingerMask) ? -1 : $fingerMask;
    }

}