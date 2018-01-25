<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class Template extends Model
{
    use Uuids;

    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'templates';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    /*
    public function questions()
    {
        return $this->hasManyThrough(Question::class, Section::class);
    }
    */

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public function copy()
    {
        $current_template = $this;
        $new_template = $current_template->replicate()->setRelations([]);

        if ($new_template) {
            $new_template->name .= ' - COPY (' . date('Ymdhis') . ')';
            $new_template->is_active = 0;
            $new_template->push();

            foreach($current_template->sections as $current_section) {
                $new_section = $new_template->sections()->create($current_section->toArray());
                foreach($current_section->questions as $current_question) {
                    $new_question = $new_section->questions()->create($current_question->toArray());
                    $new_question->template()->associate($new_template->id);
                    $new_question->save();
                }
            }

            return true;
        }

        return false;
    }

}
