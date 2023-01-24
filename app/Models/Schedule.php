<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\ModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Traits\Scopes\ModelScope;
use App\Traits\Attributes\ModelAttribute;

class Schedule extends Model
{
    use HasFactory, ModelScope, ModelAttribute, SoftDeletes, LogsActivity, ModelTrait;

    protected $fillable = [
        'code',
        'description',
        'mon_time_in',
        'mon_lunch_out',
        'mon_lunch_in',
        'mon_time_out',
        'tue_time_in',
        'tue_lunch_out',
        'tue_lunch_in',
        'tue_time_out',
        'wed_time_in',
        'wed_lunch_out',
        'wed_lunch_in',
        'wed_time_out',
        'thu_time_in',
        'thu_lunch_out',
        'thu_lunch_in',
        'thu_time_out',
        'fri_time_in',
        'fri_lunch_out',
        'fri_lunch_in',
        'fri_time_out',
        'sat_time_in',
        'sat_lunch_out',
        'sat_lunch_in',
        'sat_time_out',
        'sun_time_in',
        'sun_lunch_out',
        'sun_lunch_in',
        'sun_time_out',
        'flexi_from',
        'flexi_to',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'mon_time_in' => 'datetime:H:i:s',
        'mon_lunch_out' => 'datetime:H:i:s',
        'mon_lunch_in' => 'datetime:H:i:s',
        'mon_time_out' => 'datetime:H:i:s',
        'tue_time_in' => 'datetime:H:i:s',
        'tue_lunch_out' => 'datetime:H:i:s',
        'tue_lunch_in' => 'datetime:H:i:s',
        'tue_time_out' => 'datetime:H:i:s',
        'wed_time_in' => 'datetime:H:i:s',
        'wed_lunch_out' => 'datetime:H:i:s',
        'wed_lunch_in' => 'datetime:H:i:s',
        'wed_time_out' => 'datetime:H:i:s',
        'thu_time_in' => 'datetime:H:i:s',
        'thu_lunch_out' => 'datetime:H:i:s',
        'thu_lunch_in' => 'datetime:H:i:s',
        'thu_time_out' => 'datetime:H:i:s',
        'fri_time_in' => 'datetime:H:i:s',
        'fri_lunch_out' => 'datetime:H:i:s',
        'fri_lunch_in' => 'datetime:H:i:s',
        'fri_time_out' => 'datetime:H:i:s',
        'sat_time_in' => 'datetime:H:i:s',
        'sat_lunch_out' => 'datetime:H:i:s',
        'sat_lunch_in' => 'datetime:H:i:s',
        'sat_time_out' => 'datetime:H:i:s',
        'sun_time_in' => 'datetime:H:i:s',
        'sun_lunch_out' => 'datetime:H:i:s',
        'sun_lunch_in' => 'datetime:H:i:s',
        'sun_time_out' => 'datetime:H:i:s',
        'flexi_from' => 'datetime:H:i:s',
        'flexi_to' => 'datetime:H:i:s',
    ];

    protected $appends = ['is_new','is_deleted'];

    protected static $logName = 'Schedule';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Schedule is $eventName";
    }

    public static function findByCode($code){
        return self::where('code', $code)->first();
    }

    public function getInfoAttribute(){
        return $this->makeHidden(['is_new', 'is_deleted', 'created_at', 'updated_at', 'deleted_at', 'id', 'code', 'description'])->toArray();
    }

    public function getIsFlexiAttribute(){
        return $this->flexi_from && $this->flexi_to;
    }
}