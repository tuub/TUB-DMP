@extends('layouts.bootstrap')

@section('navigation')
    <li>{{ link_to_route( 'dashboard', 'Zurück' ) }}</li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Datenmanagementplan <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>{{ link_to_route( 'admin.dashboard', 'Zurück zur Übersicht' ) }}</li>
        </ul>
    </li>
@stop

@section('headline')
    <h1>Admin: TUB-DMP</h1>
    <h3>Lookup</h3>
@stop

@section('title')

@stop

@section('body')

    <script>
        $(document).ready(function(){
            $('#lookup-form').on('submit', function(e) {
                e.preventDefault();

                var form    = $(this);
                form.find('textarea[name=output]').val('');
                var output = '';

                $.ajax({
                    url     : form.attr('action'),
                    type    : form.attr('method'),
                    data    : form.serialize(),
                    dataType: 'json',
                    error   : function (json) {
                        console.log(json);
                        //form.children().find('.errors').html( showAjaxErrors(json) );
                    },
                    success : function (json) {
                        if (json.status === 200) {
                            $.each(json.data, function(namespace,values) {
                                output += '-'.repeat(75) + '\n' + namespace + '\n' + '-'.repeat(75) + '\n\n';
                                $.each($.parseJSON(values), function(key,value) {
                                    for (var property in value) {
                                        // skip loop if the property is from prototype
                                        if(!value.hasOwnProperty(property)) continue;
                                        output += property + ': ' + value[property] + '\n';
                                    }
                                    output += '\n';
                                });
                            });
                        } else {
                            output += json;
                        }
                        form.find('textarea[name=output]').val(function(i, text) {
                            return text + output;
                        });
                    }
                });
            });
        });
    </script>

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Lookup Project Identifier
        </div>
        <div class="panel-body">
            {!! Form::open(['method' => 'POST', 'id' => 'lookup-form', 'route' => ['admin.project.post_lookup'], 'class' => '', 'role' => 'form']) !!}
            <div class="form-group row container">
                <div class="col-md-3">
                    {!! Form::Label( 'identifier', 'Project Identifier' ) !!}
                </div>
                <div class="col-md-7">
                    {!! Form::Text( 'identifier', null, array('class' => 'form-control xs') ) !!}
                    <span class="help-block {{ ($errors->first('identifier') ? 'form-error' : '') }}">{{ $errors->first('identifier') }}</span>
                </div>
                <div class="col-md-4">
                    {!! Form::select('data_source', $data_sources, 1, array('class' => 'form-control') ) !!}
                    <span class="help-block {{ ($errors->first('data_source') ? 'form-error' : '') }}">{{ $errors->first('data_source') }}</span>
                </div>
                <div class="col-md-2">
                    {!! Form::submit('Query Datasource', array('class' => 'button btn btn-success' )) !!}
                </div>
            </div>
            <div class="row form-group container">
                <div class="col-md-3">
                    {!! Form::label('output', 'Output', array('class' => 'control-label')) !!}
                </div>
                <div class="col-md-20">
                    {!! Form::Textarea( 'output', null, array('class' => 'form-control xs', 'readonly' => 'readonly') ) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop