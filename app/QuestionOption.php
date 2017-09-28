<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class QuestionOption extends Model
{
    use Uuids;

    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'question_options';
    public $incrementing = false;
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public static function exists( $option_id )
    {
        $exists = QuestionOption::where('id', '=', $option_id)->exists();
        return $exists;
    }

    public static function getOptionText( $option_id )
    {
        $option = QuestionOption::where( 'id', '=', $option_id )->first();
        if( $option )
        {
            return $option->text;
        }
        else
        {
            return null;
        }
    }

    public static function getDefaultValue( $question )
    {
        $default_option = QuestionOption::where( 'question_id', '=', $question['id'] )->where( 'default', '=', 1 )->first();

        if( $default_option )
        {
            return $default_option->id;
        }
        else
        {
            return null;
        }
    }

}
