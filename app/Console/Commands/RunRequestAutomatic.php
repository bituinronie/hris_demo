<?php

namespace App\Console\Commands;

use App\Traits\CronTrait;
use Illuminate\Console\Command;

class RunRequestAutomatic extends Command
{
    use CronTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:automatic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Request Automatic';

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
        $this->requestAutomatic();

        return 0;
    }
}
