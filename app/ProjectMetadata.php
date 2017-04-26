<?php

namespace App;

use App\Library\HtmlOutputFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use HTML;
use DB;

class ProjectMetadata extends Model
{
    protected $table = 'project_metadata';
    protected $fillable = ['project_id', 'metadata_registry_id', 'content'];
    protected $casts = ['content' => 'array'];

    // 1 Project Metadata belongs to 1 Project.
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // 1 Project Metadata belongs to 1 Metadata Field in the Registry.
    public function metadata_registry()
    {
        return $this->belongsTo(MetadataRegistry::class);
    }


    public static function getProjectMemberOutput($data) {
        $output = null;
        $name = '';
        $email = null;

        if ($data['firstname']) {
            $name .= $data['firstname'] . ' ';
        }

        if ($data['lastname']) {
            $name .= $data['lastname'];
        }

        if ($data['email']) {
            $output = HTML::mailto( $data['email'], $name);
        } else {
            $output = $name;
        }

        /*
        if ($data['uri']) {
            $output .= ' (' . HTML::link( $data['uri'], 'www', ['target' => '_blank']) . ')';
        }
        */


        return $output;
    }


    public static function getProjectMemberShortOutput($data) {
        $output = null;
        $name = '';
        $email = null;

        if ($data['lastname']) {
            $output = $data['lastname'];
        }

        /*
        if ($data['uri']) {
            $output .= ' (' . HTML::link( $data['uri'], 'www', ['target' => '_blank']) . ')';
        }
        */

        return $output;
    }


    public static function getMetadataFieldByIdentifier($identifier)
    {
        $field = MetadataRegistry::where('identifier', $identifier)->first();

        return $field;
    }


    /**
     * @param String $identifier
     *
     * @return ContentType
     */
    public static function getMetadataContentType($identifier)
    {
        $data = DB::table('content_types')
            ->join('metadata_registry', function ($join) use($identifier) {
                $join->on('content_types.id', '=', 'metadata_registry.content_type_id')
                    ->where([
                        'metadata_registry.namespace' => 'project',
                        'metadata_registry.identifier' =>  $identifier
                    ]);
            })
            ->select('content_types.id')
            ->first();

        $content_type = ContentType::find($data->id);
        return $content_type;
    }


    public static function getMetadataInputType($content_type)
    {
        $data = DB::table('input_types')
            ->join('content_types', function ($join) use($content_type) {
                $join->on('input_types.id', '=', 'content_types.input_type_id')
                    ->where([
                        'content_types.id' =>  $content_type->id
                    ]);
            })
            ->select('input_types.id')
            ->first();

        $input_type = InputType::find($data->id);
        return $input_type;
    }


    public static function isMultipleField($content_type)
    {
        $data = DB::table('input_types')
            ->join('content_types', function ($join) use($content_type) {
                $join->on('input_types.id', '=', 'content_types.input_type_id')
                    ->where([
                        'content_types.id' =>  $content_type->id
                    ]);
            })
            ->select('input_types.id')
            ->first();

        $input_type = InputType::find($data->id);
        return $input_type;
    }



    /*
    public function getContentTypeByIdentifier($identifier)
    {
        $data = null;

        foreach( $this->metadata_registry as $registry ) {
            if ($registry->identifier == $identifier) {
                $data = $registry->content_type_id;
            }
        }

        return $data;
    }
    */


    public static function formatForOutput( Collection $metadata = null, ContentType $content_type = null )
    {
        $output = new HtmlOutputFilter($metadata, $content_type);

        return $output->render();
    }


    /**
     * @param Collection $metadata
     * @param ContentType $content_type
     * @return array|Collection
     */
    public static function formatForInput( Collection $metadata = null, ContentType $content_type = null )
    {
        $result = collect([]);
        switch($content_type->identifier) {
            case 'list':
                $result = explode(',', $metadata->first());
                break;
            default:
                $result = $metadata;
        }

        return $result;
    }


    public static function saveAll( Project $project, $data)
    {
        \AppHelper::varDump($data);

        foreach ($data as $field => $values) {

            $input_data = collect([]);
            $content_type = ProjectMetadata::getMetadataContentType($field)->identifier;

            if (is_array($values)) {
                switch ($content_type) {
                    case 'person':
                        // Save me as PERSON JSON
                        $value = [];
                        foreach ($values as $foo) {
                            if(!\AppHelper::isEmptyArray($foo)) {
                                array_push($value, $foo);
                            }
                        }
                        if (count($value)) {
                            $input_data->push($value);
                        }
                        break;
                    case 'organization':
                        // Save me as ORGANIZATION JSON
                        $value = [];
                        foreach ($values as $foo) {
                            if(!\AppHelper::isEmpty($foo)) {
                                array_push($value, $foo);
                            }
                        }
                        if (count($value)) {
                            $input_data->push($value);
                        }
                        break;
                    case 'date':
                        // Save me as DATE STRING
                        if (!\AppHelper::isEmptyArray($values)) {
                            $value = $values;
                            $input_data->push($value);
                        }
                        break;
                    case 'text_with_language':
                        $value = [];
                        $required = ['content', 'language'];
                        foreach ($values as $foo) {
                            if (!\AppHelper::hasEmptyValues($foo) && \AppHelper::hasKeys($foo, $required)) {
                                array_push($value, $foo);
                            }
                        }
                        if(count($value)) {
                            $input_data->push($value);
                        }
                        break;
                    case 'textarea_with_language':
                        $value = [];
                        $required = ['content', 'language'];
                        foreach( $values as $foo ) {
                            if(!\AppHelper::hasEmptyValues($foo) && \AppHelper::hasKeys($foo, $required)) {
                                array_push($value, $foo);
                            }
                        }
                        if(count($value)) {
                            $input_data->push($value);
                        }
                        break;

                    default:
                        // Save me as TEXT THING
                        if(!\AppHelper::isEmptyArray($values)) {
                            $value = $values;
                            $input_data->push($value);
                        }
                        break;
                }
            } else {
                // Save me as REGULAR TEXT
                $value = $values;
                $input_data->push($value);
            }

            if ($input_data->isNotEmpty()) {
                foreach ($input_data as $index => $value) {

                    $metadata_registry_id = $project->getMetadataRegistryIdByIdentifier($field);
                    ProjectMetadata::where('project_id', $project->id)->where('metadata_registry_id', $metadata_registry_id)->delete();

                    if ($metadata_registry_id) {
                        $foo = ProjectMetadata::create([
                            'project_id' => $project->id,
                            'metadata_registry_id' => $metadata_registry_id,
                            'content' => $value->toArray()
                        ])->save();

                        \AppHelper::varDump($foo);

                        \AppHelper::varDump('Updated ' . $field);
                        \AppHelper::varDump(json_encode($value));
                        

                    }
                }
            }
            unset($input_data);
        }

        //return true;
    }
}