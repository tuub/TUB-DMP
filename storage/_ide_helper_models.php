<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Section
 *
 * @property string $id
 * @property string $name
 * @property string $template_id
 * @property string|null $keynumber
 * @property int $order
 * @property string|null $guidance
 * @property bool $is_mandatory
 * @property bool $is_active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property bool $export_keynumber
 * @property-read mixed $full_name
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Question[] $questions
 * @property-read \App\Template $template
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereExportKeynumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereGuidance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereIsMandatory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereKeynumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereUpdatedAt($value)
 */
	class Section extends \Eloquent {}
}

namespace App{
/**
 * App\ProjectMetadata
 *
 * @property string $id
 * @property string $project_id
 * @property string $metadata_registry_id
 * @property array $content
 * @property string|null $language
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\MetadataRegistry $metadata_registry
 * @property-read \App\Project $project
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectMetadata whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectMetadata whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectMetadata whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectMetadata whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectMetadata whereMetadataRegistryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectMetadata whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectMetadata whereUpdatedAt($value)
 */
	class ProjectMetadata extends \Eloquent {}
}

namespace App{
/**
 * App\QuestionOption
 *
 * @property string $id
 * @property string $question_id
 * @property string $text
 * @property string|null $value
 * @property bool|null $default
 * @property string|null $parent_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuestionOption whereValue($value)
 */
	class QuestionOption extends \Eloquent {}
}

namespace App{
/**
 * App\DataSourceMapping
 *
 * @property string $id
 * @property string $data_source_id
 * @property string $data_source_namespace_id
 * @property array $data_source_entity
 * @property string $target_namespace
 * @property string $target_metadata_registry_id
 * @property array $target_content
 * @property-read \App\DataSource $datasource
 * @property-read \App\MetadataRegistry $metadata_registry
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSourceMapping whereDataSourceEntity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSourceMapping whereDataSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSourceMapping whereDataSourceNamespaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSourceMapping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSourceMapping whereTargetContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSourceMapping whereTargetMetadataRegistryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSourceMapping whereTargetNamespace($value)
 */
	class DataSourceMapping extends \Eloquent {}
}

namespace App{
/**
 * App\DataSourceNamespace
 *
 * @property string $id
 * @property string $data_source_id
 * @property string $name
 * @property-read \App\DataSource $datasource
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSourceNamespace whereDataSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSourceNamespace whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSourceNamespace whereName($value)
 */
	class DataSourceNamespace extends \Eloquent {}
}

namespace App{
/**
 * App\Project
 *
 * @todo : CLEANUP!!! GET THOSE EAGER LOADED RELATIONS RUNNING!
 * @mixin \Eloquent
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property string $id
 * @property string $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property string $identifier
 * @property string $user_id
 * @property string|null $data_source_id
 * @property bool $imported
 * @property \Carbon\Carbon|null $imported_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $contact_email
 * @property bool $is_active
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Project[] $children
 * @property-read \App\DataSource|null $data_source
 * @property-read string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProjectMetadata[] $metadata
 * @property-read \App\Project|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Plan[] $plans
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node limitDepth($limit)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereDataSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereImported($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereImportedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutNode($node)
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutRoot()
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutSelf()
 */
	class Project extends \Eloquent {}
}

namespace App{
/**
 * App\Answer
 *
 * @property string $id
 * @property string $survey_id
 * @property string $question_id
 * @property array $value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Question $question
 * @property-read \App\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Answer whereValue($value)
 */
	class Answer extends \Eloquent {}
}

