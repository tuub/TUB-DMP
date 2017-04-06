<?php

namespace App;

use App\Library\HtmlOutputFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use HTML;

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

        if ($data['uri']) {
            $output .= ' (' . HTML::link( $data['uri'], 'www', ['target' => '_blank']) . ')';
        }


        return $output;
    }


    public function findRegistryIdByIdentifier($identifier)
    {
        $data = null;

        foreach( $this->metadata_registry as $registry ) {
            if ($registry->identifier == $identifier) {
                $data = $registry->id;
            }
        }

        echo $data;

        return $data;
    }


    public function getContentTypeByIdentifier($identifier)
    {
        $data = null;

        foreach( $this->metadata_registry as $registry ) {
            if ($registry->identifier == $identifier) {
                $data = $registry->content_type_id;
            }
        }

        echo $data;

        return $data;
    }


    public static function formatForOutput( Collection $metadata, ContentType $content_type )
    {
        $output = new HtmlOutputFilter($metadata, $content_type);

        return $output->render();
    }


    /**
     * @param Collection $metadata
     * @param ContentType $content_type
     * @return array|Collection
     */
    public static function formatForInput( Collection $metadata, ContentType $content_type )
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
        ProjectMetadata::where('project_id', $project->id)->delete();

        foreach($data as $field => $values) {

            $input_data = collect([]);
            $content_type = $project->getMetadataContentType($field)->identifier;

            if(is_array($values)) {
                switch($content_type) {
                    case 'person':
                        // Save me as PERSON JSON
                        $value = [];
                        foreach( $values as $foo ) {
                            if(!\AppHelper::isEmptyArray($foo)) {
                                array_push($value, $foo);
                            }
                        }
                        if(count($value)) {
                            $input_data->push($value);
                        }
                        break;
                    case 'organization':
                        // Save me as ORGANIZATION JSON
                        if(!\AppHelper::isEmptyArray($values)) {
                            $value = $values;
                            $input_data->push($value);
                        }
                        break;
                    case 'date':
                        // Save me as DATE STRING
                        if(!\AppHelper::isEmptyArray($values)) {
                            $value = $values;
                            $input_data->push($value);
                        }
                        break;
                    case 'text_with_language':
                        $value = [];
                        foreach( $values as $foo ) {
                            if(!\AppHelper::hasEmptyValues($foo)) {
                                array_push($value, $foo);
                            }
                        }
                        if(count($value)) {
                            $input_data->push($value);
                        }
                        break;
                    case 'textarea_with_language':
                        $value = [];
                        foreach( $values as $foo ) {
                            if(!\AppHelper::hasEmptyValues($foo)) {
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

            if($input_data->isNotEmpty()) {
                foreach ($input_data as $index => $value) {
                    $metadata_registry_id = $project->getMetadataRegistryIdByIdentifier($field);
                    if($metadata_registry_id) {
                        ProjectMetadata::create([
                            'project_id' => $project->id,
                            'metadata_registry_id' => $metadata_registry_id,
                            'content' => $value
                        ]);
                    }
                }
            }
            unset($input_data);
        }

        return true;
    }
}