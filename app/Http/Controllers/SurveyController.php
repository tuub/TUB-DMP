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

//use Auth;
//use Exporters;
//use Redirect;
//use Log;
//use Mail;
//use View;

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
        $survey = $this->survey->findOrFail($id);
        $sections = $survey->template->sections;

        //$questions = Question::get()->toHierarchy();
        //\AppHelper::varDump($questions);

        //foreach ($sections as $section) {
        //    $questions[$section->id] = $section->questions()->parent()->active()->ordered()->get();
        //}

        //dump($questions);

        return view('survey.show', compact('survey'));
    }


    public function edit($id)
    {
        $survey = $this->survey->findOrFail($id);
        return view('survey.edit', compact('survey'));
    }


    public function update(SurveyRequest $request)
    {
        /* Get the survey */
        $survey = $this->survey->findOrFail($request->id);

        /* Get the request data */
        $data = $request->except(['_token', '_method', 'save']);

        /* Save the answers */
        if ($survey->saveAnswers($data)) {
            $notification = [
                'status'     => 200,
                'message'    => 'Survey was successfully updated!',
                'alert-type' => 'success'
            ];
            //Event::fire(new PlanUpdated($plan));
        } else {
            $notification = [
                'status'     => 500,
                'message'    => 'Survey was not updated!',
                'alert-type' => 'error'
            ];
        }

        /* Response */
        $request->session()->flash('message', $notification['message']);
        $request->session()->flash('alert-type', $notification['alert-type']);

        return redirect()->route('dashboard');
    }
}