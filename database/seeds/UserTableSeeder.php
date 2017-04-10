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
            'name' => 'Fab Ian Fuerste',
            'password' => '$2y$10$TAFAXFC.C.Eln7qxSXpIA.0dnt1PqSZjginZ63zAMoxkQ4wrSDpiK',
            'email' => 'fab.fuerste@gmail.com',
            'institution_id' => 1,
            'remember_token' => 'qW7V4r755DSbDdaJrUvd7NtOsF32T1k5QiyLzevw12ZGwZYDjFdLMGu4u4Uc',
            'is_admin' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-05-27 14:44:44',
            'updated_at' => '2016-05-27 14:44:44',
        ));

        User::create(array(
            'id' => 2,
            'name' => 'Monika Kuberek',
            'password' => '$2y$10$CDraR0coI6vrm5WiXfxOAej9bODTrGqB7NnWyvOieG43vEBz8yi9O',
            'email' => 'monika.kuberek@tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => '91h5xNGKx2JRuIw7UiY3Y7o9jBiy1p1WRfQhxWqHNvg2k3p9JYHDZSMBpPoA',
            'is_admin' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-05-27 14:44:44',
            'updated_at' => '2016-05-27 14:44:44',
        ));

        User::create(array(
            'id' => 3,
            'name' => 'Demo McTest',
            'password' => '$2y$10$3iptHzy0x59ow1mQW8wGhONw59VqS0wyGJl/Gw0LRdqQ8/WhR1IUS',
            'email' => 'demo@example.com',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-05-27 14:44:44',
            'updated_at' => '2016-05-27 14:44:44',
        ));

        User::create(array(
            'id' => 4,
            'name' => 'Robert Giessmann',
            'password' => '$2y$10$BVoE2EN3thv/w4V9yahpeO6sHnHvPM4PEngQfWwbt647caqLHBDI.',
            'email' => 'rgiessmann@gmail.com',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-05-27 14:44:44',
            'updated_at' => '2016-05-27 14:44:44',
        ));

        User::create(array(
            'id' => 5,
            'name' => 'Anja Kammel',
            'password' => '',
            'email' => 'anna.zirk@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-06-01 12:51:48',
            'updated_at' => '2016-06-01 13:33:12',
        ));

        User::create(array(
            'id' => 6,
            'name' => 'Anna Zirk',
            'password' => '$2y$10$8E96qlFJdrCCjV0eTDdH/O14cOyWQ36w7HXIOSMVo.EVDeKunazUG',
            'email' => 'anna.zirk@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-06-01 12:51:48',
            'updated_at' => '2016-06-01 13:33:12',
        ));

        User::create(array(
            'id' => 7,
            'name' => 'Anna Zirk',
            'password' => '$2y$10$8E96qlFJdrCCjV0eTDdH/O14cOyWQ36w7HXIOSMVo.EVDeKunazUG',
            'email' => 'anna.zirk@tu-berlin.de',
            'institution_id' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-06-01 12:51:48',
            'updated_at' => '2016-06-01 13:33:12',
        ));
    }
}
