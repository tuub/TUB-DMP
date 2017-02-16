<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(array(
            'id' => 1,
            'name' => 'demo',
            'password' => Hash::make('demo123'),
            'email' => 'demo@example.com',
            'real_name' => 'Dubio Proreo',
            'institution_id' => 1,
            //'remember_token' => str_random(10),
            'is_admin' => 1,
            'is_active' => 1,
            'last_login' => null
        ));
    }
}
