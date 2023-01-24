<?php

namespace App\Models;

use App\Traits\ModelTrait;
use App\Casts\SettingValue;

use App\Traits\Scopes\ModelScope;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'value'
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'value' => SettingValue::class
    ];

    protected static $logName = 'Setting';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Setting is $eventName";
    }

    // scopes
    public function scopeFindByKey($query, $key){
        return $query->where('key', $key)->first();
    }

    public function scopeGetValueByKey($query, $key){
        return $query->where('key', $key)->first()->value ?? null;
    }

    public function scopeIsUpdateEmployee($query){
        $setting = $query->where('key', 'UPDATE_EMPLOYEE')->first()->value ?? null;
        if($setting == null)
            return false;

        if($setting['from'] == null || $setting['to'] == null)
            return false;

        $dateToday = date('Y-m-d');
        return strtotime($setting['from']) <= strtotime($dateToday) && strtotime($setting['to']) >= strtotime($dateToday);
    }

    public function scopeFlexiSetting($query)
    {
        $setting = $query->where('key', 'FLEXI')->first()->value ?? null;

        return [
            'from' => $setting['from'] ?? null,
            'to' => $setting['to'] ?? null
        ];
    }

    public function scopeReportSettings($query)
    {
        return (object) [
            'address' => $this->getValueByKey('REPORT_ADDRESS'),
            'contact_number' => $this->getValueByKey('REPORT_CONTACT_NUMBER')
        ];
    }

    public static function activeTranche(){
        return (integer) self::where('key','ACTIVE_TRANCHE')->first()->value;
    }

    public static function annualMandatoryLeave(){
        return (integer) self::where('key','ANNUAL_MANDATORY_LEAVE')->first()->value;
    }

    public static function annualSpecialLeave(){
        return (integer) self::where('key','ANNUAL_SPECIAL_LEAVE')->first()->value;
    }
}
