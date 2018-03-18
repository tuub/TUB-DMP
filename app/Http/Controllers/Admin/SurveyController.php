<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Plan;
use App\Question;
use App\Survey;

/**
 * Class SurveyController
 *
 * @package App\Http\Controllers\Admin
 */
class SurveyController extends Controller
{
    protected $survey;
    protected $plan;


    /**
     * SurveyController constructor.
     *
     * @param Survey $survey
     * @param Plan   $plan
     */
    public function __construct(Survey $survey, Plan $plan)
    {
        $this->survey = $survey;
        $this->plan = $plan;
    }


    /**
     * Displays question answer pairs for the given plan object.
     *
     * @todo: The difference between plan and survey is not very clean.
     * @todo: Why Plan $plan?
     *
     * @param Plan $plan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Plan $plan)
    {
        /* @var $questions Question[] */
        $questions = $plan->survey->template->questions;
        $survey = [];

        foreach ($questions as $question) {
            $survey[$question->text] = Answer::get($plan->survey, $question);
        }

        return view('admin.survey.index', compact('survey', 'plan'));
    }
}