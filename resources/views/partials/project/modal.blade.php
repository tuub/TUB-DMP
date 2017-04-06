<!-- Show Project Modal -->
<div class="modal fade" id="show-project-{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="show-project-{{ $project->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Show Project Metadata</h4>
            </div>
            <div class="modal-body">
                @if( $project->identifier )
                    <label>{{ $project->getMetadataLabel('identifier') }}:</label>
                    {{ $project->identifier }}
                    <br/>
                @endif

                @if( $project->plans_count )
                    <label>{{ str_plural('Plan', $project->plans_count) }}:</label>
                    {{ $project->plans_count }}
                    <br/>
                @endif

                @if( $project->children_count )
                    <label>{{ str_plural('Sub Project', $project->children_count) }}:</label>
                    {{ $project->children_count }}
                    <br/>
                @endif

                @if( $project->getMetadata('begin') and $project->getMetadata('begin')->count() )
                    <label>{{ $project->getMetadataLabel('duration') }}:</label>
                    @foreach( $project->getMetadata('begin') as $begin )
                        @date($begin) -
                        @if( $project->getMetadata('end') )
                            @foreach( $project->getMetadata('end') as $end )
                                @date($end)
                            @endforeach
                        @endif
                    @endforeach
                    <br/>
                @endif

                @if( $project->getMetadata('title') and $project->getMetadata('title')->count() )
                    <label>{{ str_plural($project->getMetadataLabel('title'), $project->getMetadata('title')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('title') as $title )
                        {{ strtoupper($title['language']) }}: {{ $title['content'] }}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                    <br/><br/>
                @endif

                @if( $project->getMetadata('abstract') and $project->getMetadata('abstract')->count() )
                    <label>{{ str_plural($project->getMetadataLabel('abstract'), $project->getMetadata('abstract')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('abstract') as $abstract )
                        {{ strtoupper($abstract['language']) }}: {{ $abstract['content'] }}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                    <br/><br/>
                @endif

                @if( $project->getMetadata('leader') and $project->getMetadata('leader')->count() )
                    <label>{{ str_plural($project->getMetadataLabel('leader'), $project->getMetadata('leader')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('leader') as $leader )
                        {!! \App\ProjectMetadata::getProjectMemberOutput($leader) !!}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                    <br/><br/>
                @endif

                @if( $project->getMetadata('member') and $project->getMetadata('member')->count() )
                    <label>{{ str_plural($project->getMetadataLabel('member'), $project->getMetadata('member')->count()) }}:</label>
                    <br/>
                    @foreach( $project->getMetadata('member') as $member )
                        {!! \App\ProjectMetadata::getProjectMemberOutput($member) !!}
                        @unless( $loop->last )
                            <br/>
                        @endunless
                    @endforeach
                    <br/><br/>
                @endif

                @if( $project->getMetadata('funding_source') and $project->getMetadata('funding_source')->count() )
                    <label>{{ str_plural($project->getMetadataLabel('funding_source'), $project->getMetadata('funding_source')->count()) }}:</label>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! BootForm::open()->class('edit-project-form form-horizontal')->role('form')->action( route('project.update') )->put() !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Project Metadata for {{ $project->identifier }}</h4>
            </div>
            <div class="modal-body">
                <!-- PROJECT_ID -->
                {!! BootForm::hidden('id')->id('id')->value($project->id) !!}

                <!-- PROJECT TITLE -->
                <label>{{ $project->getMetadataLabel('title') }}</label>
                @if( $project->getMetadata('title') and $project->getMetadata('title')->count() )
                    @foreach( $project->getMetadata('title') as $title )
                        <div class="form-group input-with-language" data-rel="{{ $loop->index }}">
                            <div class="col-md-18">
                                {!! Form::text('title[' . $loop->index . '][content]', $title['content'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::select('title[' . $loop->index . '][language]', ['de' => 'DE', 'en' => 'EN'], $title['language'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-2">
                                @if( $loop->last )
                                    {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                                @else
                                    {!! Form::button('<i class="fa fa-minus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'remove-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="form-group input-with-language" data-rel="0">
                        <div class="col-md-18">
                            {!! Form::text('title[0][content]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::select('title[0][language]', ['de' => 'DE', 'en' => 'EN'], null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                        </div>
                    </div>
                @endif

                <!-- PROJECT DURATION -->
                <label>{{ $project->getMetadataLabel('begin') }} / {{ $project->getMetadataLabel('end') }}:</label>
                <div class="form-group row">
                    <div class="col-md-6">
                        @if( $project->getMetadata('begin') and $project->getMetadata('begin')->count() )
                            {!! Form::date('begin[]', $project->getMetadata('begin')->first(), ['class' => 'form-control']) !!}
                        @else
                            {!! Form::date('begin[]', null, ['class' => 'form-control']) !!}
                        @endif
                    </div>
                    <div class="col-md-1">-</div>
                    <div class="col-md-6">
                        @if( $project->getMetadata('end') and $project->getMetadata('end')->count() )
                            {!! Form::date('end[]', $project->getMetadata('end')->first(), ['class' => 'form-control']) !!}
                        @else
                            {!! Form::date('end[]', null, ['class' => 'form-control']) !!}
                        @endif
                    </div>
                </div>

                <!-- PROJECT STAGE -->

                <label>{{ $project->getMetadataLabel('stage') }}</label>
                @if( $project->getMetadata('stage') and $project->getMetadata('stage')->count() )
                    @foreach( $project->getMetadata('stage') as $stage )
                        <div class="form-group input-with-language" data-rel="{{ $loop->index }}">
                            <div class="col-md-18">
                                {!! Form::text('stage[' . $loop->index . '][content]', $stage['content'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::select('stage[' . $loop->index . '][language]', ['de' => 'DE', 'en' => 'EN'], $stage['language'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-2">
                                @if( $loop->last )
                                    {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                                @else
                                    {!! Form::button('<i class="fa fa-minus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'remove-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="form-group input-with-language" data-rel="0">
                        <div class="col-md-18">
                            {!! Form::text('stage[0][content]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::select('stage[0][language]', ['de' => 'DE', 'en' => 'EN'], null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                        </div>
                    </div>
                @endif

                <!-- PROJECT ABSTRACT -->
                <label>{{ $project->getMetadataLabel('abstract') }}</label>
                @if( $project->getMetadata('abstract') and $project->getMetadata('abstract')->count() )
                    @foreach( $project->getMetadata('abstract') as $abstract )
                        <div class="form-group input-with-language" data-rel="{{ $loop->index }}">
                            <div class="col-md-18">
                                {!! Form::textarea('abstract[' . $loop->index . '][content]', $abstract['content'], ['rows' => 3, 'class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::select('abstract[' . $loop->index . '][language]', ['de' => 'DE', 'en' => 'EN'], $abstract['language'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-2">
                                @if( $loop->last )
                                    {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                                @else
                                    {!! Form::button('<i class="fa fa-minus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'remove-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="form-group input-with-language" data-rel="0">
                        <div class="col-md-18">
                            {!! Form::textarea('abstract[0][content]', null, ['rows' => 3, 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::select('abstract[0][language]', ['de' => 'DE', 'en' => 'EN'], null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                        </div>
                    </div>
                @endif

                <!-- PROJECT LEADER -->
                <label>{{ $project->getMetadataLabel('leader') }}</label>
                @if( $project->getMetadata('leader') and $project->getMetadata('leader')->count() )
                    @foreach( $project->getMetadata('leader') as $leader )
                        <div class="form-group row" data-rel="{{ $loop->index }}">
                            <div class="col-md-4">
                                {!! Form::text('member[' . $loop->index . '][firstname]', $leader['firstname'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-5">
                                {!! Form::text('member[' . $loop->index . '][lastname]', $leader['lastname'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('member[' . $loop->index . '][email]', $leader['email'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-7">
                                {!! Form::text('member[' . $loop->index . '][uri]', $leader['uri'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-2">
                                @if( $loop->last )
                                    {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                                @else
                                    {!! Form::button('<i class="fa fa-minus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'remove-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="form-group row" data-rel="0">
                        <div class="col-md-4">
                            {!! Form::text('leader[0][firstname]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-5">
                            {!! Form::text('leader[0][lastname]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('leader[0][email]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-7">
                            {!! Form::text('leader[0][uri]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                        </div>
                    </div>
                @endif

                <!-- PROJECT MEMBERS -->
                <label>{{ $project->getMetadataLabel('member') }}</label>
                @if( $project->getMetadata('member') and $project->getMetadata('member')->count() )
                    @foreach( $project->getMetadata('member') as $member )
                        <div class="form-group row" data-rel="{{ $loop->index }}">
                            <div class="col-md-4">
                                {!! Form::text('member[' . $loop->index . '][firstname]', $member['firstname'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-5">
                                {!! Form::text('member[' . $loop->index . '][lastname]', $member['lastname'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::text('member[' . $loop->index . '][email]', $member['email'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-7">
                                {!! Form::text('member[' . $loop->index . '][uri]', $member['uri'], ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-md-2">
                                @if( $loop->last )
                                    {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                                @else
                                    {!! Form::button('<i class="fa fa-minus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'remove-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="form-group row" data-rel="0">
                        <div class="col-md-4">
                            {!! Form::text('member[0][firstname]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-5">
                            {!! Form::text('member[0][lastname]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('member[0][email]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-7">
                            {!! Form::text('member[0][uri]', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::button('<i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"></span>', ['class' => 'add-form-group btn btn-default', 'data-rel' => $project->id]) !!}
                        </div>
                    </div>
                @endif

                <!-- FUNDING SOURCE -->
                <label>{{ $project->getMetadataLabel('funding_source') }}</label>
                @if( $project->getMetadata('funding_source') and $project->getMetadata('funding_source')->count() )
                    @foreach( $project->getMetadata('funding_source') as $funding_source )
                        <div class="form-group row">
                            {!! Form::text('funding_source[' . $loop->index . ']', $funding_source, ['class' => 'form-control']) !!}
                        </div>
                    @endforeach
                @else
                    <div class="form-group row">
                        {!! Form::text('funding_source[]', null, ['class' => 'form-control']) !!}
                    </div>
                @endif

                <!-- FUNDING PROGRAM -->
                <label>{{ $project->getMetadataLabel('funding_program') }}</label>
                @if( $project->getMetadata('funding_program') and $project->getMetadata('funding_program')->count() )
                    @foreach( $project->getMetadata('funding_program') as $funding_program )
                        <div class="form-group row">
                            {!! Form::text('funding_program[' . $loop->index . ']', $funding_program, ['class' => 'form-control']) !!}
                        </div>
                    @endforeach
                @else
                    <div class="form-group row">
                        {!! Form::text('funding_program[]', null, ['class' => 'form-control']) !!}
                    </div>
                @endif

                <!-- GRANT REFERENCE NUMBER -->
                <label>{{ $project->getMetadataLabel('grant_reference_number') }}</label>
                @if( $project->getMetadata('grant_reference_number') and $project->getMetadata('grant_reference_number')->count() )
                    @foreach( $project->getMetadata('grant_reference_number') as $grant_reference_number )
                        <div class="form-group row">
                            {!! Form::text('grant_reference_number[' . $loop->index . ']', $grant_reference_number, ['class' => 'form-control']) !!}
                        </div>
                    @endforeach
                @else
                    <div class="form-group row">
                        {!! Form::text('grant_reference_number[]', null, ['class' => 'form-control']) !!}
                    </div>
                @endif

                <!-- PROJECT MANAGEMENT ORGANISATION -->
                <label>{{ $project->getMetadataLabel('project_management_organisation') }}</label>
                @if( $project->getMetadata('project_management_organisation') and $project->getMetadata('project_management_organisation')->count() )
                    @foreach( $project->getMetadata('project_management_organisation') as $project_management_organisation )
                        <div class="form-group row">
                            {!! Form::text('project_management_organisation[' . $loop->index . ']', $project_management_organisation, ['class' => 'form-control']) !!}
                        </div>
                    @endforeach
                @else
                    <div class="form-group row">
                        {!! Form::text('project_management_organisation[]', null, ['class' => 'form-control']) !!}
                    </div>
                @endif

                <!-- PROJECT DATA CONTACT -->
                <label>{{ $project->getMetadataLabel('project_data_contact') }}</label>
                @if( $project->getMetadata('project_data_contact') and $project->getMetadata('project_data_contact')->count() )
                    @foreach( $project->getMetadata('project_data_contact') as $project_data_contact )
                        <div class="form-group row">
                            {!! Form::text('project_data_contact[' . $loop->index . ']', $project_data_contact, ['class' => 'form-control']) !!}
                        </div>
                    @endforeach
                @else
                    <div class="form-group row">
                        {!! Form::text('project_data_contact[]', null, ['class' => 'form-control']) !!}
                    </div>
                @endif

            </div>
            <div class="modal-footer">
                {!! BootForm::button('Cancel')->class('btn btn-default')->data(['dismiss' => 'modal']) !!}
                {!! BootForm::submit('Update')->class('btn btn-success') !!}
            </div>
            {!! BootForm::close() !!}
        </div>
    </div>

</div>