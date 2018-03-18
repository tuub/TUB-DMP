<?php
declare(strict_types=1);

namespace App;

use App\Library\HtmlOutputFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Collective\Html\HtmlFacade as HTML;
use Illuminate\Support\Facades\DB;
use App\Library\Traits\Uuids;
use AppHelper;

/**
 * Class ProjectMetadata
 *
 * @package App
 */
class ProjectMetadata extends Model
{
    use Uuids;

    /*
    |--------------------------------------------------------------------------
    | Model Options
    |--------------------------------------------------------------------------
    */

    protected $table = 'project_metadata';
    public $incrementing = false;
    protected $fillable = ['project_id', 'metadata_registry_id', 'content'];
    protected $casts = ['content' => 'array'];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * 1 Project Metadata belongs to 1 Project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    /**
     * 1 Project Metadata belongs to 1 Metadata Field in the Registry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function metadata_registry()
    {
        return $this->belongsTo(MetadataRegistry::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */


    /**
     * Assembles person string with given data.
     *
     * Supported are $firstname, $lastname, $email, $uri
     *
     * @todo Adopt ORCID for URI option if present.
     *
     * @param array $data
     *
     * @return string
     */
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


    /**
     * Gets content type for given content type identifier
     *
     * @uses ContentType
     * @used-by ProjectMetadata::saveAll()
     *
     * @param String $identifier
     *
     * @return ContentType|null
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

        return ContentType::find($data->id);
    }


    /**
     * Applies output filter to given metadatum and given content type.
     *
     * Calls HTML output filter by default.
     *
     * @todo Extend possible output filters, e.g. PDF
     *
     * @uses HtmlOutputFilter
     *
     * @param Collection $metadata
     * @param ContentType $content_type
     *
     * @return Collection|null
     */
    public static function formatForOutput( Collection $metadata = null, ContentType $content_type = null )
    {
        $output = new HtmlOutputFilter($metadata, $content_type);

        return $output->render();
    }


    /**
     * Applies input filter to given metadatum and given content type.
     *
     * Calls HTML input filter by default. NOT USED.
     *
     * @todo Is not used. To do so, add input filter interface and classes.
     *
     * @param Collection $metadata
     * @param ContentType $content_type
     *
     * @return Collection
     */
    public static function formatForInput(Collection $metadata = null, ContentType $content_type = null)
    {
        $result = collect([]);
        if ($metadata !== null && $content_type !== null) {
            if ($content_type->identifier === 'list') {
                $result = explode(',', $metadata->first());
            } else {
                $result = $metadata;
            }
        }

        return $result;
    }


    /**
     * Saves the given metadata collection for the given project.
     *
     * ...
     *
     * @todo Extend docblock. Check method. Find out type hint for $data.
     *
     * @param Project $project  A project instance
     * @param array $data
     * @return bool
     */
    public static function saveAll( Project $project, $data)
    {
        foreach ($data as $field => $values) {

            $input_data = collect([]);
            $content_type = self::getMetadataContentType($field)->identifier;

            if (\is_array($values)) {
                switch ($content_type) {
                    case 'person':
                        // Save me as PERSON JSON
                        $value = [];
                        foreach ($values as $foo) {
			                if (AppHelper::isEmptyArray($foo) === false) {
                                $value[] = $foo;
                            }
                        }
                        if (\count($value)) {
                            $input_data->push($value);
                        }
                        break;
                    case 'organization':
                        // Save me as ORGANIZATION JSON
                        $value = [];
                        foreach ($values as $foo) {
                            if (AppHelper::isEmpty($foo) === false) {
                                $value[] = $foo;
                            }
                        }
                        if (\count($value)) {
                            $input_data->push($value);
                        }
                        break;
                    case 'date':
                        // Save me as DATE STRING
                        if (AppHelper::isEmptyArray($values) === false) {
                            $value = $values;
                            $input_data->push($value);
                        }
                        break;
                    case 'text_with_language':
                        $value = [];
                        $required = ['content', 'language'];
                        foreach ($values as $foo) {
                            if (!\AppHelper::hasEmptyValues($foo) && \AppHelper::hasKeys($foo, $required)) {
                                $value[] = $foo;
                            }
                        }
                        if(\count($value)) {
                            $input_data->push($value);
                        }
                        break;
                    case 'textarea_with_language':
                        $value = [];
                        $required = ['content', 'language'];
                        foreach( $values as $foo ) {
                            if(AppHelper::hasEmptyValues($foo) === false && AppHelper::hasKeys($foo, $required)) {
                                $value[] = $foo;
                            }
                        }
                        if(\count($value)) {
                            $input_data->push($value);
                        }
                        break;

                    default:
                        // Save me as TEXT THING
                        if(AppHelper::isEmptyArray($values) === false) {
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

                    if (\is_array($value) === false) {
                        $value = $value->toArray();
                    }

                    $metadata_registry_id = $project->getMetadataRegistryIdByIdentifier($field);
                    self::where('project_id', $project->id)->where('metadata_registry_id', $metadata_registry_id)
                        ->delete();

                    if ($metadata_registry_id) {
                        self::create([
                            'project_id' => $project->id,
                            'metadata_registry_id' => $metadata_registry_id,
                            'content' => $value
                        ])->save();
                    }
		}
            }
            unset($input_data);
        }

        return true;
    }

    /**
     * @todo Documentation
     *
     * @param string $identifier
     * @return MetadataRegistry
     */
    public static function getMetadataFieldByIdentifier($identifier)
    {
        return MetadataRegistry::where('identifier', $identifier)->first();
    }

    /**
     * @todo Documentation
     *
     * @param ContentType $content_type
     * @return InputType
     */
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

        return InputType::find($data->id);
    }



}
