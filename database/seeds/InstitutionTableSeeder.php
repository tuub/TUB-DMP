<?php

use Illuminate\Database\Seeder;
use App\Institution;

class InstitutionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Institution::create([
            'id' => 1,
            'name' => 'Technische Universität zu Berlin',
            'url' => 'http://www.tu-berlin.de',
            'logo' => 'logo-tu.png',
            'is_external' => 0,
            'is_active' => 1
        ]);

        Institution::create([
            'id' => 2,
            'name' => 'DCC',
            'url' => 'http://www.dcc.ac.uk',
            'logo' => 'logo-dcc.png',
            'is_external' => 1,
            'is_active' => 1
        ]);

        Institution::create([
            'id' => 3,
            'name' => 'DFG',
            'url' => 'http://www.dfg.de',
            'logo' => 'logo-dfg.png',
            'is_external' => 1,
            'is_active' => 0
        ]);

        Institution::create([
            'id' => 4,
            'name' => 'BMBF',
            'url' => 'http://www.bmbf.de',
            'logo' => 'logo-bmbf.png',
            'is_external' => 1,
            'is_active' => 0
        ]);
    }
}
