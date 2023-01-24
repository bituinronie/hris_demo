<?php
namespace App\Traits\Attributes;

use App\Models\Employee;
use App\Traits\DtrTrait;
use App\Models\SpecialDate;
use Illuminate\Support\Str;
use App\Classes\DtrStatistic;
use App\Traits\ConstantTrait;
use Illuminate\Support\Carbon;

/**
 * Dtr Attribute Trait
 * 
 * TODO: Suspension
 * TODO: OT on Suspension
 * TODO: Overnight Schedule having Special Dates
 */
trait DtrAttribute
{
    use ConstantTrait, DtrTrait;

    public function getParseDtrAttribute()
    {
        //* init returnData
        $returnData = collect();

        //* init refdate
        $refDate = $this->ref_date->format('Y-m-d');

        //* init Schedules
        $schedule = Employee::getScheduleByDate($this->employee_id, $refDate, true); // true => to strictly check sched
        $hasLunch = Employee::getScheduleByDate($this->employee_id, $refDate)->hasLunch ?? true; // default value true

        $scheduleWorkMinutes = (int) $schedule?->workMinutes;

        //* init Statistics
        $stats = new DtrStatistic($scheduleWorkMinutes);

        //* init Special Dates
        $specialDates = SpecialDate::getForDtr($this->ref_date, $this->employee->groupId);

       //* date on display
        $returnData->put('date', $this->dateOnDisplay);

        //* put bandis
        $returnData->put('am_in', $this->time_in?->copy()?->format('h:i'));
        $returnData->put('am_out', $this->lunch_out?->copy()?->format('h:i'));
        $returnData->put('pm_in', $this->lunch_in?->copy()?->format('h:i'));
        $returnData->put('pm_out', $this->time_out?->copy()?->format('h:i'));

        //* init is to compute Dtr
        $isToComputeDtr = (Carbon::parse($refDate)->timestamp) < (Carbon::parse( date('Y-m-d') )->timestamp);

        if($isToComputeDtr) {
            //* Special dates boolean
            $isHoliday = $specialDates->has('LEGAL') || $specialDates->has('SPECIAL');
            $isFlagCeremony = $specialDates->has('FLAG_CEREMONY');

            //* boolean: applicable for regular schedule
            $isRegularComputation = ($schedule != null || $isFlagCeremony) && !$isHoliday; 

            //* Filter functions
            $filterLunch = function ($value, $key) use($hasLunch, $isRegularComputation) {
                if(!$hasLunch && $isRegularComputation){ // removing lunch in and out
                    if ($key === 'lunch_out' || $key === 'lunch_in')
                        return false;
                }

                return true;
            };

            //* INIT TEMPLATE
            $template = (object) collect($this->timeKeepingTypes)->mapWithKeys(function($type) use ($schedule) {
                return [$type => $this->generateTemplate($type, $schedule)];
            })->filter($filterLunch)->toArray();

            //* Leave Application Part
            $leave = Employee::getLeavesByDate($this->employee_id, $refDate, $template);
            if((array)$leave) // add leaves on stats
                $stats->addLeave($leave->type, $leave->id);

            //* BANDI functions
            $generateBandi = function ($type) use ($isRegularComputation, $leave) {
                $bandi = $this->{$type};

                if ((array)$leave)
                    $bandi = $leave->bandi->{$type};

                if ($bandi === null)
                    return null;

                $toParse = $bandi->copy()->format('Y-m-d H:i');

                return Carbon::parse($toParse);
            };

            $bandiCollection = collect($this->timeKeepingTypes)->mapWithKeys(function($type) use ($generateBandi) {
                return [$type => $generateBandi($type)];
            })->filter($filterLunch);

            $bandi = (object) $bandiCollection->toArray();

            $bandiStats = (object) [
                'count' => $bandiCollection->filter()->count(),
                'no_entry' => $bandiCollection->map(fn($item, $key) =>  $item === null?$key:null )->filter()->flatten()->toArray(),
            ];

            //* DTR Computation
            // TODO: $specialDates->has('SUSPENSION')
            if($isRegularComputation) {
                //* Flexi Application
                if($schedule->isFlexi) {
                    $timeInToUse = $bandi?->time_in?->copy();

                    if ($timeInToUse) {
                        // update flexi from and flexi to
                        $flexiFrom = $schedule->flexi_from->copy();
                        $flexiTo = $schedule->flexi_to->copy();

                        $refDate = $this->ref_date->copy();

                        $flexiFromToParse = $refDate->copy()->format('Y-m-d')." ".$flexiFrom->copy()->format('H:i');

                        // overnight checking
                        if ($flexiTo->timestamp < $flexiFrom->timestamp)
                            $refDate = $refDate->addDay();

                        $flexiToToParse = $refDate->format('Y-m-d')." ".$flexiTo->format('H:i');

                        // flexi to use
                        $flexiFrom = Carbon::parse($flexiFromToParse);
                        $flexiTo = Carbon::parse($flexiToToParse);

                        // Flexi Application
                        $diffTimeInFlexiFrom = $timeInToUse->copy()->diffInMinutes($flexiFrom, false);
                        $isPartOfFlexi = false;
                        if ($diffTimeInFlexiFrom > 0) { // earlier than flexi from schedule
                            $timeInToUse = $flexiFrom->copy();
                            $diffTimeInFlexiFrom = 0;
                            $isPartOfFlexi = true;
                        }else { // after the flexi from schedule
                            $isPartOfFlexi = $timeInToUse->copy()->between($flexiFrom, $flexiTo);
                            if (!$isPartOfFlexi) {
                                $timeInToUse = $flexiTo->copy();
                                $diffTimeInFlexiFrom = 0;
                            }
                        }

                        $template->time_in = $timeInToUse;
                        $template->time_out = $flexiFrom->copy()->addMinutes(abs($diffTimeInFlexiFrom)+$schedule->workMinutes+$schedule->lunchMinutes);
                    }
                }

                //* Flag Ceremony Application
                if($isFlagCeremony) {
                    $flagCeremony = $specialDates->get('FLAG_CEREMONY');
                    $stats->addRemark('FLAG CEREMONY');

                    $refDate = $this->ref_date->copy();
                    $toParse = "{$refDate->format('Y-m-d')} {$flagCeremony->time->format('H:i')}";

                    $template->fc_in = Carbon::parse($toParse);
                }

                //* PRE-defined function for diff breakdown
                $invokeHalfDay = function ($on, $to) use ($template, $stats, $hasLunch) {
                    $on = "{$on}_in";
                    $to = "{$to}_out";

                    $halfDayDiff = $template->{ $on}->copy()->diffInMinutes($template->{ $to}, false);

                    if (!$hasLunch) {
                        $halfDayDiff = $halfDayDiff / 2;
                    }else {
                        if ($on === 'time_in' && $to === 'time_out') {
                            $halfDayDiff = ($halfDayDiff - $template->lunch_out->copy()->diffInMinutes($template->lunch_in))/2;
                        }
                    }

                    $stats->addRemark('HALF DAY');
                    $stats->addDiff($halfDayDiff);
                };

                // $for => array|string
                $getBandiDiffFor = function($for, $remark = null) use ($bandi, $template, $stats, $isFlagCeremony, $invokeHalfDay) {

                    $applyDiff = function($for) use ($remark, $bandi, $template, $stats, $isFlagCeremony, $invokeHalfDay) {

                        if($remark === null) {
                            $remark = match($for) {
                                'time_in','lunch_in' => 'LATE',
                                'lunch_out','time_out' => 'UT',
                                default => null
                            };
        
                            if ($remark === null)
                                abort(500, 'get bandi for error found.');
                        }
        
                        if($isFlagCeremony && $for == 'time_in') {
                            $diff = $bandi->{$for}->copy()->diffInMinutes($template->fc_in, false);
                        }else {
                            $diff = match($for) {
                                'time_in','lunch_in' => $bandi->{$for}->copy()->diffInMinutes($template->{$for}, false),
                                'lunch_out','time_out' => $template->{$for}->copy()->diffInMinutes($bandi->{$for}, false),
                                default => 0
                            };
                        }

                        if ($diff < 0) {
                            if($isFlagCeremony && $for === 'time_in') {
                                $invokeHalfDay('time', 'time'); // HALFDAY
                            }else {
                                $stats->addRemark($remark);
                                $stats->addDiff($diff, $remark);
                            }
                        }
                    };

                    $forType = gettype($for);

                    if ($forType === 'string') {
                        $applyDiff($for);
                    }else {
                        foreach ($for as $item) {
                            $applyDiff($item);
                        }
                    }
                };

                //* ========================== LOGIC ==========================
                if($this->hasBandi || (array)$leave) {
                    if($hasLunch) {
                        switch ($bandiStats->count) {
                            case 4:
                                $getBandiDiffFor(['time_in','lunch_out','lunch_in','time_out']);
                                break;
                            case 3:
                                switch ($bandiStats->no_entry[0]) { //* check the no entry bandi
                                    case 'time_in': // 0 | 1 | 1 | 1
                                        $invokeHalfDay('time', 'lunch'); // AM HALFDAY
                                        $getBandiDiffFor(['lunch_out','lunch_in','time_out']);
                                        break;
                                    case 'lunch_out': // 1 | 0 | 1 | 1
                                        $invokeHalfDay('time','time'); // HALFDAY
                                        $getBandiDiffFor(['time_in','lunch_in','time_out']);
                                        break;
                                    case 'lunch_in': // 1 | 1 | 0 | 1
                                        $invokeHalfDay('time','time'); // HALFDAY
                                        $getBandiDiffFor(['time_in','lunch_out','time_out']);
                                        break;
                                    case 'time_out': // 1 | 1 | 1 | 0
                                        $invokeHalfDay('lunch','time'); // PM HALFDAY
                                        $getBandiDiffFor(['time_in','lunch_out','lunch_in']);
                                        break;
                                }

                                break;
                            case 2:
                                $firstNoEntry = $bandiStats->no_entry[0];
                                $secondNoEntry = $bandiStats->no_entry[1];

                                if($firstNoEntry === 'time_in' && $secondNoEntry === 'time_out') { // 0 | 1 | 1 | 0
                                    $stats->addRemark('ABSENT');
                                }else if($firstNoEntry === 'time_in' && $secondNoEntry === 'lunch_in') { // 0 | 1 | 0 | 1
                                    $invokeHalfDay('time','time'); // Whole Day HALFDAY
                                    $getBandiDiffFor(['lunch_out','time_out']);
                                }else if($firstNoEntry === 'time_in' && $secondNoEntry === 'lunch_out') { // 0 | 0 | 1 | 1
                                    $invokeHalfDay('time','lunch'); // AM HALFDAY
                                    $getBandiDiffFor(['lunch_in','time_out']);
                                }else if($firstNoEntry === 'lunch_in' && $secondNoEntry === 'time_out') { // 1 | 1 | 0 | 0
                                    $invokeHalfDay('lunch','time'); // PM HALFDAY
                                    $getBandiDiffFor(['time_in','lunch_out']);
                                }else if($firstNoEntry === 'lunch_out' && $secondNoEntry === 'time_out') { // 1 | 0 | 1 | 0
                                    $invokeHalfDay('time','time'); // Whole Day HALFDAY
                                    $getBandiDiffFor(['time_in','lunch_in']);
                                }else if($firstNoEntry === 'lunch_out' && $secondNoEntry === 'lunch_in') { // 1 | 0 | 0 | 1
                                    $invokeHalfDay('time','time'); // Whole Day HALFDAY
                                    $getBandiDiffFor(['time_in','time_out']);
                                }
                                break;
                            case 1:
                                $stats->addRemark('ABSENT');
                                break;
                            
                        }
                    }else {
                        switch ($bandiStats->count) {
                            case 2:
                                $getBandiDiffFor('time_in');
                                $getBandiDiffFor('time_out');
                                break;
                            case 1:
                                $invokeHalfDay('time','time');
                                $noEntry = $bandiStats->no_entry[0];

                                if($noEntry == 'time_out')
                                    $getBandiDiffFor('time_in');
                                else if($noEntry === 'time_in')
                                    $getBandiDiffFor('time_out');
                        }
                    }

                    // OT
                    if($stats->diff == 0 && !$stats->isAbsent && !$stats->isHalfDay) {
                        // Add 2hrs on out to check OT on scheduled dtr's
                        $otTimeOut = $template->time_out->copy()->addHours($this->minimumOtOnSchedule);

                        $otHours = $otTimeOut->diffInHours($bandi->time_out, false);
                        if($otHours >= 0) {
                            $otMinutes = ($otHours + $this->minimumOtOnSchedule) * 60;
                            $stats->addOt($otMinutes);
                        }
                    }

                }else {
                    $stats->addRemark('ABSENT');
                }

            }else {

                if($isHoliday) {
                    if($specialDates->has('LEGAL')){
                        $holiday = $specialDates->get('LEGAL');
                        $stats->addRemark($holiday->remark);
                    }

                    if($specialDates->has('SPECIAL')) {
                        $holiday = $specialDates->get('SPECIAL');
                        $stats->addRemark($holiday->remark);
                    }
                }
                
                if(!$schedule)
                    $stats->addRemark('DAY OFF');

                // OT for non scheduled bandi
                if($this->hasBandi) {
                    // init otMinutes
                    $otMinutes = 0;

                    //* OT Breakdown
                    switch ($bandiStats->count) {
                        case 4:
                            $am = $bandi->time_in->diffInMinutes($bandi->lunch_out);
                            $pm = $bandi->lunch_in->diffInMinutes($bandi->time_out);

                            $otMinutes = $am + $pm;
                            break;
                        case 3:
                            switch ($bandiStats->no_entry[0]) { //* check the no entry bandi
                                case 'time_in': // 0 | 1 | 1 | 1
                                case 'lunch_out': // 1 | 0 | 1 | 1
                                    $otMinutes = $bandi->lunch_in->diffInMinutes($bandi->time_out);
                                    break;
                                case 'lunch_in': // 1 | 1 | 0 | 1
                                case 'time_out': // 1 | 1 | 1 | 0
                                    $otMinutes = $bandi->time_in->diffInMinutes($bandi->lunch_out);
                                    break;
                            }
                            break;
                        case 2:
                            $acceptedEntries = collect($this->timeKeepingTypes)->filter(function($item) use ($bandiStats) { return !in_array($item, $bandiStats->no_entry); })->values()->toArray();

                            $otMinutes = $bandi->{ $acceptedEntries[0]}->diffInMinutes($bandi->{ $acceptedEntries[1]});


                            // if($firstNoEntry == 'lunch_out' && $secondNoEntry == 'lunch_in') { // 1 | 0 | 0 | 1
                            //     $otMinutes = $bandi->time_in->diffInMinutes($bandi->time_out);
                            // }else if($firstNoEntry == 'lunch_in' && $secondNoEntry == 'time_out') { // 1 | 1 | 0 | 0
                            //     $otMinutes = $bandi->time_in->diffInMinutes($bandi->lunch_out);
                            // }else if($firstNoEntry == 'time_in' && $secondNoEntry == 'lunch_out') { // 0 | 0 | 1 | 1
                            //     $otMinutes = $bandi->lunch_in->diffInMinutes($bandi->time_out);
                            // }else if($firstNoEntry == 'lunch_in' && $secondNoEntry == 'time_out') { // 1 | 0 | 1 | 0
                            //     $otMinutes = $bandi->lunch_in->diffInMinutes($bandi->lunch_in);
                            // }
                            break;
                    }

                    if($otMinutes >= $this->minimumOtOnOff) // Constant trait
                        $stats->addOt($otMinutes);
                }
            }
        } // end of if before date today

        $returnData->put('diff', $stats->diffToReadable());
        $returnData->put('ot', $stats->otToReadable());

        if($this->showStats)
            $returnData->put('stats', $stats->get());

        $returnData->put('remark', $stats->get()->remark);

        return $returnData;
    }

    public function getDateOnDisplayAttribute(){
        //* {numericDay} {firstTwoDay}}
        $numericDay = $this->ref_date->format('d');
        $firstTwoDay = Str::upper(substr($this->ref_date->format('D'),0,2));
 
         $date = "{$numericDay} {$firstTwoDay}";

         return $date;
    }

    public function getHasBandiAttribute(){
        return $this->time_in || $this->lunch_out || $this->lunch_in || $this->time_out;
    }
}
