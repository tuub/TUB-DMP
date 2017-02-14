@extends('layouts.bootstrap')

@section('header_assets')
    @parent
    {!! HTML::script('js/plan.js') !!}
@append

@section('navigation')
    <li>{!! link_to_route( 'dashboard', 'Back to Dashboard' ) !!}</li>
@append

@section('headline')
    <h3>Random IVMC-Data</h3>
@stop

@section('body')
    <div class="row">
        @foreach( $records as $record )
            <ul>
                @foreach( $record as $key => $value )
                    <li><strong>{{ $key }} :</strong> {{ $value }}</li>
                @endforeach
            </ul>
            <hr/>
            ***************************************
            <hr/>
        @endforeach
    </div>
@stop