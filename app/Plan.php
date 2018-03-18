<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Event;
use App\Events\PlanCreated;
use Carbon\Carbon;
use App\Library\Traits\Uuids;
use Illuminate\Support\Facades\Mail;
use App\Mail\PlanToRecipient;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Plan extends Model
{
    // =======================================================================//
    // ! Model Options                                                        //
    // =======================================================================//

    use Uuids;

    public $incrementing = false;
    protected $table    = 'plans';
    protected $dates    = ['created_at', 'updated_at', 'snapshot_at'];
    protected $fillable = ['title', 'project_id', 'version', 'template_id', 'is_active', 'is_snapshot', 'snapshot_at'];

    // =======================================================================//
    // ! Model Relationships                                                  //
    // =======================================================================//

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function survey()
    {
        return $this->hasOne(Survey::class);
    }


    // =======================================================================//
    // ! Model Scopes                                                         //
    // =======================================================================//


    /**
     * Scope plans to order
     *
     * @param mixed     $query A query
     * @return mixed    $query The refined query
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy( 'updated_at', 'desc' );
    }


    // =======================================================================//
    // ! Model Methods                                                        //
    // =======================================================================//

    /**
     * Checks plan snapshot state.
     *
     * @return bool False if not snapshot
     */
    public function isSnapshot() : bool
    {
        if ($this->is_snapshot) {
            return true;
        }

        return false;
    }


    /**
     * Checks plan completion state.
     *
     * Queries the plan survey completion attribute
     *
     * @return bool  False if complete != 100
     */
    public function isComplete() : bool
    {
        return $this->survey->completion === 100;
    }


    /**
     * Sets the plan's final flag to given boolean value.
     *
     * @uses Plan::isComplete()
     *
     * @param bool $status  Boolean status
     * @param bool $strict  If true, set the final flag only to plans with completion attribute = 100
     *
     * @return bool  False if $status is not boolean
     */
    public function setFinalFlag($status, $strict = null) : bool
    {
        $is_complete = true;
        if ($strict !== null) {
            $is_complete = $this->isComplete();
        }

        if (\is_bool($status) && $is_complete) {
            $this->is_snapshot = $status;
            $this->save();
            return true;
        }

        return false;
    }


    /**
     * Sets snapshot status.
     *
     * @return bool
     */
    public function toSnapshot() : bool
    {
        $this->is_snapshot = true;
        $this->snapshot_at = Carbon::now();
        $this->save();

        return true;
    }


    /**
     * Creates a new plan with corresponding survey.
     *
     * Creates a new instance of Plan with the given $data array. Then creates a
     * instance of Survey. If $answer_data array is given (most probably called
     * from the snapshot action), the answers are copied to new instance. Otherwise, the default
     * values for the questions are copied.
     *
     * @todo: Have a look at events.
     *
     * @uses Survey::setDefaults()
     * @uses Survey::saveAnswers()
     * @param array $data  Data for new plan
     * @param array|null $answer_data  Optional existing answers for already existing survey (snapshot action).
     * @return bool
     */
    public static function createWithSurvey($data, $answer_data = null) : bool
    {
        /* Create a new plan instance */
        $plan = new self([
            'title' => $data['title'],
            'project_id' => $data['project_id'],
            'version' => $data['version']
        ]);

        $op = $plan->save();

        if ($op) {
            /* Create a new survey instance and attach plan to it */
            $survey = new Survey;
            $survey->plan()->associate($plan);
            $survey->template_id = $data['template_id'];
            $survey->save();

            if ($survey) {
                /* Depending on answer data, set answers or default values */
                if ($answer_data === null) {
                    $survey->setDefaults();
                } else {
                    $survey->saveAnswers($answer_data);
                }

                /* Fire plan create event */
                Event::fire(new PlanCreated($plan));

                return true;
            }
        }

        return false;
    }


    /**
     * Creates a snapshot of an existing plan with corresponding survey.
     *
     * Creates a new instance of Plan with the given $data array.
     * If $data includes a "clone_current" value, the existing answers of
     * the exiting plan are copied and associated with the new plan.
     *
     * @uses Answer::check()
     * @uses Plan::createWithSurvey()
     * @param array $data  Data of plan instance
     * @return bool
     */
    public function createSnapshot($data) : bool
    {
        $data['template_id'] = $this->survey->template_id;
        $answers = [];

        // Snapshot current plan
        $op = $this->toSnapshot();

        if ($op) {
            // Clone answers if clone_current is set
            if (isset($data['clone_current'])) {
                /* @var $questions Question[] */
                $questions = $this->survey->template->questions;
                foreach ($questions as $question) {
                    /* @var $answers Answer[] */
                    $answers = Answer::check($this->survey, $question);
                    if ($answers !== null) {
                        foreach ($answers as $answer) {
                            $answers[$question->id] = $answer->value;
                        }
                    }
                }

                self::createWithSurvey($data, $answers);
            }

            return true;
        }

        return false;
    }


    /**
     * Deletes a plan with corresponding survey.
     *
     * Simply deletes the plan. Deletes survey by relation / database cascading.
     *
     * @todo: Necessary?
     * @return bool
     * @throws \Exception
     */
    public function deleteWithSurvey() : bool
    {
        return $this->delete();
    }


    /**
     * Sends Email with export file to given recipient.
     *
     * @param array $data
     * @return bool
     */
    public function emailToRecipient($data) : bool
    {
        $plan = $this->find($data['id']);

        if ($plan) {
            $options = [
                'sender' => [
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email
                ],
                'recipient' => [
                    'name' => $data['name'],
                    'email' => $data['email']
                ],
                'msg' => $data['message'],
                'plan' => $plan,
                'attachment' => $plan->exportPlan()
            ];

            Mail::send(new PlanToRecipient($options));

            if (Mail::failures()) {
                return false;
            }

            return true;
        }

        return false;
    }


    /**
     * @todo
     *
     * @return PDF
     */
    public function exportPlan()
    {
        $plan = $this;
        $project = $plan->project;
        $survey = $plan->survey;
        $filename = $plan->project->identifier . ' - ' . $plan->title . '.pdf';

        $pdf = PDF::loadView('pdf.dmp',  compact('plan', 'project', 'survey'));

        if ($pdf) {
            $context = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed'=> TRUE
                ]
            ]);
            $pdf->getDomPDF()->setHttpContext($context);

            return $pdf->stream($filename);

            /* For debugging, switch the return with the following:
             * return view('pdf.dmp', compact('plan', 'project', 'survey'));
             */
        }

        return null;
    }


    /**
     * @todo Experimental, not in use
     *
     * @return string
     */
    public function getColoredCompletionRate()
    {
        $step = 2.55;
        $percentage = $this->survey->completion;
        $green = $percentage;
        $red = 100 - $green;
        return sprintf( '#%02X%02X00', round($red * $step), round($green * $step));
    }

    /**
     * @deprecated
     */
    public function getGateInfo()
    {
        //AppHelper::varDump(Gate::forUser(auth()->user())->allows('update-plan', $this));
    }
}
