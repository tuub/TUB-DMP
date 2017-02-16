<?php

use Illuminate\Database\Seeder;
use App\IvmcFieldType;

class IvmcFieldTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IvmcFieldType::create([
            'id' => 1,
            'name' => 'simple',
            'description' => 'Simple String or Number'
        ]);

        IvmcFieldType::create([
            'id' => 2,
            'name' => 'personal_name',
            'description' => 'Personal Name from multiple fields'
        ]);

        IvmcFieldType::create([
            'id' => 3,
            'name' => 'date_range',
            'description' => 'Date from multiple fields'
        ]);

        IvmcFieldType::create([
            'id' => 4,
            'name' => 'multiple_fields',
            'description' => 'Strings from multiple rows'
        ]);

        IvmcFieldType::create([
            'id' => 5,
            'name' => 'item_list',
            'description' => 'Several strings from multiple rows'
        ]);

        IvmcFieldType::create([
            'id' => 6,
            'name' => 'name_list',
            'description' => 'Several names from multiple rows'
        ]);
    }
}
