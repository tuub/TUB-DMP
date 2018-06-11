<?php
declare(strict_types=1);

namespace App;

use App\Exceptions\ConfigException;
use App\Helpers\AppHelper;
use App\Library\Traits\Uuids;
use Baum\Node;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Project extends Node
{
    // =======================================================================//
    // ! Model Options                                                        //
    // =======================================================================//

    use Uuids;

    protected $table        = 'projects';
    public    $incrementing = false;
    protected $dates = [
        'created_at',
        'updated_at',
        'imported_at'
    ];
    protected $fillable = [
        'identifier',
        'parent_id',
        'user_id',
        'is_active',
        'contact_email',
        'data_source_id',
        'imported',
        'imported_at'
    ];
    protected $guarded = [
        'id',
        'parent_id',
        'lft',
        'rgt',
        'depth'
    ];
    protected $casts = [
        'id' => 'string',
        'parent_id' => 'string'
    ];

    // =======================================================================//
    // ! Model Relationships                                                  //
    // =======================================================================//


    /**
     * User relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Plan relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function plans()
    {
        return $this->hasMany(Plan::class)->orderBy('updated_at', 'desc');
    }


    /**
     * Plan relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function data_source()
    {
        return $this->belongsTo(DataSource::class);
    }


    /**
     * ProjectMetadata relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function metadata()
    {
        return $this->hasMany(ProjectMetadata::class);
    }



    /**
     * Returns email attribute.
     *
     * Since we have to take care of privacy issues, the display of email addresses
     * may be deactivated through .env configuration HIDE_EMAIL_ADDRESSES.
     *
     * @return string
     */
    public function getContactEmailAttribute()
    {
        if (array_key_exists('contact_email', $this->getAttributes()) && $this->attributes['contact_email'] !== null) {
            if (env('HIDE_EMAIL_ADDRESSES')) {
                return AppHelper::hideEmailAddress($this->attributes['contact_email']);
            } else {
                return $this->attributes['contact_email'];
            }
        }
   }


    // =======================================================================//
    // ! Model Methods                                                        //
    // =======================================================================//

    /**
     * Get metadatum for given identifier.
     *
     * Queries the relation and returns data and content type. Then calls formatter and returns
     * formatted collection.
     *
     * @uses ProjectMetadata::formatForOutput  To set the formatting for the returning collection.
     *
     * @param string $identifier  A metadata identifier
     *
     * @return Collection|null
     */
   public function getMetadata($identifier)
    {
        $data = null;
        $content_type = new ContentType;

        if ($this->metadata->count()) {

            /* @var $metadata ProjectMetadata[] */
            $metadata = $this->metadata;

            foreach ($metadata as $metadatum) {
                if ($metadatum->metadata_registry->identifier === $identifier) {
                    $data = collect($metadatum->content);
                    $content_type = $metadatum->metadata_registry->content_type;
                }
            }

            $data = ProjectMetadata::formatForOutput($data, $content_type);
        }

        return $data;
    }


    /**
     * Get metadata title for given identifier.
     *
     * For usage in labels.
     * If present, this queries the relation first. Otherwise uses language file.
     *
     * @todo Reinvestigate relation. Right now, it usually falls back to the language file.
     *
     * @param string $identifier  A metadata identifier
     *
     * @return string|null
     */
    public function getMetadataLabel($identifier) : ?string
    {
        /*
        if ($this->metadata->count()) {
            foreach ($this->metadata as $metadata) {
                if ($metadata->metadata_registry->identifier === $identifier) {
                    $data = $metadata->metadata_registry->title;
                }
            }
        } else {
        */
        return trans('project.metadata.' . $identifier);
    }



    /**
     * Get status string based on begin and end date.
     *
     * Checks for a project's metadata values begin & end.
     * If present, determines if the project is still running by date comparison.
     * Returns string from language file.
     *
     * @uses Project::getMetadata()
     *
     * @return string
     */
    public function getStatusAttribute() : ?string
    {
        $status = null;

        if ($this->getMetadata('begin')) {
            $date = $this->getMetadata('begin')->first();
            if ($date !== null) {
                if (Carbon::parse($date) > Carbon::now()) {
                    $status = trans('project.status.not_started');
                } else {
                    $status = trans('project.status.running');
                }
            }

            if ($this->getMetadata('end')) {
                $date = $this->getMetadata('end')->first();
                if ($date !== null) {
                    if (Carbon::parse($date) > Carbon::now()) {
                        $status = trans('project.status.running');
                    } else {
                        $status = trans('project.status.ended');
                    }
                }
            }
        } else {
            $status = trans('project.status.unknown');
        }

        return $status;
    }


    /**
     * Queries metadata registry id for given identifier.
     *
     * Looks in namespace "project".
     *
     * @uses MetadataRegistry
     *
     * @param string $identifier  Metadata identifier, e.g. 'title'
     *
     * @return string|null
     */
    public function getMetadataRegistryIdByIdentifier($identifier) : ?string
    {
        $data = MetadataRegistry::where([
            'namespace'  => 'project',
            'identifier' => $identifier
        ])->first()['id'];

        return $data;
    }


    /**
     * Updates the project with the given metadata.
     *
     * @uses ProjectMetadata::saveAll()
     * @used-by Project::importFromDataSource()
     * @param $data
     * @return bool
     */
    public function saveMetadata($data) : bool
    {
        if ($data) {
            ProjectMetadata::saveAll($this, $data);
            return true;
        }

        return false;
    }


    /**
     * Sets the given import status of the project
     *
     * @param bool $status
     * @return bool
     */
    public function setImportStatus($status = null) : bool
    {
        if (\is_bool($status)) {
            $this->imported = $status;
            $this->save();

            return true;
        }

        return false;
    }


    /**
     * Sets the import timestamp of the project to current datetime.
     *
     * @return bool
     */
    public function setImportTimestamp() : bool
    {
        $this->update(['imported_at' => Carbon::now()]);

        return true;
    }


    /**
     * Lookup any given project identifier in data sources.
     *
     * This loops and queries all data sources (e.g. Database) and its namespaces (e.g. Tables) for
     * the given identifier and returns an array with json-encoded return values.
     *
     * In Demo mode, the data source is always set to "odbc-demo" (see config/database.php)
     *
     * @todo Is not ready for other data sources or APIs than TUB's IVMC.
     *
     * @param string $identifier  A project identifier
     * @return array
     */
    public static function lookupDataSource($identifier) : array
    {
        /* @var $data_sources DataSource[] */
        $data_sources = DataSource::get();
        $external_data = [];

        /* Determine database connection and identifier */
        if (env('DEMO_MODE') || env('FAKE_DATASOURCE_IMPORT')) {
            $connection = 'odbc-demo';
            $identifier = '12345678';
        } else {
            $connection = 'odbc';
        }

        /* The loop */
        foreach ($data_sources as $data_source) {
            $namespaces = $data_source->namespaces()->get();
            foreach ($namespaces as $namespace) {
                $external_data[$namespace->name] = DB::connection($connection)->table($namespace->name)
                    ->where('Projekt_Nr', 'LIKE', $identifier)
                    ->get()->toJson();
            }
        }

        return $external_data;
    }


    /**
     * Validate current project identifier.
     *
     * Configuration from .env file: PROJECT_IDENTIFIER_PATTERN
     *
     * @return bool  False if not matching pattern or no config provided
     */
    public function hasValidIdentifier() : bool
    {
        return env('PROJECT_IDENTIFIER_PATTERN') &&
            preg_match(env('PROJECT_IDENTIFIER_PATTERN'), $this->identifier);
    }


    /**
     * Generate a project identifier.
     *
     * Configuration from .env file: PROJECT_IDENTIFIER_RANDOM_PREFIX, PROJECT_IDENTIFIER_RANDOM_LENGTH
     *
     * @todo: NULL return value would violate the database constraint for identifier
     *
     * @return string|null  The generated random identifier or null if no config provided.
     */
    public static function generateRandomIdentifier() : ?string
    {
        $identifier = null;

        try {
            if (env('PROJECT_IDENTIFIER_RANDOM_PREFIX') && env('PROJECT_IDENTIFIER_RANDOM_LENGTH')) {
                $identifier = env('PROJECT_IDENTIFIER_RANDOM_PREFIX') . implode('', array_map(function($value) {
                    return $value === 1 ? random_int(1, 9) : random_int(0, 9); }, range(1, env('PROJECT_IDENTIFIER_RANDOM_LENGTH'))));
            } else {
                throw new ConfigException('Missing config variables');
            }
        } catch (ConfigException $e) {
            $e->report();
            //$e->render();
        }

        return $identifier;
    }


    /**
     * Validate any given project identifier.
     *
     * Configuration from .env file: PROJECT_IDENTIFIER_PATTERN
     *
     * @since 2.0
     * @param string $identifier  A project identifier
     * @return bool  false if not matching pattern or no config provided
     */
    public static function isValidIdentifier($identifier) : bool
    {
        return env('PROJECT_IDENTIFIER_PATTERN') &&
            preg_match(env('PROJECT_IDENTIFIER_PATTERN'), $identifier);
    }


    /**
     * Approve pending project.
     *
     * Starts the data source import and sets the project active
     *
     * @since 2.0
     * @return bool
     */
    public function approve() : bool
    {
        $this->is_active = true;

        return $this->save();
    }


    /**
     * @todo Documentation
     *
     * @return bool
     */
    public function importFromDataSource()
    {
        if (env('DEMO_MODE') || env('FAKE_DATASOURCE_IMPORT')) {
            $connection = env('PROJECT_DEMO_CONNECTION');
            $this->data_source_id = DataSource::where('identifier', env('PROJECT_DEMO_DATASOURCE'))->first()->id;
        } else {
            $connection = env('ODBC_DRIVER');
        }

        if ($this->data_source && env('PROJECT_ALLOW_DATASOURCE_IMPORT')) {
            /* @var $namespaces DataSourceNamespace[] */
            $namespaces = $this->data_source->namespaces;
            /* @var $metadata_fields MetadataRegistry[] */
            $metadata_fields = MetadataRegistry::where('namespace', 'project')->get();

            foreach ($metadata_fields as $metadata_field) {

                $content_type = $metadata_field->content_type;
                $required = $content_type->structure;

                foreach ($namespaces as $namespace) {
                    /* @var $mappings DataSourceMapping[] */
                    $mappings = $this->data_source->mappings()
                        ->where('data_source_id', $this->data_source->id)
                        ->where('data_source_namespace_id', $namespace->id)
                        ->where('target_metadata_registry_id', $metadata_field->id)
                        ->get();

                    $i = 0;
                    $new_item = [];

                    /* In Demo Mode we always grab the example dataset */
                    if (env('DEMO_MODE') || env('FAKE_DATASOURCE_IMPORT')) {
                        $identifier = env('PROJECT_DEMO_IDENTIFIER');
                    } else {
                        $identifier = $this->identifier;
                    }

                    foreach ($mappings as $mapping) {
                        /* Get the external data by source */
                        /* @var $external_data Collection[] */
                        $external_data = DB::connection($connection)->table($namespace->name)
                            ->select($mapping->data_source_entity[0])
                            ->where('Projekt_Nr', 'LIKE', $identifier)
                            ->get();

                        /* Convert to array */
                        $external_data = $external_data->map(function ($x) { return (array)$x; })->toArray();

                        /* @var $target_content Collection[] */
                        $target_content = $mapping->target_content;

                        if ($content_type->identifier === 'person') {
                            $k = 0;
                            foreach ($external_data as $external_datum) {
                                foreach ($target_content as $target_content_key => $target_content_value) {
                                    if ($target_content_value === 'CONTENT') {
                                        $new_item[ $k ][ $target_content_key ] = $external_datum[ $mapping->data_source_entity[0] ];
                                    }
                                }
                                $k++;
                            }
                        } else {
                            foreach ($target_content as $target_content_key => $target_content_value) {
                                if ($target_content_value === 'CONTENT') {
                                    foreach ($external_data as $external_datum) {
                                        $target_content[ $target_content_key ] = $external_datum[ $mapping->data_source_entity[0] ];
                                        $target_content = array_filter($target_content);
                                        $new_item[ $i ] = $target_content;
                                        $i++;
                                    }
                                }
                            }
                        }
                    }


                    $new_full_item = [];

                    foreach ($new_item as $item) {
                        $item += array_diff_key($required, $item);
                        $new_full_item[] = $item;
                    }

                    if (\count($new_full_item) > 0) {

                        /* @todo: refactor call_user_func_array calls. */

                        //\Log::info('BEFORE');
                        //\Log::info($new_full_item);

                        switch ($content_type->identifier) {
                            case 'text_simple':
                                $new_full_item = \call_user_func_array('array_merge', $new_full_item);
                                break;
                            case 'organization':
                                $new_full_item = \call_user_func_array('array_merge', $new_full_item);
                                break;
                            case 'date':
                                $new_full_item = \call_user_func_array('array_merge', $new_full_item);
                                break;
                            default:
                                //$new_full_item = \call_user_func_array('array_merge', $new_full_item);
                                break;
                        }

                        /*
                        // Recursively iterate the array iterator
                        $new_full_item_obj = new \RecursiveIteratorIterator(
                            new \RecursiveArrayIterator($new_full_item)
                        );

                        // Copy the iterator into an array
                        $new_full_item = iterator_to_array($new_full_item_obj, false);
                        */

                        //\Log::info('AFTER');
                        //\Log::info($new_full_item);

                        $data = [
                            $metadata_field->identifier => $new_full_item
                        ];

                        $this->saveMetadata($data);
                    }
                }
            }

            $this->setImportStatus(true);
            $this->setImportTimestamp();
        }

        return true;
    }


    /**
     * Checks parent relation.
     *
     * @return bool  false if parent_id is null
     */
    public function hasParent() : bool
    {
        return $this->parent_id ? true : false;
    }


    /**
     * Gets parent relation.
     *
     * @return Model|null  The parent project or null if not found
     */
    public function getParent()
    {
        return $this->where('id', $this->parent_id)->first();
    }
}
