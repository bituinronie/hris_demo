<?php

namespace App\Console;

use App\Traits\CronTrait;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return env('APP_TIMEZONE');
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Generate DTR
        $schedule->command('dtr:generate')
                ->description('Generate DTR')
                ->monthlyOn(4) // MUST CHANGE
                ->runInBackground();

        // Run Request Automatic
        $schedule->command('request:automatic')
                ->description('Request Automatic')
                ->daily()
                ->runInBackground();

        // Run Annual Leave Earning
        $schedule->command('leave:annual')
                ->description('Annual Leave Earning')
                ->yearly()
                ->runInBackground();

        // Run Monthly Leave Earning
        $schedule->command('leave:monthly')
                ->description('Monthly Leave Earning')
                ->monthlyOn(10)
                ->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
