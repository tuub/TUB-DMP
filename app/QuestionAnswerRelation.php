<?php

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;


/**
 * App\QuestionAnswerRelation
 *
 * @property integer $id
 * @property integer $plan_id
 * @property integer $user_id
 * @property integer $question_id
 * @property integer $text_answer_id
 * @property integer $option_answer_id
 * @property integer $range_answer_id
 * @property integer $list_answer_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Template[] $templates
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAnswerRelation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAnswerRelation wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAnswerRelation whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAnswerRelation whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAnswerRelation whereTextAnswerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAnswerRelation whereOptionAnswerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAnswerRelation whereRangeAnswerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAnswerRelation whereListAnswerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAnswerRelation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionAnswerRelation whereUpdatedAt($value)
 */
class QuestionAnswerRelation extends Model
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    public    $timestamps = true;
    protected $table      = 'question_answer_relations';


    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function templates() {
        return $this->hasMany( 'App\Template' );
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public static function getAnswer( Plan $plan, $question, $output = 'form', $convert_links = false ) {

        $option_input_value = [ ];

        $relation_results = QuestionAnswerRelation::where( 'question_id', '=', $question['id'] )
            ->where( 'plan_id', '=', $plan->id )
            ->where( 'user_id', '=', Auth::user()->id )
            ->get();

        // IF NO ANSWER IS PRESENT - RETURN NULL
        if ( $relation_results->isEmpty() ) {
            $input_value = null;
        }
        // IF ANSWER VALUE(S) IS/ARE PRESENT ...
        else {
            foreach ( $relation_results as $relation_result ) {
                // TEXT ANSWER
                if ( $relation_result->text_answer_id != null &&
                    $relation_result->option_answer_id == null &&
                    $relation_result->range_answer_id == null &&
                    $relation_result->list_answer_id == null
                ) {
                    $input_type = 'text';
                    $text_answer = TextAnswer::where( 'id', '=', $relation_result->text_answer_id )->first();

                    if ( count( $text_answer ) != 0 ) {
                        $text_answer = $text_answer->text;

                        if ( true === $convert_links ) {
                            $text_answer = autolink_email( autolink( $text_answer, 150 ) );
                        }
                        //$input_value[] = nl2br( $text_answer );
                        $input_value[] = $text_answer;

                    }
                    else {
                        $input_value[] = null;
                    }
                }

                // OPTION ANSWER
                if ( $relation_result->option_answer_id != null &&
                    $relation_result->text_answer_id == null &&
                    $relation_result->range_answer_id == null &&
                    $relation_result->list_answer_id == null
                ) {
                    $input_type = 'option';
                    $option_answers = OptionAnswer::where( 'id', '=', $relation_result->option_answer_id )->get();

                    foreach ( $option_answers as $option_answer ) {
                        $question_option = QuestionOption::where( 'id', '=',
                            $option_answer->question_option_id )->first();
                        $input_value[] = $question_option->id;
                    }
                }

                // RANGE ANSWER
                if ( $relation_result->range_answer_id != null &&
                    $relation_result->text_answer_id == null &&
                    $relation_result->option_answer_id == null &&
                    $relation_result->list_answer_id == null
                ) {
                    $input_type = 'range';
                    $range_answers = RangeAnswer::where( 'id', '=', $relation_result->range_answer_id )->get();

                    foreach ( $range_answers as $range_answer ) {
                        $input_value[] = $range_answer->alpha;
                        $input_value[] = $range_answer->omega;
                    }
                }

                // LIST ANSWER
                if ( $relation_result->list_answer_id != null &&
                    $relation_result->range_answer_id == null &&
                    $relation_result->text_answer_id == null &&
                    $relation_result->option_answer_id == null
                ) {
                    $input_type = 'list';
                    $list_answers = ListAnswer::where( 'id', '=', $relation_result->list_answer_id )->get();
                    foreach ( $list_answers as $list_answer ) {
                        $input_value[] = $list_answer->text;
                    }
                }

            }

            $response = "";

            switch ( $output ) {
                case 'form':
                    $response = $input_value;
                    break;
                case 'html':
                    if ( is_array( $input_value ) ) {
                        if ( $question['prepend'] ) {
                            $response .= '<span class="answer-prepend">' . $question['prepend'] . '</span>';
                            $response .= '&nbsp;';
                        }

                        switch ( $input_type ) {
                            case 'option':
                                foreach ( $input_value as $option_id ) {
                                    $option_data = QuestionOption::getOptionText( $option_id );
                                    if ( !is_null( $option_data ) ) {
                                        $response .= '<span class="answer-text">' . $option_data . '</span><br/>';
                                    }
                                }
                                break;
                            case 'range':
                                for ( $i = 0; $i < count( $input_value ); $i++ ) {
                                    if ( !is_null( $input_value[ $i ] ) ) {
                                        $response .= $input_value[ $i ];
                                        if ( key( $input_value ) == $i ) {
                                            $response .= ' - ';
                                        }
                                    }
                                }
                                break;

                            case 'list':
                                for ( $i = 0; $i < count( $input_value ); $i++ ) {
                                    if ( !is_null( $input_value[ $i ] ) ) {
                                        $response .= $input_value[ $i ];
                                        if ( $i < count( $input_value ) ) {
                                            $response .= '<br/>';
                                        }
                                    }
                                }
                                break;

                            default:
                                $response .= nl2br( $input_value[0] );
                                break;
                        }

                        if ( $question['append'] ) {
                            $response .= '&nbsp;';
                            $response .= '<span class="answer-append">' . $question['append'] . '</span>';
                        }

                    }
                    else {
                        $response = ' - ';
                    }
                    break;
                case 'text':
                    if ( is_array( $input_value ) ) {
                        if ( $question['prepend'] ) {
                            $response .= $question['prepend'];
                            $response .= " ";
                        }

                        switch ( $input_type ) {
                            case 'option':
                                foreach ( $input_value as $option_id ) {
                                    $option_data = QuestionOption::getOptionText( $option_id );
                                    if ( !is_null( $option_data ) ) {
                                        $response .= $option_data . "\n";
                                    }
                                }
                                break;
                            case 'range':
                                for ( $i = 0; $i < count( $input_value ); $i++ ) {
                                    if ( !is_null( $input_value[ $i ] ) ) {
                                        $response .= $input_value[ $i ];
                                        if ( key( $input_value ) == $i ) {
                                            $response .= " - ";
                                        }
                                    }
                                }
                                break;
                            case 'list':
                                for ( $i = 0; $i < count( $input_value ); $i++ ) {
                                    if ( !is_null( $input_value[ $i ] ) ) {
                                        $response .= $input_value[ $i ];
                                        if ( $i < count( $input_value ) ) {
                                            $response .= "\n";
                                        }
                                    }
                                }
                                break;

                            default:
                                $response .= $input_value[0];
                                break;
                        }

                        if ( $question['append'] ) {
                            $response .= " ";
                            $response .= $question['append'];
                        }

                    }
                    else {
                        $response = " - ";
                    }
                    break;
                default:
                    $response = $input_value;
                    break;
            };

            return $response;
        }
    }

    public static function copyAllToNextVersion( Plan $plan, $next_version ) {
        $new_plan_id = Plan::getPlanID( $plan->project_number, $next_version );

        $relations = QuestionAnswerRelation::where( 'plan_id', '=', $plan->id )
            ->where( 'user_id', '=', \Auth::user()->id )
            ->get();

        foreach ( $relations as $relation ) {
            if ( !empty( $relation->text_answer_id ) ) {
                $answer = TextAnswer::find( $relation->text_answer_id )->replicate();
            }
            if ( !empty( $relation->option_answer_id ) ) {
                $answer = OptionAnswer::find( $relation->option_answer_id )->replicate();
            }
            if ( !empty( $relation->range_answer_id ) ) {
                $answer = RangeAnswer::find( $relation->range_answer_id )->replicate();
            }
            if ( !empty( $relation->list_answer_id ) ) {
                $answer = ListAnswer::find( $relation->list_answer_id )->replicate();
            }

            $answer->plan_id = $new_plan_id;
            $answer->save();

            $relation_copy = $relation->replicate();
            $relation_copy->plan_id = $new_plan_id;
            $relation_copy->save();
        }

        return true;
    }
}