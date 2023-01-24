<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\ContextClasses\GenerateClass;

class GenerateContext extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'context:generate {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate MVC from Context';

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
        // init variables
        $modelName = $this->argument('model');

        $generateContext = new GenerateClass($modelName);
        $isExecuted = $generateContext->execute();

        if(!$isExecuted)
            $this->error('Error found in generating Context.');
        else
            $this->info("Context generated successfully.");

        return 0;
    }
}
