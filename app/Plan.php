<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Requests\SnapshotPlanRequest;
use App\Http\Requests\EmailPlanRequest;

use Illuminate\Support\Facades\Event;
use App\Events\PlanCreated;

use Carbon\Carbon;
use Exporters;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Library\Traits\Uuids;

class Plan extends Model
{
    use Uuids;

    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    public $timestamps  = true;
    public $incrementing = false;
    protected $table    = 'plans';
    protected $dates    = ['created_at', 'updated_at', 'snapshot_at'];
    protected $fillable = ['title', 'project_id', 'version', 'template_id', 'is_active', 'is_snapshot', 'snapshot_at'];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function survey()
    {
        return $this->hasOne(Survey::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeOrdered($query)
    {
        return $query->orderBy( 'updated_at', 'desc' );
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public function isComplete()
    {
        if ($this->survey->completion == 100) {
            return true;
        }

        return false;
    }


    public function isSnapshot()
    {
        if ($this->is_snapshot) {
            return true;
        }

        return false;
    }


    public function setFinalFlag($status)
    {
        if (is_bool($status)) {
            $this->is_snapshot = $status;
            $this->save();
            return true;
        }

        // Use this if you want to finalize only 100% completed plans */
        /*
        if ($this->isComplete())
        {
            if (is_bool($status))
            {
                $this->is_snapshot = $status;
                $this->save();
                return true;
            }

            return false;
        }
        */

        return false;
    }


    public function getGateInfo()
    {
        \AppHelper::varDump(Gate::forUser(auth()->user())->allows('update-plan', $this));
    }


    public function createSnapshot(Plan $plan)
    {
        $plan->is_snapshot = true;
        $plan->snapshot_at = Carbon::now();
        $plan->save();
        return true;
    }

    public function createWithSurvey($title, $project_id, $version, $template_id, $answer_data = null)
    {
        /* Create a new plan instance */
        $plan = $this->create([
            'title' => $title,
            'project_id' => $project_id,
            'version' => $version,
        ]);

        if ($plan) {
            /* Create a new survey instance and attach plan to it */
            $survey = new Survey;
            $survey->plan()->associate($plan);
            $survey->template_id = $template_id;
            $survey->save();

            if ($survey) {
                /* Depending on answer data, set answers or default values */
                if (is_null($answer_data)) {
                    $survey->setDefaults();
                } else {
                    $survey->saveAnswers($answer_data);
                }

                /* Fire plan create event */
                Event::fire(new PlanCreated($plan));

                return true;
            }
        } else {
            throw new NotFoundHttpException;
        }
    }

    public function deleteWithSurvey($data)
    {
        $plan = $this->find($data['id']);
        $plan->delete();

        return true;
    }


    public function createNextVersion($data)
    {
        $current_plan = $this->find($data['id']);
        $answers = null;

        if ($this->createSnapshot($current_plan)) {
            if (isset($data['clone_current'])) {
                $cloned_answers = [];

                foreach ($current_plan->survey->template->questions as $question) {
                    foreach (Answer::check($current_plan->survey, $question) as $answer) {
                        $cloned_answers[$question->id] = $answer->value;
                    }
                }
                $answers = $cloned_answers;

                $this->createWithSurvey($data['title'], $data['project_id'], $data['version'], $current_plan->survey->template_id, $answers);
            }

            return true;
        }

        return false;
    }


    public function emailToRecipient($data)
    {
        $sender['name'] = auth()->user()->name;
        $sender['email'] = auth()->user()->email;
        $sender['message'] = $data['message'];
        $recipient['name'] = $data['name'];
        $recipient['email'] = $data['email'];

        $plan = $this->findOrFail($data['id']);

        if ($plan) {
            $project_id = null;
            $subject = 'Data Management Plan "' . $plan->title . '"';

            if ($plan->project->id) {
                $project_id = $plan->project->identifier;
                $subject .= ' for project ' . $project_id;
            }

            $subject .= ' / Version ' . $plan->version;

            $pdf = $plan->exportPlan();
            $pdf_filename = $plan->project->identifier . '_' . str_replace(' ', '', $plan->title) . '-' . $plan->version . '_' . $plan->updated_at->format( 'Ymd' ) . '.pdf';

            Mail::send(['text' => 'emails.plan'], ['plan' => $plan, 'recipient' => $recipient, 'sender' => $sender ],
                function($email) use ($sender, $recipient, $subject, $pdf, $pdf_filename)
                {
                    $email->from(env('SERVER_MAIL_ADDRESS', 'server@localhost'), env('SERVER_NAME', 'TUB-DMP'));
                    if ($recipient['name']) {
                        $email->to($recipient['email'], $recipient['name']);
                    } else {
                        $email->to($recipient['email']);
                    }
                    $email->subject($subject);
                    $email->replyTo($sender['email'], $sender['name']);
                    $email->attachData($pdf, $pdf_filename);
                }
            );

            if (Mail::failures()) {
                return false;
            }

            return true;

        } else {
            throw new NotFoundHttpException;
        }
    }


    public function exportPlan()
    {
        $plan = $this;
        $project = $plan->project;
        $survey = $plan->survey;
        $filename = $plan->project->identifier . ' - ' . $plan->title . '.pdf';

        $header_html = (string) view('pdf.header');
        $footer = $plan->project->identifier . ' - ' . $plan->title . ', [page]';

        $pdf = PDF::loadView('pdf.dmp',  compact('plan', 'project', 'survey'));

        if ($pdf) {
            return $pdf->stream($filename);
            //return view('pdf.dmp', compact('plan', 'project', 'survey'));
        }
        throw new NotFoundHttpException;
    }


    /* TODO: Experimental, not in use */
    public function getColoredCompletionRate()
    {
        $step = 2.55;
        $percentage = $this->survey->completion;
        $green = $percentage;
        $red = 100 - $green;
        $color = sprintf( '#%02X%02X00', round($red * $step), round($green * $step));
        return $color;
    }


    /**
     * TO-DO!
     *
     * @param $filename
     * @param $pdf
     * @return bool
     */
    public function saveToDisk( $filename, $pdf ) {
        $storage_path = env( 'PDF_STORAGE_PATH', public_path() . '/plan/' );
        if( Storage::put( $storage_path . $filename, 'foo') ) {
            //\Log::info( $storage_path );
            //\Log::info( 'saved' );
            return true;
        };
        return false;
    }
}