namespace App{
/**
 * App\Template
 *
 * @property string $id
 * @property string $name
 * @property bool $is_active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $logo_file
 * @property string|null $description
 * @property string|null $copyright
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Question[] $questions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Section[] $sections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Survey[] $surveys
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereCopyright($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereLogoFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Template whereUpdatedAt($value)
 */
	class Template extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property string $id
 * @property string|null $email
 * @property bool $is_admin
 * @property bool $is_active
 * @property \Carbon\Carbon|null $last_login
 * @property string $type
 * @property string|null $tub_om
 * @property-read \Illuminate\Database\Eloquent\Collection|\StudentAffairsUwm\Shibboleth\Entitlement[] $entitlements
 * @property-read mixed $institution_identifier
 * @property-read mixed $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Plan[] $plans
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Project[] $projects
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTubOm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereType($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Plan
 *
 * @mixin \Eloquent
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property string $id
 * @property string $title
 * @property string $project_id
 * @property string|null $version
 * @property bool $is_active
 * @property bool $is_snapshot
 * @property \Carbon\Carbon|null $snapshot_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Project $project
 * @property-read \App\Survey $survey
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plan ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plan whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plan whereIsSnapshot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plan whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plan whereSnapshotAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plan whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plan whereVersion($value)
 */
	class Plan extends \Eloquent {}
}

namespace App{
/**
 * App\Survey
 *
 * @property string $id
 * @property string $plan_id
 * @property string $template_id
 * @property int $completion
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Answer[] $answers
 * @property-read \App\Plan $plan
 * @property-read \App\Template $template
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereCompletion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Survey whereUpdatedAt($value)
 */
	class Survey extends \Eloquent {}
}

namespace App{
/**
 * App\ContentType
 *
 * @property string $id
 * @property string $identifier
 * @property string $title
 * @property array $structure
 * @property string $input_type_id
 * @property bool $is_active
 * @property-read \App\InputType $input_type
 * @property-read \App\MetadataRegistry $metadata_registry
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentType active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentType whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentType whereInputTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentType whereStructure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContentType whereTitle($value)
 */
	class ContentType extends \Eloquent {}
}

namespace App{
/**
 * App\MetadataRegistry
 *
 * @property string $id
 * @property string $namespace
 * @property string $identifier
 * @property string $title
 * @property string|null $description
 * @property string $content_type_id
 * @property bool $is_multiple
 * @property-read \App\ContentType $content_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DataSourceMapping[] $datasource_mapping
 * @property-read \App\ProjectMetadata $project_metadata
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MetadataRegistry whereContentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MetadataRegistry whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MetadataRegistry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MetadataRegistry whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MetadataRegistry whereIsMultiple($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MetadataRegistry whereNamespace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MetadataRegistry whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MetadataRegistry where($value)
 *
 */
	class MetadataRegistry extends \Eloquent {}
}

namespace App{
/**
 * App\DataSource
 *
 * @property string $id
 * @property string $type
 * @property string $identifier
 * @property string $name
 * @property string|null $description
 * @property string $uri
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DataSourceMapping[] $mappings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DataSourceNamespace[] $namespaces
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Project[] $projects
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSource whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSource whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSource whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DataSource whereUri($value)
 */
	class DataSource extends \Eloquent {}
}

namespace App{
/**
 * App\Question
 *
 * @property string $id
 * @property string|null $parent_id
 * @property int|null $lft
 * @property int|null $rgt
 * @property int|null $depth
 * @property string $template_id
 * @property string $section_id
 * @property string|null $keynumber
 * @property int $order
 * @property string $text
 * @property string|null $output_text
 * @property string $content_type_id
 * @property string|null $default
 * @property string|null $prepend
 * @property string|null $append
 * @property string|null $comment
 * @property string|null $reference
 * @property string|null $guidance
 * @property string|null $hint
 * @property bool $is_mandatory
 * @property bool $is_active
 * @property bool $read_only
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property bool $export_always
 * @property bool $export_keynumber
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Answer[] $answers
 * @property-read \Baum\Extensions\Eloquent\Collection|\App\Question[] $children
 * @property-read \App\ContentType $content_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\QuestionOption[] $options
 * @property-read \App\Question|null $parent
 * @property-read \App\Section $section
 * @property-read \App\Template $template
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node limitDepth($limit)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question mandatory()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question parent()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereAppend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereContentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereDepth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereExportAlways($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereExportKeynumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereGuidance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereHint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereIsMandatory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereKeynumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereOutputText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question wherePrepend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereReadOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutNode($node)
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutRoot()
 * @method static \Illuminate\Database\Eloquent\Builder|\Baum\Node withoutSelf()
 */
	class Question extends \Eloquent {}
}

namespace App{
/**
 * App\InputType
 *
 * @property string $id
 * @property string $identifier
 * @property string $title
 * @property string $category
 * @property bool $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InputType whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InputType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InputType whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InputType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InputType whereTitle($value)
 */
	class InputType extends \Eloquent {}
}

namespace App{
/**
 * App\Group
 *
 * @property string $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereName($value)
 */
	class Group extends \Eloquent {}
}

