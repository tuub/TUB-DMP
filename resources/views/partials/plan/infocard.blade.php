    <div class="col-md-22">
        <div class="alert alert-success">
            <!-- HEADER -->
            <div class="row">
                <div class="col-md-1 col-sm-1 col-xs-1">
                    @if( $plan->is_snapshot )
                        <i class="fa fa-lock fa-1x"></i>
                    @else
                        <i class="fa fa-file-text-o fa-1x"></i>
                    @endif
                </div>
                <div class="col-md-20 col-sm-19 col-xs-20">
                    <span class="plan-title">{{ $plan->title }}</span>
                    <a href="{{ route('plan.edit', $plan->id)}}" class="edit-plan" data-rel="{{ $plan->id }}" data-toggle="modal" data-target="#edit-plan-{{$plan->id}}" title="Edit DMP"><i class="fa fa-pencil"></i></a>
                    @if ($plan->version)
                        <br/>{{ $plan->version }}
                    @endif
                </div>
                <div class="col-md-3 col-sm-4 col-xs-4 text-right">
                    <span class="plan-status label label-as-badge {{ $plan->is_snapshot ? 'label-success' : 'label-default' }}">
                        @if( $plan->is_snapshot)
                            <i class="fa fa-lock"></i>&nbsp;
                        @endif
                        {{ $plan->survey->completion }}&nbsp;%
                    </span>
                </div>
            </div>
            <br/>
            <!-- BODY -->
            <div class="row">
                <div class="col-lg-17 col-md-17 col-sm-17 col-xs-17">
                    @unless( $plan->is_snapshot )
                        <a href="{{ URL::route('survey.edit', [$plan->survey->id]) }}" class="btn btn-default btn-xs" title="{{ trans('plan.info.button.edit') }}">
                            <i class="fa fa-pencil"></i><span class="hidden-sm hidden-xs"> {{ trans('plan.info.button.edit') }}</span>
                        </a>
                    @endunless
                    <a href="{{ URL::route('survey.show', [$plan->survey->id]) }}" class="btn btn-default btn-xs" title="{{ trans('plan.info.button.show') }}">
                        <i class="fa fa-eye"></i><span class="hidden-sm hidden-xs"> {{ trans('plan.info.button.show') }}</span>
                    </a>
                    <a href="#" class="email-plan btn btn-default btn-xs" data-rel="{{ $plan->id }}" data-toggle="modal" data-target="#email-plan" title="{{ trans('plan.info.button.email') }}">
                        <i class="fa fa-envelope-o"></i><span class="hidden-sm hidden-xs"> {{ trans('plan.info.button.email') }}</span>
                    </a>
                    <a href="#" class="export-plan btn btn-default btn-xs" data-rel="{{ $plan->id }}" data-toggle="modal" data-target="#export-plan" title="{{ trans('plan.info.button.export') }}">
                        <i class="fa fa-file-pdf-o"></i><span class="hidden-sm hidden-xs"> {{ trans('plan.info.button.export') }}</span>
                    </a>
                    @unless($plan->is_snapshot)
                        <a href="#" class="create-plan-snapshot btn btn-default btn-xs" data-rel="{{ $plan->id }}" data-toggle="modal" data-target="#create-plan-snapshot" title="{{ trans('plan.info.button.snapshot') }}">
                            <i class="fa fa-lock"></i><span class="hidden-xs"> {{ trans('plan.info.button.snapshot') }}</span>
                        </a>
                    @endunless
                </div>
                <div class="col-lg-7 col-md-7 col-sm-24 col-xs-24 text-right text-lg-right text-md-right text-sm-left text-xs-left">
                    @if( $plan->is_snapshot )
                        <strong>Snapshot:</strong> @date( $plan->updated_at ) at @time( $plan->updated_at )
                    @else
                        @if( $plan->created_at == $plan->updated_at )
                            <strong>Created:</strong> @date( $plan->updated_at ) at @time( $plan->updated_at )
                        @else
                            <strong>Updated:</strong> @date( $plan->updated_at ) at @time( $plan->updated_at )
                        @endif
                    @endif
                    &nbsp;&nbsp;&nbsp;
                    <a href="#" class="delete-plan" data-rel="{{ $plan->id }}" data-toggle="modal" data-target="#delete-plan" title="{{ trans('plan.info.button.delete') }}">
                        <i class="fa fa-trash"></i><span class="hidden-sm hidden-xs"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>