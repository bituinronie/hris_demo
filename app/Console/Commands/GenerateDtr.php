<?php

namespace App\Console\Commands;

use App\Traits\CronTrait;
use Illuminate\Console\Command;

class GenerateDtr extends Command
{
    use CronTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dtr:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate DTR';

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
        $this->generateDtr();

        return 0;
    }
}
