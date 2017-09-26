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
            'email' => 'fabian.fuerste@tu-berlin.de',
            'institution_id' => 1,
            'is_admin' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 2,
            'email' => 'monika.kuberek@tu-berlin.de',
            'institution_id' => 1,
            'is_admin' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 3,
            'email' => 'demo@example.com',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 4,
            'email' => 'rgiessmann@gmail.com',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 5,
            'email' => 'anja.kammel@tu-berlin.de',
            'institution_id' => 1,
            'is_admin' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 6,
            'email' => 'anna.zirk@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 7,
            'email' => 'offermann@ztg.tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 8,
            'email' => 'herzog@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 9,
            'email' => 's.brandt@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 10,
            'email' => 'axel.vick@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 11,
            'email' => 'thomas.kuehne@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 12,
            'email' => 'Christina.riehn@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 13,
            'email' => 'broman@tu-berlin.de',
            'institution_id' => 1,
            'is_admin' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 14,
            'email' => 'j.lucas@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 16,
            'email' => 'sebastian.grau@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));

        User::create(array(
            'id' => 17,
            'email' => 'adel.gyimothy@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
        ));
    }
}