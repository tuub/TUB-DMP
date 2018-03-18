<?php
declare(strict_types=1);

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Library\HtmlOutputFilter;
use App\Library\FormOutputFilter;
use App\Library\PdfOutputFilter;
use App\Library\Traits\Uuids;


/**
 * Class Answer
 *
 * @todo use AnswerInterface; implements AnswerInterface
 *
 * @package App
 */
class Answer extends Model
{
    use Uuids;

    /*
    |--------------------------------------------------------------------------
    | Model Options
    |--------------------------------------------------------------------------
    */

    protected $table    = 'answers';
    public $incrementing = false;
    protected $guarded  = [];
    protected $casts    = [
        'value' => 'array'
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * n:1 All answers belong to a question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }


    /**
     * n:1 All answers belong to a survey
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Queries and renders answer value for given survey and given question
     * in a specific format.
     *
     * @param Survey|null   $survey
     * @param Question|null $question
     * @param string|null   $format
     * @return Collection|null|string
     */
    public static function get(Survey $survey = null, Question $question = null, string $format = null)
    {
        $format = $format ?? 'html';
        $answers = null;
        $output = null;

        if ($survey && $question) {
            $answers = self::check($survey, $question);
        }

        if ($answers) {
            switch ($format) {
                case 'html':
                    $output = new HtmlOutputFilter($answers, $question->content_type);
                    break;
                case 'form':
                    $output = new FormOutputFilter($answers, $question->content_type);
                    break;
                case 'pdf':
                    $output = new PdfOutputFilter($answers, $question->content_type);
                    break;
            }

            return $output->render();
        }

        return $output;
    }


    /**
     * What does it do
     *
     * Description
     *
     * * @param Survey $survey
     * @param Question $question
     *  About Param
     *
     * @return mixed
     *  About Return Value
     *
     */
    public static function check( Survey $survey, Question $question )
    {
        $result = self::where([
            'survey_id' => $survey->id,
            'question_id' => $question->id
        ])->get();

        return $result;
    }


    /**
     * Replaces the survey's existing answers with new answers with the given data
     *
     * Description
     *
     * @uses self::formatForInput()
     * @param Survey $survey
     * @param array  $data
     * @return bool
     */
    public static function saveAll( Survey $survey, array $data )
    {
        self::where('survey_id', $survey->id)->delete();

        foreach ($data as $question_id => $answer_value) {
            if (\is_array($answer_value)) {
                $answer_value = self::formatForInput(
                    collect(array_filter($answer_value, '\strlen')),
                    Question::find($question_id)->content_type
                );
            }

            self::create([
                'survey_id'   => $survey->id,
                'question_id' => $question_id,
                'value'       => $answer_value
            ]);
        }

        return true;
    }


    /**
     * What does it do
     *
     * @todo: Documentation
     *
     * @param Collection    $data
     * @param ContentType   $content_type
     * @return Collection
     */
    public static function formatForOutput(Collection $data, ContentType $content_type) : ?Collection
    {
        if ($content_type->identifier === 'list') {
            $result = collect([$data->implode(',', 'value')]);
        } else {
            $result = $data;
        }

        return $result;
    }


    /**
     * What does it do
     *
     * @todo: Documentation
     *
     * @param Collection    $data
     * @param ContentType   $content_type
     * @return Collection
     */
    public static function formatForInput(Collection $data, ContentType $content_type) : ?Collection
    {
        if ($content_type->identifier === 'list') {
            $result = collect(explode(',', $data->first()));
        } else {
            $result = $data;
        }

        return $result;
    }
}