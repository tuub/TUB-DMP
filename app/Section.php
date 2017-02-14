<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Section
 *
 * @property integer $id
 * @property string $name
 * @property integer $template_id
 * @property string $keynumber
 * @property integer $order
 * @property string $guidance
 * @property boolean $is_complete
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Template $template
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $questions
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereTemplateId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereKeynumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereGuidance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereIsComplete($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereUpdatedAt($value)
 */
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
        return $this->belongsTo('App\Template');
    }

    public function questions()
    {
        return $this->hasMany('App\Question')->orderBy('order');
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
