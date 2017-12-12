@extends('layouts.bootstrap')

@section('headline')
@stop

@section('title')
@stop

@section('body')

    @includeWhen($question, 'admin.question.form', [
        'question' => $question,
        'template' => $template,
        'mode' => 'create',
        'action' => 'store',
        'method' => 'POST',
    ])

@stop
    
