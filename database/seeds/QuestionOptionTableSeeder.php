<?php

use Illuminate\Database\Seeder;
use App\QuestionOption;

class QuestionOptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: question_ids

        QuestionOption::create(array(
            'id' => 1,
            'question_id' => 125,
            'text' => 'Yes',
            'value' => '1'
        ));

        QuestionOption::create(array(
            'id' => 2,
            'question_id' => 125,
            'text' => 'No',
            'value' => '0'
        ));

        QuestionOption::create(array(
            'id' => 3,
            'question_id' => 126,
            'text' => 'Yes',
            'value' => '1'
        ));

        QuestionOption::create(array(
            'id' => 4,
            'question_id' => 126,
            'text' => 'No',
            'value' => '0'
        ));

        QuestionOption::create(array(
            'id' => 5,
            'question_id' => 130,
            'text' => 'Generic Research Data',
            'value' => 'Generic Research Data'
        ));

        QuestionOption::create(array(
            'id' => 6,
            'question_id' => 130,
            'text' => 'Measurements',
            'value' => 'Measurements'
        ));

        QuestionOption::create(array(
            'id' => 7,
            'question_id' => 130,
            'text' => 'Simulations',
            'value' => 'Simulations'
        ));

        QuestionOption::create(array(
            'id' => 8,
            'question_id' => 130,
            'text' => 'Audio Data',
            'value' => 'Audio Data'
        ));

        QuestionOption::create(array(
            'id' => 9,
            'question_id' => 130,
            'text' => 'Video Data',
            'value' => 'Video Data'
        ));

        QuestionOption::create(array(
            'id' => 10,
            'question_id' => 130,
            'text' => 'Other',
            'value' => 'Other'
        ));

        QuestionOption::create(array(
            'id' => 11,
            'question_id' => 151,
            'text' => 'Creative Commons',
            'value' => 'Creative Commons'
        ));

        QuestionOption::create(array(
            'id' => 12,
            'question_id' => 151,
            'text' => 'GNU Public License',
            'value' => 'GNU Public License'
        ));

        QuestionOption::create(array(
            'id' => 13,
            'question_id' => 151,
            'text' => 'MIT License',
            'value' => 'MIT License'
        ));

        QuestionOption::create(array(
            'id' => 14,
            'question_id' => 151,
            'text' => 'Other',
            'value' => 'Other'
        ));
    /*
        QuestionOption::create(array(
            'id' => 15,
            'question_id' => 153,
            'text' => 'Yes',
            'value' => '1'
        ));

        QuestionOption::create(array(
            'id' => 16,
            'question_id' => 153,
            'text' => 'No',
            'value' => '0'
        ));

        QuestionOption::create(array(
            'id' => 17,
            'question_id' => 155,
            'text' => 'Yes',
            'value' => '1'
        ));

        QuestionOption::create(array(
            'id' => 18,
            'question_id' => 155,
            'text' => 'No',
            'value' => '0'
        ));

        QuestionOption::create(array(
            'id' => 19,
            'question_id' => 185,
            'text' => 'Yes',
            'value' => '1'
        ));

        QuestionOption::create(array(
            'id' => 20,
            'question_id' => 185,
            'text' => 'No',
            'value' => '0'
        ));

        QuestionOption::create(array(
            'id' => 21,
            'question_id' => 191,
            'text' => 'Yes',
            'value' => '1'
        ));

        QuestionOption::create(array(
            'id' => 22,
            'question_id' => 191,
            'text' => 'No',
            'value' => '0'
        ));
        */





    }
}
