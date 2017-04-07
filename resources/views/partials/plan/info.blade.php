<div class="dashboard-plan-info container col-md-12 col-sm-12 col-xs-24" id="plan-{{ $plan->id }}">
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-1 col-sm-1 col-xs-1">
                    <i class="fa fa-file-text-o fa-1x"></i>
                </div>
                <div class="col-md-20 col-sm-17 col-xs-18">
                    <span class="plan-title">{{ $plan->title }}</span>
                    @unless( $plan->is_final )
                        <a href="{{ route('plan.edit', $plan->id)}}" class="edit-plan" data-rel="{{ $plan->id }}" data-toggle="modal" data-target="#edit-plan-{{$plan->id}}" title="Edit DMP">
                            <i class="fa fa-pencil"></i>
                        </a>
                    @endunless
                </div>
                <div class="col-md-3 col-sm-5 col-xs-4 text-right">
                    @if( $plan->is_final )
                        <i class="fa fa-check-square-o fa-1x" aria-hidden="true"></i><span class="hidden-xs"></span>
                    @else
                        <span class="plan-status">{{ $plan->survey->completion }}&nbsp;%</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12 col-sm-14 col-xs-12">
                    <strong>Created:</strong> @date( $plan->created_at ) at @time( $plan->created_at )<br/>
                    <strong>Updated:</strong> @date( $plan->updated_at ) at @time( $plan->updated_at )<br/>
                </div>
                <div class="col-md-12 col-sm-10 col-xs-12">
                    <div class="tools">
                        @unless( $plan->is_final )
                            <a href="{{ URL::route('survey.edit', [$plan->id]) }}" class="btn btn-default btn-xs" title="Edit Survey">
                                <i class="fa fa-pencil"></i><span class="hidden-sm hidden-xs"> Edit</span>
                            </a>
                        @endunless
                        <a href="{{ URL::route('survey.show', [$plan->id]) }}" class="btn btn-default btn-xs" title="View">
                            <i class="fa fa-eye"></i><span class="hidden-sm hidden-xs"> View</span>
                        </a>
                        <a href="#" class="email-plan btn btn-default btn-xs" data-rel="{{ $plan->id }}" data-toggle="modal" data-target="#email-plan" title="Email Plan">
                            <i class="fa fa-envelope-o"></i><span class="hidden-sm hidden-xs"> Email</span>
                        </a>
                        <a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#export-option-for-{{ $plan->id }}" title="PDF">
                            <i class="fa fa-file-pdf-o"></i><span class="hidden-sm hidden-xs"> PDF</span>
                        </a>
                    </div>
                    <div class="version">
                        @if( $plan->is_final )
                            @if( $plan->hasNextVersion($plan->version) )
                                This DMP is finished and already has a version {{ $plan->version+1 }}.
                            @else
                                <a href="{{ URL::route('plan.toggle', [$plan->id, $plan->version]) }}" class="btn btn-default btn-xs" title="Reopen"><i class="fa fa-unlock"></i><span class="hidden-xs"> Reopen</span></a>

                                <a href="#" class="create-plan-version btn btn-default btn-xs" data-rel="{{ $plan->id }}" data-toggle="modal" data-target="#create-plan-version" title="Make new Version {{ $plan->version+1 }}">
                                    <i class="fa fa-fast-forward"></i><span class="hidden-sm hidden-xs"> Create version {{ $plan->version+1 }}</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ URL::route('plan.toggle', [$plan->id]) }}" class="btn btn-default btn-xs" title="Finish"><i class="fa fa-lock"></i><span class="hidden-xs"> Finish DMP</span></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>