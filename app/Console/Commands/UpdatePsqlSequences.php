<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdatePsqlSequences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sequences';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates PostgreSQL sequences to the max id of the corresponding tables.';

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
        if (env('DB_CONNECTION') == 'pgsql') {

            $query = "SELECT table_schema, table_name as name
                        FROM information_schema.tables 
                        WHERE table_schema = 'public'
                        ORDER BY table_name";

            $tables = DB::select(DB::raw($query));
            $bar = $this->output->createProgressBar(count($tables));

            foreach ($tables as $table) {
                $bar->advance();
                $query = "SELECT column_name
                            FROM information_schema.columns
                            WHERE table_name='" . $table->name . "' AND column_name='id'";

                $foo = DB::select(DB::raw($query));

                if (count($foo) > 0) {
                    $query = "SELECT setval(pg_get_serial_sequence('" . $table->name . "', 'id'),
                                    COALESCE(MAX(id)+1,1), false)
                                    FROM " . $table->name;

                    DB::select(DB::raw($query));
                    $this->info(' Updated sequence for ' . $table->name . '.');
                }
            }
            //$bar->finish();
            $this->info(' All table sequences updated.');
        }
    }
}