<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class Section extends \Eloquent
{
    use Uuids;

    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'sections';
    public $incrementing = false;
    public $timestamps = true;
    public $fillable = ['keynumber', 'order', 'template_id', 'name', 'guidance'];
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
        return $this->hasMany(Question::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('sections.is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }


    /*
    |--------------------------------------------------------------------------
    | Model Mutators
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute()
    {
        return $this->keynumber . '. ' . $this->name;
    }


    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public static function getNextOrderPosition(Template $template)
    {
        $position = Section::where('template_id', $template->id)->max('order') + 1;

        return $position;
    }


    public function getAnswerCount( Survey $survey ) {
        $questions = Question::with('answers')->where([
            'template_id' => $survey->template->id,
            'section_id' => $this->id
        ])->get();

        $count = 0;

        foreach ($questions as $question) {
            $answers = Answer::where('question_id', $question->id)->where('survey_id', $survey->id)->distinct('question_id')->count('question_id');
            if ($answers > 0) $count++;
        }

        return $count;
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
                Section::find($id)->update(['keynumber' => $position+1, 'order' => $position+1]);
            }
        }
        return true;
    }


    /**
     * @param Survey $survey
     *
     * @return bool
     */
    public function isEmpty(Survey $survey)
    {
        if( $this->getAnswerCount($survey) > 0 ) {
            return false;
        }
        return true;
    }
}
