<?php

namespace App\Console\Commands;

use App\Survey;
use Illuminate\Console\Command;
use App\Plan;
use App\IvmcMapping;

class CalculateCompletion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dmp:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates completion rates';

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
     * @return mixed
     */
    public function handle()
    {
        $surveys = Survey::get();
        foreach($surveys as $survey) {
            $survey->setCompletionRate();
        }

        return $this->info('All Surveys calculated.');
    }
}
