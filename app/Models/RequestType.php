<?php
namespace App\Models;

use App\Traits\ModelTrait;
use App\Traits\ConstantTrait;

use Illuminate\Support\Carbon;
use App\Traits\Scopes\ModelScope;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestType extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait, ConstantTrait;

    protected $fillable = [
        'code',
        'description',
        'filing_period_type',
        'filing_period_month',
        'filing_period_days',
        'request_limit_min',
        'request_limit_max',
        'category',
        'based_on',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'filing_period_month' => 'array',
    ];

    protected $appends = ["isNew", "hasBasedOn"];

    protected static $logName = 'Request Type';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Request Type is $eventName";
    }

    public function getHasBasedOnAttribute()
    {
        return !in_array($this->id, $this->noBasedOnRequestType);
    }

    /**
     * 
     * @param Carbon dateToCheck
     * 
     * @return String|NULL
     */
    public function isFilingAllowed($dateToCheck)
    {
        $dateToday = Carbon::parse(date('Y-m-d'));
        $dateToCheck = Carbon::parse($dateToCheck->format('Y-m-d'));

        $messagePrefix = 'Request failed:';

        // conditioning `filing_period_type`
        switch ($this->filing_period_type) {
            case 'BEFORE':
                $beforeDate = $dateToCheck->copy()->subDays($this->filing_period_days);

                if ($beforeDate < $dateToday)
                    $return = "{$messagePrefix} you must file your request atleast {$this->filing_period_days} days before.";

                break;
            case 'EITHER':
                $beforeDate = $dateToCheck->copy()->subDays($this->filing_period_days);
                $afterDate = $dateToCheck->copy()->addDays($this->filing_period_days);

                if ($beforeDate > $dateToday && $afterDate < $dateToday)
                    $return = "{$messagePrefix} you must file your request atleast {$this->filing_period_days} days before or after.";

                break;
            case 'AFTER':
                $afterDate = $dateToCheck->copy()->addDays($this->filing_period_days);

                if ($afterDate > $dateToday)
                    $return = "{$messagePrefix} you must file your request atleast {$this->filing_period_days} days after.";

                break;
            case 'MONTH':
                $month = $this->filing_period_month;

                $monthApplied = Str::upper($dateToday->format('F'));

                if (!in_array($monthApplied, $month)) {
                    $monthStr = implode(',', $month);
                    $return = "{$messagePrefix} you must file your request on the following month: $monthStr";
                }

                break;
            case 'FROM_TO':
                // TODO
                break;
        }

        return $return ?? null; // NULL => isAllowed
    }



}