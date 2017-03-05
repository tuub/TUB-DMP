<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use Auth;
use App\Answer;

class Question extends Model
{

    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'questions';
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

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function input_type()
    {
        return $this->belongsTo(InputType::class);
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
        return $query->where('parent_question_id', null);
    }

    public function scopeMandatory($query)
    {
        return $query->where('is_mandatory', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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
        return Question::where('parent_question_id', $this->id)->get();
    }
}
