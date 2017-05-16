<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Requests\SnapshotPlanRequest;
//use App\Http\Requests\CreatePlanRequest;
//use App\Http\Requests\UpdatePlanRequest;
use App\Http\Requests\EmailPlanRequest;

use Illuminate\Support\Facades\Event;
use App\Events\PlanCreated;

use Carbon\Carbon;
//use Storage;
use Exporters;
use Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Plan extends Model
{
    public $timestamps  = true;
    protected $table    = 'plans';
    protected $dates    = ['created_at', 'updated_at', 'snapshot_at'];
    protected $fillable = ['title', 'project_id', 'version', 'template_id', 'is_active', 'is_snapshot', 'snapshot_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function survey()
    {
        return $this->hasOne(Survey::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy( 'updated_at', 'desc' );
    }




    /**
     * @param $project_number
     * @param $version
     * @param $user_id
     * @return mixed
     */
    /*
    public static function getByCredentials( $project_number, $version, $user_id )
    {
        if (is_null($project_number) || is_null($version)) {
            return null;
        }

        $query = Plan::where( 'project_number', $project_number )->where( 'version', $version );

        if (auth()->user()->is_admin === 0) {
            $query->where( 'user_id', $user_id );
        }

        $plan = $query->first();

        if ($plan) {
            return $plan;
        }

        return null;
    }
    */


    public function isComplete() {
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

        $header_html = (string) view('pdf.header');
        $footer = $plan->project->identifier . ' - ' . $plan->title . ', [page]';

        $pdf = PDF::loadView('pdf.dmp',  compact('plan', 'project', 'survey'));
        return $pdf->stream($plan->project->identifier . ' - ' . $plan->title . '.pdf');
        //return view('pdf.dmp', compact('plan', 'project', 'survey'));



        /*
        $pdf = PDF::loadView('pdf.dmp', compact('plan', 'project', 'survey'));
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('page-size', 'A4');
        $pdf->setOption('margin-top', '10mm');
        $pdf->setOption('margin-bottom', '20mm');
        $pdf->setOption('margin-left', '20mm');
        $pdf->setOption('margin-right', '20mm');
        $pdf->setOption('header-html', $header_html);
        //$pdf->setOption('footer-font-size', '8');
        //$pdf->setOption('footer-right', $footer);
        return $pdf->stream();
        //return view('pdf.dmp', compact('plan', 'project', 'survey'));
        */
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
     * @param $table
     * @param $connection
     * @return bool
     */
    public function setExternalValues( $table, $connection ) {
        switch($this->datasource) {
            case 'ivmc':
                IvmcMapping::setFields( $this, $table, $connection );
                break;
            default:
                break;
        }
        return true;
    }


    /**
     * @param CreatePlanRequest $request
     * @return bool
     */
    public static function createPlan( CreatePlanRequest $request )
    {
        $plan = self::getByCredentials( $request['project_number'], $request['version'], Auth::user()->id );
        if( is_null($plan) ) {
            $plan = new Plan;
            $plan->template_id = $request->get( 'plan_template' );
            $plan->user_id = $request->get( 'plan_owner' );
            $plan->project_number = $request->get( 'project_number' );
            $plan->version = $request->get( 'version' );
            $plan->datasource = ( $request->get( 'datasource' ) == '' ) ? null : $request->get( 'datasource' );
            if ( $plan->save() ) {
                return true;
            }
        }
        return false;
    }


    /**
     * @param UpdatePlanRequest $request
     *
     * @return bool
     */
    public static function updatePlan( UpdatePlanRequest $request )
    {
        $plan = self::getByCredentials( $request['project_number'], $request['version'], Auth::user()->id );
        if( !is_null($plan) ) {
            if ( $request->ajax() ) {
                parse_str( html_entity_decode( $request->get( 'input_data' ) ), $answer_data );
            } else {
                $answer_data = $request->all();
            }
            foreach ( $answer_data as $key => $values ) {
                if(is_array($values)) {
                    $question = Question::find($key);
                    Answer::setAnswer($plan, $question, Auth::user(), $values);
                }
            }
            $plan->touch();
            return true;
        }
        return false;
    }


    /**
     * @param SnapshotPlanRequest $request
     *
     * @return bool
     */
    public function createVersion( SnapshotPlanRequest $request )
    {
        $current_version = $request->get( 'version' );
        $new_version = $current_version + 1;
        $current_plan = self::getByCredentials($request->get('project_number'), $request->get('version'), Auth::user()->id);

        if ( !$current_plan->hasVersion( $current_plan->project_number, $new_version ) ) {
            $request = new CreatePlanRequest([
                'plan_template'  => $current_plan->template_id,
                'plan_owner'     => Auth::user()->id,
                'project_number' => $current_plan->project_number,
                'version'        => $new_version,
                'datasource'     => null,
                'imported'   => 1
            ]);
            if( Plan::createPlan( $request ) ) {
                $new_plan = self::getByCredentials( $current_plan->project_number, $new_version, Auth::user()->id );
                foreach ( $new_plan->template->questions as $question ) {
                    $answers = Answer::getAnswerObject( $current_plan, $question, Auth::user() );
                    foreach ( $answers as $answer ) {
                        $answer->copyToPlan( $new_plan );
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function exportPlan2($project_number, $version, $format, $download)
    {
        $plan = self::getByCredentials( $project_number, $version, Auth::user()->id );
        if( !is_null($plan) ) {
            if ( !is_null( $format ) ) {
                switch ( $format ) {
                    case 'html':
                        return Exporters::getHTML( $plan, $download );
                        break;
                    case 'pdf':
                        return Exporters::getPDF( $plan, $download );
                        break;
                    default:
                        return null;
                        break;
                }
            }
        }
        return false;
    }


    /**
     * @param EmailPlanRequest $request
     *
     * @return bool
     */
    public function emailoPlan( EmailPlanRequest $request )
    {
        $sender['name'] = Auth::user()->name;
        $sender['email'] = Auth::user()->email;
        $recipient['name'] = $request->get('name');
        $recipient['email'] = $request->get('email');
        $plan = self::getByCredentials($request->get('project_number'), $request->get('version'), Auth::user()->id);

        if( !is_null($plan) ) {
            $pdf = self::exportPlan($plan->project_number, $plan->version, 'pdf', false);
            $pdf_filename = 'DMP_for_TUB_Project_' . $plan->project_number . '-' . $plan->version . '_' . $plan->updated_at->format( 'Ymd' ) . '.pdf';
            Mail::send(['text' => 'emails.plan'], ['plan' => $plan, 'recipient' => $recipient ],
                function($message) use ($plan, $sender, $recipient, $pdf, $pdf_filename) {
                    $subject = 'Your Data Management Plan for TUB project ' . $plan->project_number . ' / Version ' . $plan->version;
                    $message->from(env('SERVER_MAIL_ADDRESS', 'server@localhost'), env('SERVER_NAME', 'TUB-DMP'));
                    if ($recipient['name']) {
                        $message->to($recipient['email'], $recipient['name'])->subject($subject);
                    } else {
                        $message->to($recipient['email'])->subject($subject);
                    }
                    $message->replyTo($sender['email'], $sender['name']);
                    $message->attachData($pdf, $pdf_filename);
                });
            return true;
        };
        return false;
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
