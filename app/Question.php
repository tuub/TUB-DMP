<?php

namespace App;

use Baum\Node;
use App\Library\Traits\Uuids;
use Iatstuti\Database\Support\NullableFields;

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
    public $timestamps = true;
    protected $guarded = ['id', 'lft', 'rgt', 'depth'];
    protected $casts = [
        'id' => 'string',
    ];
    protected $nullable = [
        'output_text', 'parent_id', 'default', 'prepend', 'append', 'comment', 'reference', 'guidance', 'hint',
    ];

    /* Nested Sets */
    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';
    protected $orderColumn = 'order';
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

    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

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
        return $query->reOrderBy('questions.order', 'asc');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

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

        if (count($default_value) > 0) {
            if (is_null(Answer::check($this, $plan))) {
                Answer::setAnswer( $plan, $this, $user, $default_value );
            }

            return true;
        }

        return false;
    }


    public function getChildren() {
        return Question::where('parent_id', $this->id)->get();
    }


    /**
     * @param $data
     *
     * @return bool
     */
    public function updatePositions($data)
    {
        foreach ($data as $items) {
            foreach ($items as $position => $id) {
                $q = Question::find($id);
                $q->order = $position+1;
                $q->save();
            }
        }
        return true;
    }


    public static function getNextOrderPosition(Section $section)
    {
        $position = Question::where('section_id', $section->id)->max('order') + 1;
        return $position;
    }
}
