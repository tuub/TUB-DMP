@php
$status = $project->status;
@endphp

<div class="container-fluid">
    <div class="col-lg-24 col-md-24 col-sm-24 col-xs-24">
        <div class="card">
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
                        <span class="project-status">{{  $project->status }}</span>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <p class="card-text">
                    <div class="row">
                        <div class="col-lg-12 col-md-24 col-sm-24 col-xs-24">
                            @if( $project->getMetadata('title') )
                                @foreach( $project->getMetadata('title') as $title )
                                    "{{ $title['content'] }}"<br/>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-24">
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

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-24">
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
                            @endif
                            <strong>Data Import:</strong>
                            @if($project->data_source)
                                {{ $project->data_source->identifier }}
                                @if ($project->is_prefilled)
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i><span class="hidden-xs"></span>
                                @else
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i><span class="hidden-xs"></span>
                                @endif
                            @else
                                None
                            @endif
                        </div>
                    </div>
                </p>
            </div>
            <div class="card-footer">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-24">
                    <a href="{{ route('project.show', $project->id)}}" class="show-project card-link btn btn-default btn-xs" data-rel="{{ $project->id }}" data-target="#show-project-{{$project->id}}" title="Show Project">
                        <i class="fa fa-info"></i><span class="hidden-sm hidden-xs"> More Info</span>
                    </a>
                    <a href="{{ route('project.edit', $project->id)}}" class="edit-project card-link btn btn-default btn-xs" data-rel="{{ $project->id }}" data-target="#edit-project-{{$project->id}}" title="Edit Project">
                        <i class="fa fa-pencil"></i><span class="hidden-sm hidden-xs"> Edit</span>
                    </a>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-24 text-right">
                    <a href="#" class="toggle-plans card-link btn btn-success btn-xs" data-href="{{  $project->id }}">
                        <i class="fa fa-plus"></i><span class="hidden-sm hidden-xs"> See Plans ({{ $project->plans_count }})</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row dashboard-project-plans hidden" data-content="{{  $project->id }}">
        <div class="col-lg-24 col-md-offset-1 col-md-24 col-sm-24 col-xs-24">
            @foreach ($project->plans as $plan)
                @include('partials.plan.infocard', $plan)
            @endforeach
        </div>
    </div>

    @foreach ($project->children as $project)
        @include('partials.project.modal', $project)
    @endforeach
</div>

@foreach ($project->children as $project)
    @include('partials.project.info', $project)
    @include('partials.project.modal', $project)
@endforeach