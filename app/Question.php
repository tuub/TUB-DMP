<?php
declare(strict_types=1);

namespace App;

use App\Helpers\AppHelper;
use Baum\Node;
use App\Library\Traits\Uuids;
use Iatstuti\Database\Support\NullableFields;


/**
 * Class Question
 *
 * Uses nested set:
 * protected $parentColumn = 'parent_id';
 * protected $leftColumn = 'lft';
 * protected $rightColumn = 'rgt';
 * protected $depthColumn = 'depth';
 * protected $orderColumn = 'order';
 * protected $scoped = [];
 *
 * @package App
 */
class Question extends Node
{
    use Uuids;
    use NullableFields;

    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'questions';
    public $incrementing = false;
    protected $guarded = ['id', 'lft', 'rgt', 'depth'];
    protected $casts = [
        'id' => 'string'
    ];
    protected $nullable = [
        'output_text',
        'parent_id',
        'default',
        'prepend',
        'append',
        'comment',
        'reference',
        'guidance',
        'hint'
    ];
    /* Nested Sets */
    protected $orderColumn = 'order';
    protected $scoped = [];


    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * 1 Question belongs to 1 Template, 1:1
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }


    /**
     * 1 Question belongs to 1 Section, 1:1
     *
     * @todo: belongs to Section which belongs to Template?
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }


    /**
     * 1 Question has 1 ContentType, 1:1
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content_type()
    {
        return $this->belongsTo(ContentType::class);
    }


    /**
     * 1 Question can have many Answer, 1:n
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    /**
     * 1 Question can have many QuestionOption, 1:n
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scopes only root questions.
     *
     * @param $query
     * @return mixed
     */
    public function scopeParent($query)
    {
        return $query->where('parent_id', null);
    }


    /**
     * Scopes only mandatory questions.
     *
     * @param $query
     * @return mixed
     */
    public function scopeMandatory($query)
    {
        return $query->where('questions.is_mandatory', true);
    }


    /**
     * Scopes only active questions.
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('questions.is_active', true);
    }


    /**
     * Scopes only ordered questions.
     *
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->reOrderBy('questions.order', 'asc');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Renders a question's text depending on
     * - keynumber: numeric, with dot or else
     * - output text: available or not
     *
     * @return string
     */
    public function getQuestionText()
    {
        $output = '';

        if ($this->keynumber) {
            $suffix = '';
            if (preg_match('/^[0-9]$/', $this->keynumber)) {
                $suffix = '.';
            } elseif (preg_match('/[a-zA-Z]/', $this->keynumber)) {
                $suffix = ')';
            }
            $output = $this->keynumber . $suffix . '&nbsp;';
        }

        $output .= ($this->output_text ?? $this->text);

        return $output;
    }


    /**
     * What does it do
     *
     * Description
     *
     *
     *  About Param
     *
     * @return mixed
     *  About Return Value
     *
     */
    public function getChildren() {
        return self::where('parent_id', $this->id)->get();
    }


    /**
     * What does it do
     *
     * @todo Documentation
     *
     * @param array $data
     * @return bool
     */
    public function updatePositions($data)
    {
        ksort($data);
        foreach ($data as $level => $item) {
            /* @var array $item */
            foreach ($item as $position => $id) {
                $question = self::find($id);
                if ($question->getLevel() === $level) {
                    $question->update(['order' => $position+1]);
                }
            }
        }

        return true;
    }


    /**
     * Returns next order position for question in given section.
     *
     * @param Section $section
     * @return int
     */
    public static function getNextOrderPosition(Section $section)
    {
        return self::where('section_id', $section->id)->max('order') + 1;
    }


    /**
     * Checks if any of the questions children has an answer.
     *
     * @param Survey $survey
     * @return bool
     */
    public function childrenHaveAnswers(Survey $survey) : bool
    {
        foreach ($this->getImmediateDescendants() as $children) {
            if (Answer::check($survey, $children)->count() > 0) {
                return true;
            }
        }

        return false;
    }

    public function display(Survey $survey, Question $question, $debug = false)
    {
        $answer = \App\Answer::get($survey, $question, 'html');

        if ($answer !== null && \strlen($answer) === 0) {
            $answer = null;
        }

        //AppHelper::varDump($answer);

        if ($answer !== null || ($question->content_type->identifier === 'plain' && $question->export_never === false)) {
            //echo '<h4>' . $question->text . '</h4>';
            //echo $answer;
            //echo '<h5>' . $question->text . '</h5>';
            //echo 'Hat eine Antwort ODER ist exportable plain!';
            $result = true;
        } else {
            if ($question->export_always === true || ($question->getImmediateDescendants()->count() > 0 && $question->childrenHaveAnswers($survey))) {
                //echo '<h4>' . $question->text . '</h4>';
                //echo $answer;
                $result = true;
            } else {
                //echo '<h4>' . $question->text . '</h4>';
                //echo 'RAUS!';
                $result = false;
            }
        }

        if($result == true && $debug) {
            echo '<div style="background-color: #ccc;">';
            AppHelper::varDump($answer);
            echo '<ul>';
            echo '<li>question->text:' . $question->text ?? $question->output_text. '</li>';
            //echo '<li>question->export_always:' . $question->export_always . '</li>';
            //echo '<li>answer:' . $answer . '</li>';
            //echo '<li>question->content_type->identifier:' . $question->content_type->identifier . '</li>';
            //echo '<li>Kids:' . ($question->getImmediateDescendants()->count() > 0 && $question->childrenHaveAnswers($survey)) . '</li>';
            echo '<li>question->export_never:' . $question->export_never . '</li>';
            echo '</ul>';
            echo '</div>';
        }

        return $result;
    }
}
