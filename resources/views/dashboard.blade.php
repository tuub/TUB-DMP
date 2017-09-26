@extends('layouts.bootstrap')

@section('navigation')
    <li>{!! link_to_route( 'dashboard', 'Dashboard' ) !!}</li>
@stop

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
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ trans('project.request.title') }}</a>
                </a>
            </div>
            <br/>
            @foreach ($projects as $project)
                @include('partials.project.infocard', $project)
                @include('partials.project.modal', $project)
            @endforeach
        </div>
    </div>
@stop