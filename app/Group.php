<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class Group extends Model
{
    use Uuids;

    public $incrementing = false;
    /**
     * Determine need for soft deletes in the database.
     *
     * @var bool
     */
    protected $softDelete = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

    /**
     * Determine the need for created_at and updated_at timestamps.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * These values are allowed to be used in mass
     * assignments.
     *
     * @var type
     */
    protected $fillable = array('name');

    /**
     * These values are hidden when output.
     *
     * @var type
     */
    protected $hidden = array('pivot');

    /**
     * Rules for editing and adding data
     * @return array rules
     */
    public static function rules()
    {
        return $rules = array();
    }

    /**
     * Relation to the User model
     * @return Eloquent relation
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
