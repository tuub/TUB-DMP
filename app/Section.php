<?php
declare(strict_types=1);

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;


/**
 * Class Section
 *
 * @package App
 */
class Section extends Model
{
    use Uuids;

    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'sections';
    public $incrementing = false;
    public $fillable = [
        'keynumber',
        'order',
        'template_id',
        'name',
        'guidance',
        'is_active',
        'export_keynumber'
    ];
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * 1 Section belongs to 1 Template, 1:1
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }


    /**
     * 1 Section has many Question, 1:n
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scopes active sections.
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('sections.is_active', true);
    }


    /**
     * Scopes ordered sections.
     *
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }


    /*
    |--------------------------------------------------------------------------
    | Model Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Returns fully qualified section name
     *
     * Includes Keynumber and Name.
     *
     * @return string
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


    /**
     * Returns next order position for section in given template.
     *
     * @param Template $template
     * @return int
     */
    public static function getNextOrderPosition(Template $template)
    {
        return self::where('template_id', $template->id)->max('order') + 1;
    }


    /**
     * Returns answer count of given survey.
     *
     * @param Survey $survey
     * @return int
     */
    public function getAnswerCount( Survey $survey ) {
        $questions = Question::with('answers')->where([
            'template_id' => $survey->template->id,
            'section_id' => $this->id
        ])->get();

        $count = 0;

        foreach ($questions as $question) {
            $answers = Answer::where('question_id', $question->id)->where('survey_id', $survey->id)->distinct('question_id')->count('question_id');
            if ($answers > 0) {
                $count++;
            }
        }

        return $count;
    }


    /**
     * Updates section with given position set.
     *
     * @param array $data
     * @return bool
     */
    public function updatePositions($data)
    {
        foreach ($data as $items) {
            /* @var array $items */
            foreach ($items as $position => $id) {
                self::find($id)->update([
                    'keynumber' => $position + 1,
                    'order' => $position + 1
                ]);
            }
        }
        return true;
    }


    /**
     * Checks if a section in given survey is empty.
     *
     * @param Survey $survey
     * @return bool
     */
    public function isEmpty(Survey $survey)
    {
        return !($this->getAnswerCount($survey) > 0);
    }
}