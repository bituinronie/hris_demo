<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Traits\CronTrait;

class RunLeaveAnnualEarning extends Command
{
    use CronTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:annual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Annual Leave Earning';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->requestAnnualEarning();

        return 0;
    }
}
