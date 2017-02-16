<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Requests\VersionPlanRequest;
use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Http\Requests\EmailPlanRequest;

use Auth;
use Carbon\Carbon;
use Storage;
use Exporters;
use Mail;

class Plan extends Model
{
    public $timestamps = true;
    protected $table = 'plans';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['title','project_id','version','template_id','is_active','is_final'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function template()
    {
        return $this->belongsTo('App\Template');
    }


    /**
     * Get all plans for the authenticated user
     * To-DO: maybe rename to all()
     *
     * @return mixed
     */
    public static function getPlans()
    {
        /* 27.04.2016: Reduced Query Number via Eager Loading */
        $plans = Plan::with('template','project')
            // See Constraints: https://laravel.com/docs/5.1/eloquent-relationships#querying-relations
            //->where( 'user_id', Auth::user()->id )
            ->orderBy( 'updated_at', 'desc' )
            ->get();
        return $plans;
    }


    /**
     * @param $project_number
     * @param $version
     * @param $user_id
     * @return mixed
     */
    public static function getByCredentials( $project_number, $version, $user_id )
    {
        if ( is_null( $project_number ) || is_null( $version ) ) {
            return null;
        }
        $query = Plan::where( 'project_number', $project_number )->where( 'version', $version );
        if ( Auth::user()->is_admin === 0 ) {
            $query->where( 'user_id', $user_id );
        }
        $plan = $query->first();
        if ( $plan ) {
            return $plan;
        }
        return null;
    }


    /**
     * @return int
     */
    public function getQuestionCount()
    {
        $count = $this->template->questions()->active()->mandatory()->count();
        return $count;
    }


    /**
     * @return mixed
     */
    public function getMandatoryQuestions()
    {
        return $this->template->questions()->active()->mandatory()->get();
    }

    /**
     * @return int
     */
    public function getAnswerCount()
    {
        $counter = [];
        foreach( $this->getMandatoryQuestions() as $question ) {
            /* See: http://stackoverflow.com/questions/28651727/laravel-eloquent-distinct-and-count-not-working-properly-together */
            /* Does not work */ //$counter[] = Answer::where('question_id', $question->id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->groupBy( 'question_id' )->count();
            /* Works as well */ //$counter[] = count(Answer::where('question_id', $question->id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->groupby('question_id')->distinct()->get());
            $counter[] = Answer::where('question_id', $question->id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->distinct('question_id')->count('question_id');
        }
        $count = array_sum( $counter );
        return $count;
    }


    /**
     * @return int
     */
    public function getQuestionAnswerPercentage()
    {
        return round( ( $this->getAnswerCount() / $this->getQuestionCount() ) * 100 );
    }


    /**
     * @return string
     */
    public function getColoredQuestionAnswerPercentage()
    {
        $step = 2.55;
        $percentage = $this->getQuestionAnswerPercentage();
        $green = $percentage;
        $red = 100 - $green;
        $color = sprintf( '#%02X%02X00', round($red * $step), round($green * $step));
        return $color;
    }


    /**
     * @return bool
     */
    public function isComplete() {
        if( $this->getQuestionAnswerPercentage() == 100 ) {
            return true;
        }
        return false;
    }


    /**
     * @return bool
     */
    public function isFinal() {
        if( $this->is_final ) {
            return true;
        }
        return false;
    }


    /**
     * @return bool
     */
    public function setDefaultValues()
    {
        foreach( $this->template->questions as $question )
        {
            $question->setDefaultValue( $this );
        }
        $this->touch();
        return true;
    }


    /**
     * @param bool $status
     * @return bool
     */
    public function setFinalFlag( $status )
    {
        if( is_bool($status) ) {
            $this->is_final = $status;
            $this->save();
            return true;
        }
        /* Uncomment if you want to finalize only 100% completed plans */
        /*
        if( $this->isComplete() ) {
            if( is_bool($status) ) {
                $this->is_final = $status;
                $this->save();
                return true;
            }
            return false;
        }
        */
        return false;
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
     * @param VersionPlanRequest $request
     *
     * @return bool
     */
    public function createVersion( VersionPlanRequest $request )
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
                'is_prefilled'   => 1
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

    public function exportPlan($project_number, $version, $format, $download)
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
    public function emailPlan( EmailPlanRequest $request )
    {
        $sender['name'] = Auth::user()->real_name;
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
                }
            );
            return true;
        };
        return false;
    }


    /**
     * @param int $status
     *
     * @return bool
     */
    public function setPrefillStatus( $status = 1 ) {
        if ( is_bool( $status ) ) {
            $this->update( [ 'is_prefilled' => $status ] );
            return true;
        }
        return false;
    }


    /**
     * @return bool
     */
    public function setPrefillTimestamps() {
        $this->update( [ 'prefilled_at' => Carbon::now() ] );
        return true;
    }


    /**
     * @param $project_number
     * @param $version
     * @return bool
     */
    public static function hasVersion( $project_number, $version ) {
        $result = Plan::where( 'project_number', $project_number )->where( 'version', $version )->first();
        if ( $result ) {
            return true;
        }
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

    
    public function getVersion() {
        return $this->version;
    }
    


    /**
     * @return mixed
     */
    public function getProjectStage() {
        /* TODO: This is so stupid! */
        $question_id = 104;
        return Answer::where('question_id', $question_id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->pluck('text');
    }


    /**
     * @return string
     */
    public function getProjectNumber() {
        return $this->project_number;
    }


    /**
     * @return mixed
     */
    public function getTitle() {
        /* TODO: This is so stupid! */
        $question_id = 102;
        return Answer::where('question_id', $question_id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->pluck('value');
    }


    /**
     * @return mixed
     */
    public function getInvestigators() {
        /* TODO: This is so stupid! */
        $names = [];
        $question_ids = [107,109];
        foreach( $question_ids as $question_id ) {
            $name = Answer::where('question_id', $question_id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->pluck('value');
            if( $name ) {
                $names[] = $name;
            }
        }
        return implode(', ', $names );
    }


    /**
     * @return mixed
     */
    public function getLeadOrganization() {
        /* TODO: This is so stupid! */
        $question_id = 115;
        return Answer::where('question_id', $question_id)->where('plan_id', $this->id)->where('user_id', $this->user_id)->pluck('value');
    }


}
