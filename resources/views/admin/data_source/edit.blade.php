@extends('layouts.bootstrap')

@section('headline')
    <h1>Admin: TUB-DMP</h1>
@stop

@section('title')
    Edit Data Source "{{ $data_source->name }}"
@stop

@section('body')

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Edit Data Source "{{ $data_source->name }}"
        </div>
        <div class="panel-body">
            <div class="row">
                {!! Form::model($data_source, ['method' => 'PUT', 'route' => ['admin.data_source.update', $data_source->id], 'class' => '', 'role' => 'form']) !!}
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label('name', 'Name') !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text('name', $data_source->name, ['class' => 'form-control xs']) !!}
                            <span class="help-block {{ ($errors->first('name') ? 'form-error' : '') }}">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label('identifier', 'Identifier') !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text('identifier', $data_source->identifier, ['class' => 'form-control xs']) !!}
                            <span class="help-block {{ ($errors->first('identifier') ? 'form-error' : '') }}">{{ $errors->first('identifier') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label('type', 'Type') !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text('type', $data_source->type, ['class' => 'form-control xs', 'read-only']) !!}
                            <span class="help-block {{ ($errors->first('type') ? 'form-error' : '') }}">{{ $errors->first('type') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label('uri', 'URI') !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text('uri', $data_source->uri, ['class' => 'form-control xs', 'read-only']) !!}
                            <span class="help-block {{ ($errors->first('uri') ? 'form-error' : '') }}">{{ $errors->first('uri') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            {!! Form::Label('description', 'Description') !!}
                        </div>
                        <div class="col-md-10">
                            {!! Form::Text('description', $data_source->description, ['class' => 'form-control xs']) !!}
                            <span class="help-block {{ ($errors->first('description') ? 'form-error' : '') }}">{{ $errors->first('description') }}</span>
                        </div>
                    </div>
                    <div class="form-group row container">
                        <div class="col-md-2">
                            &nbsp;
                        </div>
                        <div class="col-md-10">
                            {!! Form::submit('Update', array('class' => 'button btn btn-success')) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop