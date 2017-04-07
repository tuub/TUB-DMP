<?php

namespace App\Http\Controllers;

use App\HtmlOutputFilter;
use App\Answer;
use App\Question;

use Request;
use App\Http\Requests\SurveyRequest;
use App\Survey;

//use PhpSpec\Process\Shutdown\UpdateConsoleAction;
use Jenssegers\Optimus\Optimus;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Laracasts\Flash\Flash;

use Auth;
//use Exporters;
use Redirect;
use Log;
use Mail;
use Notifier;
use View;

/**
 * Class SurveyController
 *
 * @package App\Http\Controllers
 */
class SurveyController extends Controller
{
    protected $survey;

    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }


    public function show($id)
    {
        $survey = $this->survey
                ->with('plan', 'plan.project.user', 'template', 'template.questions', 'template.questions.answers')
                ->findOrFail($id);

        if ($survey) {
            return view('survey.show', compact('survey'));
        }
    }


    public function edit($id)
    {
        $survey = $this->survey->with('plan', 'template', 'template.questions', 'template.questions.answers')->findOrFail($id);
        $questions = $survey->template->questions()->with('section', 'answers')->get();

        return view('survey.edit', compact('survey', 'questions'));
    }


    public function update(SurveyRequest $request)
    {
        /* Get the survey */
        $survey = $this->survey->findOrFail($request->id);

        /* Get the request data */
        $data = $request->except(['_token', '_method', 'save']);

        /* Save the answers */
        $survey->saveAnswers($data);

        return Redirect::back();
    }
}