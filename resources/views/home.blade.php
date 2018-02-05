@extends('layouts.home')

@section('body')

    @include('partials.layout.login')

    @if(env('APP_SERVER') == 'test')
        @include('partials.layout.testsystem.box')
    @endif

@stop