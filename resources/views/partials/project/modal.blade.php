<!-- Show Project Modal -->
<div class="modal fade" id="show-project-{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="show-project-{{ $project->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Show Project Metadata</h4>
            </div>
            <div class="modal-body">
                <label>Project Number</label>
                {{ $project->identifier }}
                <br/>
                <label>{{ str_plural('Plan', $project->plans_count) }}:</label>
                {{ $project->plans_count }}
                <br/>
                <label>{{ str_plural('Sub Project', $project->children_count) }}:</label>
                {{ $project->children_count }}
                <br/>
                @if( $project->getMetadata('title') )
                    <label>{{ str_plural($project->getMetadataLabel('title'), $project->getMetadata('title')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('title') as $title )
                        {{ strtoupper($title['language']) }}: {{ $title['content'] }}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                @endif
                <br/>
                <label>Duration:</label>
                @if( $project->getMetadata('begin') )
                    @foreach( $project->getMetadata('begin') as $begin )
                        @date($begin) -
                        @if( $project->getMetadata('end') )
                            @foreach( $project->getMetadata('end') as $end )
                                @date($end)
                            @endforeach
                        @endif
                    @endforeach
                @endif
                <br/>
                @if( $project->getMetadata('abstract') )
                    <label>{{ str_plural($project->getMetadataLabel('abstract'), $project->getMetadata('abstract')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('abstract') as $abstract )
                        {{ strtoupper($abstract['language']) }}: {{ $abstract['content'] }}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                @endif
                <br/>
                @if( $project->getMetadata('member') )
                    <label>{{ str_plural($project->getMetadataLabel('member'), $project->getMetadata('member')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('member') as $member )
                        {!! \App\ProjectMetadata::getProjectMemberOutput($member) !!}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                @endif
                <br/>
                <label>{{ str_plural($project->getMetadataLabel('funding_source'), $project->getMetadata('funding_source')->count()) }}:</label>
                @if( $project->getMetadata('funding_source') )
                    {!! $project->getMetadata('funding_source')->implode(', ') !!}
                @endif
            </div>
            <div class="modal-footer">
                {{ Form::button('OK', ['class' => 'btn btn-success', 'data-dismiss' => 'modal']) }}
            </div>
        </div>
    </div>
</div>


<!-- Edit Project Modal -->
<div class="modal fade" id="edit-project-{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="edit-project-{{ $project->id }}">
    {!! BootForm::open()->id('edit-project-form')->action( route('project.update') )->put() !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Project Metadata for {{ $project->identifier }}</h4>
            </div>
            <div class="modal-body">
                {!! BootForm::hidden('id')->id('id')->value($project->id) !!}
                @if( $project->getMetadata('title') )
                    {!! Form::label('title[]', $project->getMetadataLabel('title')) !!}
                    @foreach( $project->getMetadata('title') as $title )
                        <div class="form-group row">
                            <div class="col-md-20">
                                {!! Form::text('title[' . $loop->index . '][content]', $title['content'], ['class' => 'form-control']) !!}
                            </div>
                            <div>
                                {!! Form::select('title[' . $loop->index . '][language]', ['de' => 'DE', 'en' => 'EN'], $title['language'], ['class' => 'col-md-4']) !!}
                            </div>
                        </div>
                    @endforeach
                @endif

                <label>{{ $project->getMetadataLabel('begin') }} / {{ $project->getMetadataLabel('end') }}:</label>
                <div class="form-group row">
                    <div class="col-md-6">
                        {!! Form::date('begin[]', $project->getMetadata('begin')->first(), ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-1">-</div>
                    <div class="col-md-6">
                        {!! Form::date('end[]', $project->getMetadata('end')->first(), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <label>{{ $project->getMetadataLabel('abstract') }}:</label>
                @if( $project->getMetadata('abstract') )
                    @foreach( $project->getMetadata('abstract') as $abstract )
                        <div class="form-group row">
                            <div class="col-md-20">
                                {!! Form::textarea('abstract[' . $loop->index . '][content]', $abstract['content'], ['rows' => 3, 'class' => 'form-control']) !!}
                            </div>
                            <div>
                                {!! Form::select('abstract[' . $loop->index . '][language]', ['de' => 'DE', 'en' => 'EN'], $abstract['language'], ['class' => 'col-md-4']) !!}
                            </div>
                        </div>
                    @endforeach
                @endif

                <label>{{ str_plural($project->getMetadataLabel('member'), $project->getMetadata('member')->count()) }}:</label>
                @if( $project->getMetadata('member') )
                    @foreach( $project->getMetadata('member') as $member )
                        <div class="form-group row">
                            <div class="col-md-6">
                                {!! Form::text('member[' . $loop->index . '][firstname]', $member['firstname'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('member[' . $loop->index . '][lastname]', $member['lastname'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('member[' . $loop->index . '][email]', $member['email'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('member[' . $loop->index . '][uri]', $member['uri'], ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    @endforeach
                @endif

                <label>{{ str_plural($project->getMetadataLabel('funding_source'), $project->getMetadata('funding_source')->count()) }}:</label>
                @if( $project->getMetadata('funding_source') )
                    @foreach( $project->getMetadata('funding_source') as $funding_source )
                        <div class="form-group row">
                            {!! Form::text('funding_source[' . $loop->index . ']', $funding_source, ['class' => 'form-control']) !!}
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Send')->class('btn btn-success') !!}
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
</div>





@if( false )
    <!-- Create Project Modal -->
    <div class="modal fade" id="create-project" tabindex="-1" role="dialog" aria-labelledby="create-project">
        {!! BootForm::open()->id('create-project-form')->action( route('project.store') )->put() !!}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create Project</h4>
                </div>
                <div class="modal-body">
                    {!! BootForm::hidden('project_id')->id('project_id') !!}
                    {!! BootForm::text('DMP Title', 'title')->placeholder('My Research Project') !!}
                    {!! BootForm::select('Template', 'template_id')->options($templates->pluck('name', 'id')) !!}
                    {!! BootForm::text('DMP Version', 'version') !!}
                </div>
                <div class="modal-footer">
                    {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                    {!! BootForm::submit('Create')->class('btn btn-success') !!}
                </div>
            </div>
        </div>
        {!! BootForm::close() !!}
    </div>

    <!-- Edit Project Modal -->
    <div class="modal fade" id="edit-project" tabindex="-1" role="dialog" aria-labelledby="edit-project">
        {!! BootForm::open()->id('edit-project-form')->action( route('project.update') )->put() !!}
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Project {{ $project->identifier }}</h4>
                </div>
                <div class="modal-body">
                    {!! BootForm::hidden('id')->id('id') !!}
                    {!! BootForm::text('Project ID', 'identifier')->value($project->identifier)->readonly('readonly') !!}

                @if (true)
                        @foreach( $project->metadata->load('metadata_registry') as $metadata_field )
                            <?php //var_dump($metadata_field->metadata_registry->title) ?>
                            <?php //var_dump($metadata_field->language) ?>
                            <?php //var_dump($metadata_field->content) ?>

                            <div class="form-group row container">
                                <div class="col-md-2">
                                    {!! Form::Label( $metadata_field->metadata_registry->identifier, $metadata_field->metadata_registry->name ) !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::Text( $metadata_field->metadata_registry->identifier . '[' . $metadata_field->language . ']', $metadata_field->content, array('class' => 'form-control xs') ) !!}
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {!! BootForm::text('DMP Version', 'version') !!}
                </div>
                <div class="modal-footer">
                    {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                    {!! BootForm::submit('Save')->class('btn btn-success') !!}
                </div>
            </div>
        </div>
        {!! BootForm::close() !!}
    </div>
@endif