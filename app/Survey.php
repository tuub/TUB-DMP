<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    public $timestamps = true;
    protected $table = 'surveys';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['plan_id', 'template_id'];


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function answers()
    {
        return $this->hasManyThrough(Answer::class, Question::class);
    }

    public function setDefaults()
    {
        $questions = $this->template->questions()->active()->get();
        $answers = [];
        foreach( $questions as $question ) {
            if( $question->default ) {
                $answers[$question->id] = [$question->default];
            }
        }
        Answer::saveAll( $this, $answers );

        //TODO: Refactor to Answer::saveAll ?
        /*
        foreach ($questions as $question) {
            if ($question->default) {
                Answer::create([
                    'survey_id' => $this->id,
                    'question_id' => $question->id,
                    'value' => ['value' => $question->default],
                ]);
            }
        }
        */

        return true;
    }




    public function getQuestionCount()
    {
        $count = $this->template->questions()->active()->mandatory()->count();
        return $count;
    }

    public function getMandatoryQuestions()
    {
        return $this->template->questions()->active()->mandatory()->get();
    }

    public function getAnswerCount()
    {
        $counter = [];
        foreach( $this->getMandatoryQuestions() as $question ) {
            /* See: http://stackoverflow.com/questions/28651727/laravel-eloquent-distinct-and-count-not-working-properly-together */
            /* Does not work */ //$counter[] = Answer::where('question_id', $question->id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->groupBy( 'question_id' )->count();
            /* Works as well */ //$counter[] = count(Answer::where('question_id', $question->id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->groupby('question_id')->distinct()->get());
            $counter[] = Answer::where('question_id', $question->id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->distinct('question_id')->count('question_id');
        }
        $count = array_sum( $counter );
        return $count;
    }

    public function getQuestionAnswerPercentage()
    {
        return round( ( $this->getAnswerCount() / $this->getQuestionCount() ) * 100 );
    }

}
