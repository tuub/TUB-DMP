<?php

namespace App;

use Illuminate\Support\Facades\Auth;

/**
 * App\IvmcMapping
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $source
 * @property string $field
 * @property integer $field_type
 * @property integer $display_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcMapping whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcMapping whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcMapping whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcMapping whereField($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcMapping whereFieldType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcMapping whereDisplayOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcMapping whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcMapping whereUpdatedAt($value)
 */
class IvmcMapping extends \Eloquent
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    public    $timestamps = true;
    protected $table      = 'ivmc_mappings';

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public static function getTables()
    {
        $result = IvmcMapping::distinct()->select( 'source' )->get( 'source' )->toArray();
        foreach ( $result as $value ) {
            $tables[] = $value['source'];
        }
        return $tables;
    }

    public static function checkField( $question_id )
    {
        $result = IvmcMapping::where( 'question_id', $question_id )->get();
        if( $result->count() > 0 ) {
            return $result;
        } else {
            return null;
        }
    }

    public static function setFields( Plan $plan, $table, $connection )
    {
        $questions = $plan->template->questions;
        $matrix = [];

        foreach( $questions as $question ) {
            if( is_null(Answer::check($question, $plan)) ) {
                $mappings = IvmcMapping::checkField( $question->id );
                if ( $mappings ) {
                    foreach ( $mappings as $mapping ) {
                        $query = "select " . $mapping->field . " from " . $mapping->source . " where Projekt_Nr = '" . $plan->project_number . "'";
                        $result = odbc_exec( $connection, $query );
                        while ( $row = odbc_fetch_array( $result ) ) {
                            foreach ( $row as $field => $value ) {
                                if ( !is_null( $value ) ) {
                                    $matrix[ $question->id ]['type'] = IvmcFieldType::getName( $mapping->field_type );
                                    $matrix[ $question->id ]['values'][] = [
                                        'value' => $value,
                                        'order' => $mapping->display_order
                                    ];
                                    for ( $i = 0; $i < count( $matrix[ $question->id ]['values'] ); $i++ ) {
                                        usort( $matrix[ $question->id ]['values'], function ( $a, $b ) {
                                            return $a['order'] - $b['order'];
                                        } );
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        foreach( $matrix as $question_id => $params ) {
            switch ( $params['type'] ) {
                case 'date_range':
                    foreach ( $params['values'] as $param => $item ) {
                        $values[] = trim($item['value']);
                    }
                    $date_formatter = function($value) { return date("Y/m/d", strtotime($value)); };
                    $input_answer = array_map($date_formatter, $values);
                    break;
                case 'personal_name':
                    foreach ( $params['values'] as $param => $item ) {
                        $values[] = trim($item['value']);
                    }
                    $input_answer[] = implode( ' ', array_filter($values) );
                    break;
                case 'multiple_fields':
                    foreach ( $params['values'] as $param => $item ) {
                        $values[] = trim($item['value']);
                    }
                    $input_answer = array_unique(array_filter($values));
                    break;
                case 'item_list':
                    foreach ( $params['values'] as $param => $item ) {
                        $values[] = trim($item['value']);
                    }
                    $input_answer = array_unique(array_filter($values));
                    break;
                case 'name_list':
                    foreach ( $params['values'] as $param => $item ) {
                        $values[] = trim($item['value']);
                    }
                    $items[] = array_unique(array_filter($values));
                    foreach ( $items as $item ) {
                        $input_answer[] = implode( ' ', array_filter($item) );
                    }
                    break;
                default:
                    foreach ( $params['values'] as $param => $item ) {
                        $values[] = trim($item['value']);
                    }
                    $input_answer = array_unique(array_filter($values));
                    break;
            }

            if ( is_array( $input_answer ) && count( $input_answer ) > 0 ) {
                $this_question = Question::find( $question_id );
                $this_user = User::find( $plan->user_id );
                Answer::setAnswer( $plan, $this_question, $this_user, $input_answer );
            }
            unset( $values );
            unset( $input_answer );
        }
        return true;
    }
}
