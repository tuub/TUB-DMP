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
            'question_id' => 122,
            'value' => json_decode('{ "value": "Lorem Ipsum" }', JSON_UNESCAPED_SLASHES),
        ]);

        Answer::create([
            'survey_id' => 1,
            'question_id' => 130,
            'value' => json_decode('{ "value": ["Video Data", "Awesome Data", "Freaky Data"] }', JSON_UNESCAPED_SLASHES),
        ]);
    }
}
