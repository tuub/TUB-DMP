<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Plan;
use App\IvmcMapping;

class PrefillPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dmp:prefill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prefill DMPs with data from external source';

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
        $plans = Plan::getUnprefilledPlans();
        foreach( $plans as $plan ) {
            $plan->setDefaultValues();
            if($plan->datasource) {
                $connection = odbc_connect( "IVMC_MSSQL", "WIN\svc-ub-dmp", "vByZ80az" );
                $tables = IvmcMapping::getTables();
                foreach ( $tables as $table ) {
                    $plan->setExternalValues( $table, $connection );
                }
                odbc_close($connection);
            }
            $plan->setPrefillStatus( true );
            $plan->setPrefillTimestamps();
            $msg = 'Plan for TUB ' . $plan->project_number . ' successfully prefilled!';
            $this->info( $msg );
            $writelogFile = \File::append(storage_path('prefiller.log'), date("Y-m-d H:i:s") . ' : ' );
            $writelogFile = \File::append(storage_path('prefiller.log'), $msg . PHP_EOL );
            if ($writelogFile === false)
            {
                $this->error('Could not write logfile for Plan with Project Number ' . $plan->project_number . '!');
            }
        }
        return $this->info('All jobs completed. All your base are belong to us. Goodbye.');
    }
}
