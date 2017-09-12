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
            'created_at' => '2016-05-27 14:44:44',
            'updated_at' => '2016-05-27 14:44:44',
        ));

        User::create(array(
            'id' => 2,
            'email' => 'monika.kuberek@tu-berlin.de',
            'institution_id' => 1,
            'is_admin' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-05-27 14:44:44',
            'updated_at' => '2016-05-27 14:44:44',
        ));

        User::create(array(
            'id' => 3,
            'email' => 'demo@example.com',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-05-27 14:44:44',
            'updated_at' => '2016-05-27 14:44:44',
        ));

        User::create(array(
            'id' => 4,
            'email' => 'rgiessmann@gmail.com',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-05-27 14:44:44',
            'updated_at' => '2016-05-27 14:44:44',
        ));

        User::create(array(
            'id' => 5,
            'email' => 'anja.kammel@tu-berlin.de',
            'institution_id' => 1,
            'is_admin' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-06-01 12:51:48',
            'updated_at' => '2017-03-30 13:34:54',
        ));

        User::create(array(
            'id' => 6,
            'email' => 'anna.zirk@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-06-01 12:51:48',
            'updated_at' => '2016-06-01 13:33:12',
        ));

        User::create(array(
            'id' => 7,
            'email' => 'offermann@ztg.tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-07-25 10:07:14',
            'updated_at' => '2016-07-26 10:04:12',
        ));

        User::create(array(
            'id' => 8,
            'email' => 'herzog@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-07-25 10:26:36',
            'updated_at' => '2016-08-23 15:52:17',
        ));

        User::create(array(
            'id' => 9,
            'email' => 's.brandt@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-07-25 10:32:04',
            'updated_at' => '2016-07-27 13:59:48',
        ));

        User::create(array(
            'id' => 10,
            'email' => 'axel.vick@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-07-25 10:38:15',
            'updated_at' => '2016-07-29 00:06:39',
        ));

        User::create(array(
            'id' => 11,
            'email' => 'thomas.kuehne@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-10-21 13:07:00',
            'updated_at' => '2016-10-21 13:07:00',
        ));

        User::create(array(
            'id' => 12,
            'email' => 'Christina.riehn@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-11-29 11:41:40',
            'updated_at' => '2016-11-29 13:08:44',
        ));

        User::create(array(
            'id' => 13,
            'email' => 'broman@tu-berlin.de',
            'institution_id' => 1,
            'is_admin' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2017-01-27 10:58:54',
            'updated_at' => '2017-01-27 12:11:58',
        ));

        User::create(array(
            'id' => 14,
            'email' => 'j.lucas@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2017-02-07 11:34:53',
            'updated_at' => '2017-02-07 11:34:53',
        ));

        User::create(array(
            'id' => 16,
            'email' => 'sebastian.grau@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2017-03-07 09:11:17',
            'updated_at' => '2017-03-07 09:11:17',
        ));

        User::create(array(
            'id' => 17,
            'email' => 'adel.gyimothy@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2017-03-13 12:47:37',
            'updated_at' => '2017-03-13 12:56:07',
        ));
    }
}