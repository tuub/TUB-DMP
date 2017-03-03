<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Section extends \Eloquent
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'sections';
    public $timestamps = true;
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    /*
    public function getTitle()
    {
        $response = $this->keynumber . ' ' . $this->name;
        return $response;
    }
    */

    /**
     * @param Plan $plan
     *
     * @return int
     */
    public function getAnswerCount( Plan $plan ) {
        $questions = Question::where( 'template_id', $plan->template_id )->where( 'section_id', $this->id )->get();
        $count = 0;
        foreach( $questions as $question ) {
            $answers = Answer::where('question_id', $question->id)->where('plan_id', $plan->id)->where('user_id', $plan->user_id)->distinct('question_id')->count('question_id');
            if( $answers > 0 ) {
                $count++;
            }
        }
        return $count;
    }


    /**
     * @param Plan $plan
     *
     * @return bool
     */
    public function isEmpty( Plan $plan )
    {
        if( $this->getAnswerCount( $plan ) > 0 ) {
            return false;
        }
        return true;
    }

}
