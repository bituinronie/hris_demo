<?php
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Support\Str;

use App\Models\EmployeeGroup;

use Illuminate\Support\Carbon;
use App\Traits\Scopes\ModelScope;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialDate extends Model
{
    use HasFactory, ModelScope, ModelAttribute, SoftDeletes, LogsActivity, ModelTrait;

    protected $fillable = [
        'reference_date',
        'reference_time',
        'type',
        'description',
        'employee_group_id',
        'is_fixed',
        'is_required',
        'use_description',
    ];

    protected $hidden = [
        'employee_group_id',
    ];

    protected $casts = [
        'reference_date' => 'datetime:Y-m-d',
        'reference_time' => 'datetime:H:i:s',
        'is_fixed' => 'boolean',
        'is_required' => 'boolean',
        'use_description' => 'boolean',
    ];

    protected $appends = ['is_new', 'is_deleted'];

    protected static $logName = 'Special Date';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Special Date is $eventName";
    }

    public function group()
    {
        return $this->belongsTo(EmployeeGroup::class , 'employee_group_id', 'id');
    }

    // scope for getting annual 
    public function scopeInitAnnual($query, $year = null)
    {
        $year = $year ?? date('Y');

        return $query->select('*')
            ->whereYear('reference_date', $year)
            ->orWhere('is_fixed', true);
    }

    public function scopeWithinGroup($query, $groupId)
    {
        return $query->where(function ($query) use ($groupId) {
            return $query->where('employee_group_id', $groupId)->orWhere('employee_group_id', null);
        });
    }

    // getting schedule for schedule for dtr
    public static function getForDtr($refDate, $group)
    {
        $refDate = Carbon::parse($refDate);
        $month = $refDate->copy()->month;
        $day = $refDate->copy()->day;

        // query for special dates
        $specialDates = self::where('reference_date', $refDate)->withinGroup($group)->get()->merge(
            self::whereMonth('reference_date', $month)->whereDay('reference_date', $day)->where('is_fixed', true)->withinGroup($group)->get()
        );

        return $specialDates->mapWithKeys(function ($item) {
            $remark = $item->description;
            if ($item->type === 'SUSPENSION') {
                if (!$item->use_description)
                    $remark = 'SUSPENSION';
            }

            if (!$remark)
                $remark = $item->type;

            return [$item->type => (object)[
                    'time' => $item->reference_time,
                    'remark' => $remark,
                    'is_required' => $item->is_required
                ]];
        });
    }

    // employee group name
    public function getEmployeeGroupNameAttribute()
    {
        $employeeGroup = $this->group;
        if ($employeeGroup == null)
            return null;

        return $employeeGroup->description;
    }

    // employee group
    public function getEmployeeGroupAttribute()
    {
        $employeeGroup = $this->group;
        if ($employeeGroup == null)
            return null;

        return [
            'employee_group_id' => $employeeGroup->id,
            'name' => $employeeGroup->description,
        ];
    }
}