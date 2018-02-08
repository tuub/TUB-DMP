@extends('layouts.home')

@section('body')

    @include('partials.layout.login')

    @if (env('DEMO_MODE'))
        @include('partials.layout.demosystem.box')
    @endif

@stop