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


    public static function formatForOutput( Collection $metadata, ContentType $content_type )
    {
        $output = new HtmlOutputFilter($metadata, $content_type);

        return $output->render();
    }


    public static function saveAll( Project $project, $metadata)
    {
        $data = collect([]);
        $input_data = collect([]);

        foreach( $metadata as $field => $content ) {

            $metadata_registry_id = $project->getMetadataRegistryIdByIdentifier($field);

            if (!is_null($metadata_registry_id)) {
                $input_data = [
                    'project_id' => $project->id,
                    'metadata_registry_id' => $metadata_registry_id,
                    'content' => $content
                ];

                $data->push($input_data);
            }
        };

        self::where('project_id', $project->id)->delete();

        foreach ($data as $datum) {
            \AppHelper::varDump($datum);
            self::create($datum);
        }

        return true;

    }
}