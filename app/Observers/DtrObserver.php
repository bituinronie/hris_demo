<?php

namespace App\Observers;

use App\Models\Dtr;
use App\Models\TimeLog;

class DtrObserver
{
    /**
     * Handle the Dtr "created" event.
     *
     * @param  \App\Models\Dtr  $dtr
     * @return void
     */
    public function created(Dtr $dtr)
    {
        //
    }

    /**
     * Handle the Dtr "updated" event.
     *
     * @param  \App\Models\Dtr  $dtr
     * @return void
     */
    public function updated(Dtr $dtr)
    {
        if($dtr->isDirty('time_in')){
            TimeLog::create([
                'employee_id' => $dtr->employee_id,
                'ref_date' => $dtr->ref_date,
                'post_date' => $dtr->time_in,
                'type' => 'TIME_IN',
                'name' => auth()->user()->username ?? 'seeder'
            ]);
        }
        if($dtr->isDirty('lunch_out')){
            TimeLog::create([
                'employee_id' => $dtr->employee_id,
                'ref_date' => $dtr->ref_date,
                'post_date' => $dtr->lunch_out,
                'type' => 'LUNCH_OUT',
                'name' => auth()->user()->username ?? 'seeder'
            ]);
        }
        if($dtr->isDirty('lunch_in')){
            TimeLog::create([
                'employee_id' => $dtr->employee_id,
                'ref_date' => $dtr->ref_date,
                'post_date' => $dtr->lunch_in,
                'type' => 'LUNCH_IN',
                'name' => auth()->user()->username ?? 'seeder'
            ]);
        }
        if($dtr->isDirty('time_out')){
            TimeLog::create([
                'employee_id' => $dtr->employee_id,
                'ref_date' => $dtr->ref_date,
                'post_date' => $dtr->time_out,
                'type' => 'TIME_OUT',
                'name' => auth()->user()->username ?? 'seeder'
            ]);
        }
    }

    /**
     * Handle the Dtr "deleted" event.
     *
     * @param  \App\Models\Dtr  $dtr
     * @return void
     */
    public function deleted(Dtr $dtr)
    {
        //
    }

    /**
     * Handle the Dtr "restored" event.
     *
     * @param  \App\Models\Dtr  $dtr
     * @return void
     */
    public function restored(Dtr $dtr)
    {
        //
    }

    /**
     * Handle the Dtr "force deleted" event.
     *
     * @param  \App\Models\Dtr  $dtr
     * @return void
     */
    public function forceDeleted(Dtr $dtr)
    {
        //
    }
}
