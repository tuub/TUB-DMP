<?php

// TODO: CLEANUP!!! GET THOSE EAGER LOADED RELATIONS RUNNING!

namespace App;

use Baum\Node;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Project extends Node
{
    protected $table      = 'projects';
    public    $timestamps = true;
    protected $dates      = [
        'created_at',
        'updated_at',
        'imported_at'
    ];
    protected $fillable   = [
        'identifier',
        'parent_id',
        'user_id',
        'data_source_id',
        'imported',
        'imported_at'
    ];
    protected $guarded    = [
        'id',
        'parent_id',
        'lft',
        'rgt',
        'depth'
    ];

    /* Nested Sets */
    protected $parentColumn = 'parent_id';
    protected $leftColumn   = 'lft';
    protected $rightColumn  = 'rgt';
    protected $depthColumn  = 'depth';
    protected $orderColumn  = null;
    protected $scoped       = [];

    //////////////////////////////////////////////////////////////////////////////
    //
    // Baum makes available two model events to application developers:
    //
    // 1. `moving`: fired *before* the a node movement operation is performed.
    //
    // 2. `moved`: fired *after* a node movement operation has been performed.
    //
    // In the same way as Eloquent's model events, returning false from the
    // `moving` event handler will halt the operation.
    //
    // Please refer the Laravel documentation for further instructions on how
    // to hook your own callbacks/observers into this events:
    // http://laravel.com/docs/5.0/eloquent#model-events

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @return mixed
     */
    public function plans()
    {
        return $this->hasMany(Plan::class)->orderBy('updated_at', 'desc');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function data_source()
    {
        return $this->belongsTo(DataSource::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metadata()
    {
        return $this->hasMany(ProjectMetadata::class);
    }


    /**
     * @param $query
     * @param $flag
     *
     * @return mixed
     */
    public function scopeIsPrefilled($query, $flag)
    {
        return $query->where('is_prefilled', $flag);
    }


    /**
     * @param String $attribute
     *
     * @return Collection|null
     */
    public function getMetadata($attribute)
    {
        $data = null;
        $content_type = new ContentType();

        if ($this->metadata->count()) {
            foreach ($this->metadata as $metadata) {
                if ($metadata->metadata_registry->identifier == $attribute) {
                    $data = collect($metadata->content);
                    $content_type = $metadata->metadata_registry->content_type;
                }
            }

            $data = ProjectMetadata::formatForOutput($data, $content_type);
        }

        return $data;
    }


    /**
     * @param String $attribute
     *
     * @return Collection
     */
    public function getMetadataLabel($attribute)
    {
        $data = null;
        if ($this->metadata->count()) {
            foreach ($this->metadata as $metadata) {
                if ($metadata->metadata_registry->identifier == $attribute) {
                    $data = $metadata->metadata_registry->title;
                }
            }
        } else {
            $data = trans('project.metadata.' . $attribute);
        }

        return trans('project.metadata.' . $attribute);
    }


    /**
     * Renders a status string based on begin and end date.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        if ($this->getMetadata('begin') && $this->getMetadata('begin')->count()) {
            if (Carbon::parse($this->getMetadata('begin')->first()) > (Carbon::now())) {
                $status = 'Not started';
            } else {
                $status = 'Running';
            }

            if ($this->getMetadata('end') && $this->getMetadata('end')->count()) {
                if (Carbon::parse($this->getMetadata('end')->first()) > (Carbon::now())) {
                    $status = 'Running';
                } else {
                    $status = 'Ended';
                }
            }
        } else {
            $status = 'Unknown';
        }

        return $status;
    }


    /**
     * @param String $attribute
     *
     * @return Collection
     */
    public function getMetadataRegistryIdByIdentifier($identifier)
    {
        $data = null;

        /*
        if ($this->metadata->count()) {
            foreach ($this->metadata as $metadata) {
                if ($metadata->metadata_registry->identifier == $identifier) {
                    $data = $metadata->metadata_registry->id;
                }
            }

            \AppHelper::varDump($data);

        } else {
        */
        $data = MetadataRegistry::where([
            'namespace'  => 'project',
            'identifier' => $identifier,
        ])->first()['id'];

        //}

        return $data;
    }


    /**
     * @param $data
     *
     * @return bool
     */
    public function saveMetadata($data)
    {
        if ($data) {
            ProjectMetadata::saveAll($this, $data);

            return true;
        } else {
            throw new NotFoundHttpException;
        }
    }


    public function setImportStatus($status = true)
    {
        if (is_bool($status)) {
            $this->update(['imported' => $status]);

            return true;
        }

        return false;
    }


    public function setImportTimestamp()
    {
        $this->update(['imported_at' => Carbon::now()]);

        return true;
    }


    public static function lookupDatasource($identifier)
    {
        /* Get the datasource */
        $data_sources = DataSource::get();
        $external_data = [];

        /*
        foreach ($data_sources as $data_source) {
            $namespaces = $data_source->namespaces()->get();
            foreach ($namespaces as $namespace) {
                $external_data[] = $namespace;
            }
        }
        */

        foreach ($data_sources as $data_source) {
            $namespaces = $data_source->namespaces()->get();
            foreach ($namespaces as $namespace) {
                $external_data[$namespace->name] = DB::connection('odbc')->table($namespace->name)
                    ->where('Projekt_Nr', 'LIKE', $identifier)
                    ->get()->toJson();
            }
        }

        return $external_data;
    }

    public function importFromDataSource()
    {
        if ($this->data_source) {

            $namespaces = $this->data_source->namespaces;

            $metadata_fields = MetadataRegistry::where('namespace', 'project')->get();
            foreach ($metadata_fields as $metadata_field) {

                $content_type = $metadata_field->content_type;
                $required = $content_type->structure;

                foreach ($namespaces as $namespace) {
                    $mappings = $this->data_source->mappings()
                        ->where('data_source_id', $this->data_source->id)
                        ->where('data_source_namespace_id', $namespace->id)
                        ->where('target_metadata_registry_id', $metadata_field->id)
                        ->get();

                    $i = 0;
                    $new_item = [];

                    foreach ($mappings as $mapping) {
                        /* Get the external data by source */
			            $external_data = DB::connection('odbc')->table($namespace->name)
                            ->select($mapping->data_source_entity[0])
                            ->where('Projekt_Nr', 'LIKE', $this->identifier)
                            ->get();

			            /* Convert to array */
                        $external_data = $external_data->map(function ($x) { return (array)$x; })->toArray();

                        $target_content = $mapping->target_content;

                        switch ($content_type->identifier) {
                            case 'person':
                                $k = 0;
                                foreach ($external_data as $external_datum) {
                                    foreach ($target_content as $target_content_key => $target_content_value) {
                                        if ($target_content_value === 'CONTENT') {
                                            $new_item[ $k ][ $target_content_key ] = $external_datum[ $mapping->data_source_entity[0] ];
                                        }
                                    }
                                    $k++;
                                }
                                break;
                            default:
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
                                break;
                        }
                    }

                    $new_full_item = [];

                    foreach ($new_item as $item) {
                        $item = $item + array_diff_key($required, $item);
                        $new_full_item[] = $item;
                    }

                    if (count($new_full_item) > 0) {

                        switch ($content_type->identifier) {
                            case 'text_simple':
                                $new_full_item = call_user_func_array('array_merge', $new_full_item);
                                break;
                            case 'organization':
                                $new_full_item = call_user_func_array('array_merge', $new_full_item);
                                break;
                            case 'date':
                                $new_full_item = call_user_func_array('array_merge', $new_full_item);
                                break;
                            default:
                                //$new_full_item = call_user_func_array('array_merge', $new_full_item);
                                break;
                        }

                        $data = [$metadata_field->identifier => $new_full_item];
			$this->saveMetadata($data);
                    }
                }
            }

            $this->setImportStatus(true);
            $this->setImportTimestamp();

            return true;
        }
        return false;
    }
}
