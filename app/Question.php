<?php

namespace App;

use Baum\Node;

use Auth;
use App\Answer;

class Question extends Node
{

    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'questions';
    public $timestamps = true;
    protected $guarded = ['id', 'parent_id', 'lft', 'rgt', 'depth'];

    /* Nested Sets */
    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';
    protected $orderColumn = null;
    protected $scoped = [];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function content_type()
    {
        return $this->belongsTo(ContentType::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }


    public function scopeParent($query)
    {
        return $query->where('parent_id', null);
    }


    public function scopeMandatory($query)
    {
        return $query->where('questions.is_mandatory', true);
    }

    public function scopeActive($query)
    {
        return $query->where('questions.is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('questions.order', 'asc');
    }



    /**
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->value;
    }

    /**
     * @param Plan $plan
     *
     * @return bool
     */
    public function setDefaultValue( Plan $plan )
    {
        $default_value = [];
        //$save_method = $this->input_type->category;
        $default_value[] = $this->getDefaultValue();
        //$default_value = array_filter( $default_value );
        $user = User::find($plan->user_id);        

        if ( count( $default_value ) > 0 ) {
            if( is_null(Answer::check($this, $plan)) ) {
                Answer::setAnswer( $plan, $this, $user, $default_value );
                return true;
            }

        }
        return false;
    }

    /*
    public static function getQuestions( Template $template ) {
        $result = Question::where('template_id', $template->id)->where('is_active', 1)->get();
        return $result;
    }

    public static function getQuestion( $id ) {
        $result = Question::where('id', $id)->where('is_active', 1)->get();
        return $result;
    }

    public function getQuestionText( $id ) {
        return $this->text;
    }
    */

    public function getChildren() {
        return Question::where('parent_id', $this->id)->get();
    }
}
