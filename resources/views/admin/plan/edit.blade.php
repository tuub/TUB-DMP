@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    @includeWhen($plan, 'admin.plan.form', [
        'plan' => $plan,
        'mode' => 'edit',
        'action' => 'update',
        'method' => 'POST',
        'return_route' => $return_route
    ])

@stop