<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IVMCDMPProjektTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('t_821300_IVMC_DMP_Projekt')->insert([
            [
                'ID_KTR' => 1,
                'ID_MA' => 2,
                'ID_MG' => 3,
                'ID_PT' => 4,
                'ID_MG_Pr' => 5,
                'ID_HP_1' => 6,
                'ID_HP_2' => 7,
                'Projekt_Nr' => '123-456',
                'Proj_Kurzbezeichnung' => 'Morning Glory',
                'Laufzeit_von' => '1980-08-21',
                'Laufzeit_bis' => '2020-01-01',
                'OM' => '123456',
                'Kostenstelle' => '4600112233',
                'Rang' => null,
                'Projektleiter_Nachname' => 'Gallagher',
                'Projektleiter_Vorname' => 'Liam',
                'Projektleiter_Titel' => 'Rockgod',
                'Projektleiter_email' => 'liam@oasisinet.com',
                'Mittelgeber' => 'Creation Records',
                'Projekttraeger' => 'British Lottery Fund',
                'Projekttraeger_KZ' => '123',
                'Foerderprogramm' => 'Rock Stars Life Fund',
                'Hauptprogramm_1' => 'Rock',
                'Unterprogramm' => 'Brit Pop',
                'Langtitel_dt' => '(What\'s the Story) Morning Glory',
                'Langtitel_en' => 'Be Here Now',
                'Acronym' => 'OASIS',
                'Abstract_dt' => 'Lorem Ipsum german',
                'Abstract_en' => 'Lorem Ipsum english'
            ],
        ]);
    }
}