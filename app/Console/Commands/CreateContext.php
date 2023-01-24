<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Console\ContextClasses\CreateClass;

class CreateContext extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'context:create {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating Context JSON';

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

        $createClass = new CreateClass($modelName);
        $isExecuted = $createClass->execute();

        if(!$isExecuted)
            $this->error('Context already created!');
        else
            $this->info("Context successfully created.");

        return 0;
    }
}
