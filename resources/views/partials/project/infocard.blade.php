@php
$status = $project->status;
@endphp

<div class="container-fluid">
    <div class="col-lg-24 col-md-24 col-sm-24 col-xs-24">
        <div class="card">
            <!-- HEADER -->
            <div class="card-header">
                <div class="row">
                    <div class="col-md-18 col-sm-18 col-xs-18">
                        <span class="project-title">
                            <strong>{{ $project->identifier }}</strong>
                            @if( $project->isChild() )
                                <br/>Parent Project: {{ $project->parent->identifier }}
                            @endif
                        </span>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                        <span class="project-status"><strong>Status:</strong> {{  $project->status }}</span>
                    </div>
                </div>
            </div>
            <!-- BODY -->
            <div class="card-block">
                <p class="card-text">
                    <div class="row">
                        <div class="col-lg-24 col-md-24 col-sm-24 col-xs-24">
                            @if( $project->getMetadata('title') )
                                @foreach( $project->getMetadata('title') as $title )
                                    "{{ $title['content'] }}"<br/>
                                @endforeach
                            @else
                                [Project Title]
                            @endif
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-24">

                            @unless( $project->getMetadata('leader') )
                                [Principal Investigator]
                            @endunless

                            @if( $project->getMetadata('leader') )
                                @foreach( $project->getMetadata('leader') as $leader )
                                    <strong>{!! \App\ProjectMetadata::getProjectMemberOutput($leader) !!}</strong><br/>
                                @endforeach
                            @endif
                            @if( $project->getMetadata('member') )
                                @foreach( $project->getMetadata('member') as $member )
                                    {!! \App\ProjectMetadata::getProjectMemberOutput($member) !!}<br/>
                                @endforeach
                            @endif
                        </div>

                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-24">
                            @if( $project->getMetadata('begin') )
                                <strong>Project Duration:</strong>
                                @foreach( $project->getMetadata('begin') as $begin )
                                    @date($begin) -
                                    @if( $project->getMetadata('end') )
                                        @foreach( $project->getMetadata('end') as $end )
                                            @date($end)
                                        @endforeach
                                    @endif
                                @endforeach
                                <br/>
                            @else
                                [Project Duration]
                            @endif
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-24">
                            @if( $project->getMetadata('funding_source') )
                                <strong>Funded by</strong><br/>
                                @foreach( $project->getMetadata('funding_source') as $funding_source )
                                    {{ $funding_source }}<br/>
                                @endforeach
                            @else
                                [Funding]
                            @endif
                        </div>

                        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-24">
                            <strong>Data Import:</strong>
                            @if($project->data_source)
                                {{ $project->data_source->identifier }}
                            @else
                                None
                            @endif
                        </div>
                    </div>
                </p>
            </div>
            <!-- FOOTER -->
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-18 col-sm-18 col-xs-18">
                        <a href="{{ route('project.show', $project->id)}}" class="show-project card-link btn btn-default btn-xs" data-rel="{{ $project->id }}" data-target="#show-project-{{$project->id}}" title="Show Project">
                            <i class="fa fa-info"></i><span class="hidden-sm hidden-xs"> More Info</span>
                        </a>
                        <a href="{{ route('project.edit', $project->id)}}" class="edit-project card-link btn btn-default btn-xs" data-rel="{{ $project->id }}" data-target="#edit-project-{{$project->id}}" title="Edit Project">
                            <i class="fa fa-pencil"></i><span class="hidden-sm hidden-xs"> Edit Project Metadata</span>
                        </a>
                        @if($project->data_source)
                            <a href="{{ route('project.import', $project->id)}}" class="import-project card-link btn btn-default btn-xs" data-rel="{{ $project->id }}" title="Import Project Metadata">
                                <i class="fa fa-download"></i><span class="hidden-sm hidden-xs"> Import from Datasource</span>
                            </a>
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                        <a href="#" class="toggle-plans card-link btn btn-success btn-xs" data-href="{{  $project->id }}">
                            <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"> Plans ({{ $project->plans_count }})</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row dashboard-project-plans hidden" data-content="{{  $project->id }}">
        <div class="col-lg-24 col-md-offset-1 col-md-24 col-sm-24 col-xs-24">
            @foreach ($project->plans as $plan)
                @include('partials.plan.infocard', $plan)
                @include('partials.plan.modal', $plan)
            @endforeach
        </div>
        <div class="text-center">
            <a href="#" class="create-plan btn btn-default btn-lg" data-toggle="modal" data-target="#create-plan" data-rel="{{ $project->id }}"title="Create new DMP">
                <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs">&nbsp;&nbsp;&nbsp;Create DMP</span>
            </a>
        </div>
    </div>
</div>

<hr/>

@foreach ($project->children as $project)
    @include('partials.project.infocard', $project)
    @include('partials.project.modal', $project)
@endforeach