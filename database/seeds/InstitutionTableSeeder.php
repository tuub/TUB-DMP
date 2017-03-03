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
    }
}
