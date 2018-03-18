<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;
use Illuminate\Support\Collection;


/**
 * Class Survey
 *
 * @package App
 */
class Survey extends Model
{
    use Uuids;

    /*
    |--------------------------------------------------------------------------
    | Model Options
    |--------------------------------------------------------------------------
    */

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

    /**
     * 1 Survey belongs to 1 Plan, 1:1
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }


    /**
     * 1 Survey belongs to a Template, 1:n
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }


    /**
     * 1 Survey has many Answers through its Questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function answers()
    {
        return $this->hasManyThrough(Answer::class, Question::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    /**
     * What does it do
     *
     * @todo: Documentation
     *
     * @return int
     */
    public function calculateCompletionRate()
    {
        if ($this->getAnswerCount() > 0) {
            return round( ( $this->getAnswerCount() / $this->getQuestionCount() ) * 100 );
        }

        return 0;
    }


    /**
     * What does it do
     *
     * @todo: Documentation
     *
     * @return bool
     */
    public function setCompletionRate()
    {
        return $this->update([
            'completion' => $this->calculateCompletionRate()
        ]);
    }


    /**
     * What does it do
     *
     * @todo: Documentation
     *
     * @param $data
     * @return bool
     */
    public function saveAnswers($data)
    {
        if ($data) {
            $data = array_filter(array_map('array_filter', $data));
            Answer::saveAll($this, $data);
            return $this->setCompletionRate();
        }

        return false;
    }


    /**
     * What does it do
     *
     * @todo: Documentation
     *
     * @return bool
     */
    public function setDefaults()
    {
        /* @var $questions Question[] */
        $questions = $this->template->questions()->active()->get();
        $data = [];
        foreach( $questions as $question ) {
            if( $question->default ) {
                $data[$question->id] = [$question->default];
            }
        }

        return $this->saveAnswers($data);
    }


    /**
     * What does it do
     *
     * @todo: Documentation
     *
     * @return int
     */
    public function getQuestionCount()
    {
        return $this->template->questions()->active()->mandatory()->count();
    }


    /**
     * What does it do
     *
     * @todo: Documentation
     *
     * @return Collection
     */
    public function getMandatoryQuestions()
    {
        return $this->template->questions()->active()->mandatory()->get();
    }


    /**
     * What does it do
     *
     * @todo: Documentation
     * See: http://stackoverflow.com/questions/28651727/laravel-eloquent-distinct-and-count-not-working-properly-together
     * Does not work: $counter[] = Answer::where('question_id', $question->id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->groupBy( 'question_id' )->count();
     * Works as well $counter[] = count(Answer::where('question_id', $question->id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->groupby('question_id')->distinct()->get());
     *
     * @return int
     */
    public function getAnswerCount()
    {
        $counter = [];
        foreach ($this->getMandatoryQuestions() as $question) {
            $counter[] = Answer::where('question_id', $question->id)->where('survey_id', $this->id)->distinct('question_id')->count('question_id');
        }
        return array_sum($counter);
    }
}