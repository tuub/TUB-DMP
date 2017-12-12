<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Answer;
use App\Library\Traits\Uuids;

class Survey extends Model
{
    use Uuids;

    /*
    |--------------------------------------------------------------------------
    | Model Options
    |--------------------------------------------------------------------------
    */

    public $timestamps = true;
    public $incrementing = false;
    protected $table = 'surveys';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['plan_id', 'template_id', 'completion'];
    protected $touches = ['plan'];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public function calculateCompletionRate()
    {
        if ($this->getAnswerCount() > 0) {
            return round( ( $this->getAnswerCount() / $this->getQuestionCount() ) * 100 );
        }

        return 0;
    }


    public function setCompletionRate()
    {
        $this->update([
            'completion' => $this->calculateCompletionRate()
        ]);

        return true;
    }


    public function saveAnswers($data)
    {
        if ($data) {
            $data = array_filter(array_map('array_filter', $data));
            Answer::saveAll($this, $data);
            $this->setCompletionRate();
        }

        return true;
    }


    public function setDefaults()
    {
        $questions = $this->template->questions()->active()->get();
        $data = [];
        foreach( $questions as $question ) {
            if( $question->default ) {
                $data[$question->id] = [$question->default];
            }
        }
        $this->saveAnswers($data);

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
            $counter[] = Answer::where('question_id', $question->id)->where('survey_id', $this->id)->distinct('question_id')->count('question_id');
        }
        $count = array_sum( $counter );
        return $count;
    }
}