<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SurveyRequest;
use App\Library\Notification;
use App\Library\Sanitizer;
use App\Survey;

/**
 * Class SurveyController
 *
 * @package App\Http\Controllers
 */
class SurveyController extends Controller
{
    protected $survey;


    /**
     * SurveyController constructor.
     *
     * @param Survey $survey
     */
    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }


    /**
     * Displays the survey with ther given ID.
     *
     * @param string $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     */
    public function show($id)
    {
        $survey = $this->survey->findOrFail($id);

        return view('survey.show', compact('survey'));
    }


    /**
     * Renders the edit form for the given survey ID.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     */
    public function edit($id)
    {
        $survey = $this->survey->findOrFail($id);
        return view('survey.edit', compact('survey'));
    }


    /**
     * Updates the survey with the given request data.
     *
     * @todo: Refactor to include $id in the signature.
     *
     * @param SurveyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SurveyRequest $request)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $remove = ['_token', '_method', 'save'];
        $data = $dirty->cleanUp($remove);

        /* The validation */

        /* Get object */
        $survey = $this->survey->findOrFail($request->id);

        /* The operation */
        $op = $survey->saveAnswers($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully updated the survey!', 'success');
        } else {
            $notification = new Notification(500, 'Error while updating the survey!', 'error');
        }

        //Event::fire(new PlanUpdated($plan));

        $notification->toSession($request);

        return redirect()->route('dashboard');
    }
}