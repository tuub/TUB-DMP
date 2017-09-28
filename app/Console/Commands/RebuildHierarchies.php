<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Project;
use App\Question;

class RebuildHierarchies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:hierarchy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuilds db hierarchies for tables projects and questions';

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
        Project::rebuild(true);
        Question::rebuild(true);
        return $this->info('All hierarchies rebuilt.');
    }
}
