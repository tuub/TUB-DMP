<?php

use Illuminate\Database\Seeder;
use App\DataSourceNamespace;
// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class DataSourceNamespaceTableSeeder extends Seeder
{
    public function run()
    {
        //TestDummy::times(1)->create('App\DataSource');
        DataSourceNamespace::create([
            'data_source_id' => 1,
            'name' => 't_821300_IVMC_DMP_Projekt',
        ]);

        DataSourceNamespace::create([
            'data_source_id' => 1,
            'name' => 't_821310_IVMC_DMP_Projektpartner_extern',
        ]);

        DataSourceNamespace::create([
            'data_source_id' => 1,
            'name' => 't_821311_IVMC_DMP_Projektpartner_intern',
        ]);

        DataSourceNamespace::create([
            'data_source_id' => 1,
            'name' => 't_821320_IVMC_DMP_Weitere_Projektleiter',
        ]);

        DataSourceNamespace::create([
            'data_source_id' => 1,
            'name' => 't_821396_IVMC_DMP_Schlagworte',
        ]);




    }
}

