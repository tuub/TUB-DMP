<?php

use Illuminate\Database\Seeder;
use App\Template;

class TemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Template::table()->delete();

        Template::create([
            'id' => 1,
            'name' => 'TU Berlin DMP',
            'institution_id' => 1,
            'is_active' => 1
        ]);
    }
}
