<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert(array (
            0 => 
            array (
                'id' => '2ca6a320-658e-11e8-87bf-192febe21912',
                'email' => 'dmp@example.org',
                'is_admin' => true,
                'is_active' => true,
                'type' => 'shibboleth',
                'tub_om' => '123456',
            ),
        ));
    }
}