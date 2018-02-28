@extends('layouts.bootstrap')

@section('headline')
@stop

@section('body')
    <div class="panel">
        <div class="panel-heading text-center">
            <h1>{{ trans('dashboard.header') }}</h1>
        </div>
        <div class="panel-body">
            <div class="text-center">
                <a href="#" class="project-request btn btn-success btn-success btn-xl large-text" data-toggle="modal" data-target="#project-request" title="{{ trans('project.request.title') }}">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    @if ($projects->count() == 0)
                        {{ trans('dashboard.request.first') }}
                    @else
                        {{ trans('dashboard.request.another') }}
                    @endif
                </a>
                <br/><br/>
                <p>
                    {!! trans('project.request.subtitle') !!}
                </p>
            </div>
            <br/>
            @foreach ($projects as $project)
                @include('partials.project.info', $project)
                @include('partials.project.modal', $project)
            @endforeach
        </div>
    </div>
@stop