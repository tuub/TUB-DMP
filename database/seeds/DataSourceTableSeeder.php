<?php

use Illuminate\Database\Seeder;
use App\DataSource;
// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class DataSourceTableSeeder extends Seeder
{
    public function run()
    {
        //TestDummy::times(1)->create('App\DataSource');
        DataSource::create([
            'id' => 1,
            'type' => 'odbc',
            'identifier' => 'ivmc',
            'name' => 'IVMC',
            'description' => 'IVMC at tubIT',
            'uri' => '127.0.0.1'
        ]);
    }
}
