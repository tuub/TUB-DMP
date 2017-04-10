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
            'password' => '$2y$10$MgEWfi0Tc8wE/RjroIdW0eVHyEsYetsvE9G/Qyty5hWCowjJJEZ0i',
            'email' => 'anja.kammel@tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => 'zdwXbVQKjbrf3DWkOLu11WeehP7KKBTtofjaNOSpXWCkVCo39MRYDoxQZGxk',
            'is_active' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-06-01 12:51:48',
            'updated_at' => '2017-03-30 13:34:54',
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
            'name' => 'Philipp Offermann',
            'password' => '$2y$10$CbjYqhVjKw.ulMy0Spvw/Ownn6t.XArjEDw2HBHXHseMRIiIEf212',
            'email' => 'offermann@ztg.tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => '7zyMmXs9MqbPtQMA0rURjs7cW5ifYetj12bBlp5dit74idJui6T5FFG7MjWq',
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-07-25 10:07:14',
            'updated_at' => '2016-07-26 10:04:12',
        ));

        User::create(array(
            'id' => 8,
            'name' => 'Stefan Weinzierl',
            'password' => '$2y$10$vkswme55litM6xupSW8UpemdghjltYPD0/WA8PXHVPc.9vlsR/eOq',
            'email' => 'herzog@tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => 'x2l31csQiclnuSLKuUGcgr9GPZq3SQA2myh3OXdg7lSZwDGSE87SYxRmkNmr',
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-07-25 10:26:36',
            'updated_at' => '2016-08-23 15:52:17',
        ));

        User::create(array(
            'id' => 9,
            'name' => 'Stefan Brandt',
            'password' => '$2y$10$Ohpnqn2YK.lQWDiZn3zkG.glfX9LGe0g6H3Sz7uzz8GEwuJe/EYVW',
            'email' => 's.brandt@tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => 'iJlweNi252ZJ0ZvF46VpGkpkJUbwhwgfQi7VSuNcxPEkXVrT8jicoKu8hdAi',
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-07-25 10:32:04',
            'updated_at' => '2016-07-27 13:59:48',
        ));

        User::create(array(
            'id' => 10,
            'name' => 'Axel Vick',
            'password' => '$2y$10$XsSK6q.gqdyxPEevrlWG2eQ5.GzD170Q4gPB0r2uZYszameBnEqjO',
            'email' => 'axel.vick@tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => 'aeQsEJGDEsPADXU5EQ2hE5d8tE5MMLDbRlQIScOg1j30ewoSVjgUtQ6BnLtt',
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-07-25 10:38:15',
            'updated_at' => '2016-07-29 00:06:39',
        ));

        User::create(array(
            'id' => 11,
            'name' => 'Prof. Giuseppe Caire',
            'password' => '$2y$10$ZNcfX1ySZCxgo/JeZJVhAuBgCjGD6X.fFsO4S5SGUaE8QmMUXCu/O',
            'email' => 'thomas.kuehne@tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => null,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-10-21 13:07:00',
            'updated_at' => '2016-10-21 13:07:00',
        ));

        User::create(array(
            'id' => 12,
            'name' => 'Prof. Rudibert King',
            'password' => '$2y$10$TwJsd/eKKGW1w/GvCpYRceu3tcMjfKjBAMd.g/2sHll5UQUq92bNy',
            'email' => 'Christina.riehn@tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => null,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2016-11-29 11:41:40',
            'updated_at' => '2016-11-29 13:08:44',
        ));

        User::create(array(
            'id' => 13,
            'name' => 'Per Broman',
            'password' => '$2y$10$hZ214fK94Vn4bgaH/aoaHelgBIH5kVJfHXSZ8Do.ODEKeAuPTNDwS',
            'email' => 'broman@tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => '47wLXs2Az1gvU8PJgj1k9He8GAItDacjHicAXU8UI2LjIuyOc3A4G1X1hwzw',
            'is_admin' => 1,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2017-01-27 10:58:54',
            'updated_at' => '2017-01-27 12:11:58',
        ));

        User::create(array(
            'id' => 14,
            'name' => 'Ben Juurlink',
            'password' => '$2y$10$RDJzyyZ58CLfQKWtRecIHeNp7Nyk6PLM39ITnuEYc79annDP0qg8G',
            'email' => 'j.lucas@tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => null,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2017-02-07 11:34:53',
            'updated_at' => '2017-02-07 11:34:53',
        ));

        User::create(array(
            'id' => 16,
            'name' => 'Sebastian Grau',
            'password' => '$2y$10$b57K2TeeE3gBzkLMlwIeLeSAj5qiMNNtsQT0QstL9GC1hHonMd13C',
            'email' => 'sebastian.grau@tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => null,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2017-03-07 09:11:17',
            'updated_at' => '2017-03-07 09:11:17',
        ));

        User::create(array(
            'id' => 17,
            'name' => 'Adél Gyimóthy',
            'password' => '$2y$10$XImuKoYCw2JO397Hj5T8VOYGXkttpfUUNW6x7pb2k7kIeI4Sa2DFi',
            'email' => 'adel.gyimothy@tu-berlin.de',
            'institution_id' => 1,
            'remember_token' => null,
            'is_active' => 1,
            'last_login' => null,
            'created_at' => '2017-03-13 12:47:37',
            'updated_at' => '2017-03-13 12:56:07',
        ));
    }
}