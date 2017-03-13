<?php

use Illuminate\Database\Seeder;
use App\Survey;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class SurveyTableSeeder extends Seeder
{
    public function run()
    {
        Survey::create([
            'id' => 1,
            'plan_id' => 1,
            'template_id' => 1,
            'completion' => 0,
        ]);
    }
}
