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
            @foreach ($projects as $project)
                @include('partials.project.infocard', $project)
                @include('partials.project.modal', $project)
            @endforeach
        </div>
    </div>
@stop