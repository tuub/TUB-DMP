<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use Auth;
use App\Answer;

/**
 * App\Question
 *
 * @property integer $id
 * @property integer $template_id
 * @property integer $section_id
 * @property string $keynumber
 * @property integer $order
 * @property integer $parent_question_id
 * @property string $text
 * @property string $output_text
 * @property integer $input_type_id
 * @property string $value
 * @property string $default
 * @property string $prepend
 * @property string $append
 * @property string $comment
 * @property string $reference
 * @property string $guidance
 * @property string $hint
 * @property boolean $is_mandatory
 * @property boolean $is_active
 * @property boolean $read_only
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Template $template
 * @property-read \App\Section $section
 * @property-read \App\InputType $input_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\QuestionOption[] $options
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereTemplateId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereSectionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereKeynumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereParentQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereOutputText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereInputTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question wherePrepend($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereAppend($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereReference($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereGuidance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereHint($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereIsMandatory($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereReadOnly($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question parent()
 * @method static \Illuminate\Database\Query\Builder|\App\Question mandatory()
 */
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
        return $this->belongsTo('App\Template');
    }

    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    public function input_type()
    {
        return $this->belongsTo('App\InputType');
    }

    public function answer()
    {
        return $this->hasMany('App\Answer');
    }

    public function options()
    {
        return $this->hasMany('App\QuestionOption');
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
