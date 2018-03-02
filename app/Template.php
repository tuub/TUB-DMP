<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;
use Webpatser\Uuid\Uuid;

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

    /**
     *
     * @author fab
     * @guru mri
     *
     * @param $new_section
     * @param $original
     * @param $copy
     */
    public static function copyKids($new_section, $original, $copy) {
        foreach($original->children as $original_child) {
            $node = $new_section->questions()->create($original_child->toArray());
            $node->template_id = $copy->template_id;
            $node->section_id = $copy->section_id;
            $node->parent_id = $copy->id;
            $node->save();
            self::copyKids($new_section, $original_child, $node);
        }
    }


    /**
     *
     * @author fab
     * @guru mri
     *
     * @return bool
     */
    public function copy()
    {
        $current_template = $this;
        $new_template = $current_template->replicate()->setRelations([]);

        if ($new_template) {
            $new_template->name .= ' - COPY (' . date('YmdHis') . ')';
            $new_template->is_active = 0;
            $new_template->push();

            foreach($current_template->sections as $current_section) {
                $new_section = $new_template->sections()->create($current_section->toArray());
                $next_parent_id = null;

                foreach ($current_section->questions()->orderBy('depth')->get() as $current_question) {
                    /* We start with the root */
                    if($current_question->isRoot()) {
                        /* We create a root question */
                        $root = $new_section->questions()->create($current_question->toArray());

                        /* We modify the root's attributes */
                        $root->template_id = $new_template->id;
                        $root->section_id = $new_section->id;
                        $root->parent_id = $next_parent_id;
                        // FIX ME:
                        // $root->template()->associate($new_template->id);

                        /* We save the root */
                        $root->save();

                        /* We query the children */
                        self::copyKids($new_template, $current_question, $root);
                    }
                }
            }
            return true;
        }

        return false;
    }

}
