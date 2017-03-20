<?php

use Illuminate\Database\Seeder;
use App\Answer;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class AnswerTableSeeder extends Seeder
{
    public function run()
    {
        Answer::create([
            'survey_id' => 1,
            'question_id' => 121,
            'value' => '{ "0": "Lorem Ipsum" }',
        ]);

        Answer::create([
            'survey_id' => 1,
            'question_id' => 130,
            'value' => '{ "0": "Video Data", "1": "Awesome Data", "2": "Freaky Data" }',
        ]);
    }
}
