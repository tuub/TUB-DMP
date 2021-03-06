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
                        <span class="project-status"><strong>{{ trans('project.info.status.label') }}:</strong> {{  $project->status }}</span>
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
                            [{{ trans('project.metadata.title') }}]
                        @endif
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-24">

                        @unless( $project->getMetadata('leader') )
                            [{{ trans('project.metadata.leader') }}]
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
                            <strong>{{ trans('project.metadata.duration') }}:</strong>
                            <br/>
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
                            [{{ trans('project.metadata.duration') }}]
                        @endif
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-24">
                        @if( $project->getMetadata('funding_source') )
                            <strong>{{ trans('project.metadata.funding_source') }}:</strong>
                            <br/>
                            @foreach( $project->getMetadata('funding_source') as $funding_source )
                                {{ $funding_source }}<br/>
                            @endforeach
                        @else
                            [{{ trans('project.metadata.funding_source') }}]
                        @endif
                    </div>

                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-24">
                        <strong>{{ trans('project.info.import.label') }}:</strong>
                        <br/>
                        @if($project->data_source)
                            {{ $project->data_source->name }}
                        @else
                            {{ trans('project.info.import.no_datasource') }}
                        @endif
                    </div>
                </div>
                </p>
            </div>
            <!-- FOOTER -->
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-16 col-sm-16 col-xs-16">
                        <a href="{{ route('project.show', $project->id)}}" class="show-project card-link btn btn-default btn-xs" data-rel="{{ $project->id }}" data-target="#show-project-{{$project->id}}" title="{{ trans('project.info.button.show') }}">
                            <i class="fa fa-info"></i><span class="hidden-sm hidden-xs"> {{ trans('project.info.button.show') }}</span>
                        </a>
                        <a href="{{ route('project.edit', $project->id)}}" class="edit-project card-link btn btn-default btn-xs" data-rel="{{ $project->id }}" data-target="#edit-project-{{$project->id}}" title="{{ trans('project.info.button.edit') }}">
                            <i class="fa fa-pencil"></i><span class="hidden-sm hidden-xs"> {{ trans('project.info.button.edit') }}</span>
                        </a>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8 text-right">
                        <a href="#" class="toggle-plans card-link btn btn-success btn-xs" data-href="{{  $project->id }}">
                            <i class="fa fa-caret-down"></i><span class="hidden-sm hidden-xs"><strong> {{ trans('project.info.button.plans') }} ({{ $project->plans_count }})</strong></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row dashboard-project-plans hidden" data-content="{{  $project->id }}">
        <div class="col-lg-24 col-md-offset-1 col-md-24 col-sm-24 col-xs-24">
            @foreach ($project->plans()->orderBy('updated_at','desc')->orderBy('snapshot_at','desc')->get() as $plan)
                @include('partials.plan.info', $plan)
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
    @include('partials.project.info', $project)
    @include('partials.project.modal', $project)
@endforeach