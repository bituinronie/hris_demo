<?php
namespace App\Traits;

use Illuminate\Support\Carbon;

/**
 * DtrTrait
 */
trait DtrTrait
{
    public function generateTemplate($type, $schedule, $refDate = null)
    {
        $timeIn = $schedule?->time_in?->copy()?->timestamp;
        $schedToUse = $schedule?->{$type}?->copy();

        if ($schedToUse === null)
            return null;

        if ($refDate == null)
            $refDate = $this->ref_date->copy();
        else
            $refDate = Carbon::parse($refDate);

        // overnight checking
        if ($schedToUse->timestamp < $timeIn)
            $refDate = $refDate->addDay();

        $refDate = $refDate->format('Y-m-d');

        $toParse = "$refDate {$schedToUse->format('H:i')}";

        return Carbon::parse($toParse);
    }
}
