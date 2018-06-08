<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IVMCDMPSchlagworteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('t_821396_IVMC_DMP_Schlagworte')->insert([
            [
                'ID' => '1468410',
                'ID_KTR' => '1124114',
                'Projekt_Nr' => '12345678',
                'Schlagwort' => 'Physikalische Chemie',
            ],
            [
                'ID' => '1468411',
                'ID_KTR' => '1124114',
                'Projekt_Nr' => '12345678',
                'Schlagwort' => 'Verfahrenstechnik',
            ],
            [
                'ID' => '1468412',
                'ID_KTR' => '1124114',
                'Projekt_Nr' => '12345678',
                'Schlagwort' => 'Membrantechnik',
            ],
            [
                'ID' => '1468413',
                'ID_KTR' => '1124114',
                'Projekt_Nr' => '12345678',
                'Schlagwort' => 'Pickering-Emulsionen',
            ],


        ]);
    }
}