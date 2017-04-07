@extends('layouts.bootstrap')

@section('navigation')
    <li>{!! link_to_route( 'dashboard', 'Dashboard' ) !!}</li>
@stop

@section('headline')
    <!--<h1>Ihre Datenmanagementpläne</h1>-->
@stop

@section('body')

    <script>

        $(document).ready(function ()
        {
           /**
            * Reads in JSON error messages and returns them as unordered alert-styled list
            * @param {Json} json
            * @return {String} errorsHtml
            */
            function showAjaxErrors(json)
            {
                var errors = json.responseJSON;
                var errorsHtml = '<ul>';
                $.each( errors , function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul>';
                return errorsHtml;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#feedback-form').bind('submit', function (e) {
                e.preventDefault();

                var form    = $(this);
                var div     = $(this).parent();

                $.ajax({
                    url     : form.attr('action'),
                    type    : form.attr('method'),
                    data    : form.serialize(),
                    dataType: 'json',
                    error   : function (json) {
                        form.children().find('.errors').html( showAjaxErrors(json) );
                        div.modal();
                    },
                    success : function (json) {
                        if (json.response === 200) {
                            // http://stackoverflow.com/questions/13177426/how-to-destroy-bootstrap-modal-window-completely/18169689
                            div.modal('hide');
                            form.find("#message").val('').end();
                        }
                    }
                })
            });

            $('a.toggle-plans').bind('click', function (e) {
                e.preventDefault();
                var project_id  = $(this).data('href');
                var toggleState = ($(this).find('i').hasClass('fa-plus')) ? 'open' : 'closed';

                if( toggleState === 'open' ) {
                    $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
                    $('tr[data-content=' + project_id + ']').removeClass('hidden');
                } else {
                    $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
                    $('tr[data-content=' + project_id + ']').addClass('hidden');
                }

                setVisibleProjects();
            });





            $('a.create-plan').bind('click', function (e) {
                e.preventDefault();

                var form    = $('#create-plan-form');
                var div     = form.parent();

                $.ajax({
                    type    : 'GET',
                    url     : '/my/project/' + $(this).data('rel') + '/show',
                    dataType: 'json',
                    success : function (json) {
                        form.find('#project_id').val(json.id);
                        div.modal();
                    }
                });
            });

            $('#create-plan-form').bind('submit', function (e) {
                e.preventDefault();

                var form    = $(this);
                var div     = $(this).parent();

                $.ajax({
                    url     : form.attr('action'),
                    type    : form.attr('method'),
                    data    : form.serialize(),
                    dataType: 'json',
                    error   : function (json) {
                        form.children().find('.errors').html( showAjaxErrors(json) );
                        div.modal();
                    },
                    success : function (json) {
                        if (json.response === 200) {
                            div.modal('hide');
                            location.reload();
                        }
                    }
                });
            });

            $('a.edit-plan').bind('click', function (e) {
                e.preventDefault();

                var form    = $('#edit-plan-form');
                var div     = form.parent();

                $.ajax({
                    type    : 'GET',
                    url     : '/plan/' + $(this).data('rel') + '/show',
                    dataType: 'json',
                    success : function (json) {
                        $.each(json, function (field, value) {
                            form.find('#' + field).val(value);
                        });
                        div.modal();
                    }
                });
            });

            $('#edit-plan-form').bind('submit', function (e) {
                e.preventDefault();

                var form    = $(this);
                var div     = $(this).parent();

                $.ajax({
                    url     : form.attr('action'),
                    type    : form.attr('method'),
                    data    : form.serialize(),
                    dataType: 'json',
                    error   : function (json) {
                        form.children().find('.errors').html( showAjaxErrors(json) );
                        div.modal();
                    },
                    success : function (json) {
                        if (json.response === 200) {
                            div.modal('hide');
                            location.reload();
                        }
                    }
                })
            });

            $('a.create-plan-version').bind('click', function (e) {
                e.preventDefault();

                var form    = $('#create-plan-version-form');
                var div     = form.parent();

                $.ajax({
                    type    : 'GET',
                    url     : '/plan/' + $(this).data('rel') + '/show',
                    dataType: 'json',
                    success : function (json) {
                        form.find('#id').val(json.id);
                        form.find('#project_id').val(json.project_id);
                        form.find('#next_version_id').val(json.version + 1);
                        form.find('span#current-version').html(json.version);
                        form.find('span#next-version').html(json.version + 1);
                        div.modal();
                    }
                });
            });

            $('#create-plan-version-form').bind('submit', function (e) {
                e.preventDefault();

                var form    = $(this);
                var div     = $(this).parent();

                $.ajax({
                    url     : form.attr('action'),
                    type    : form.attr('method'),
                    data    : form.serialize(),
                    dataType: 'json',
                    error   : function (json) {
                        form.children().find('.errors').html( showAjaxErrors(json) );
                        div.modal();
                    },
                    success : function (json) {
                        console.log(json.msg);
                        if (json.response === 200) {
                            div.modal('hide');
                            location.reload();
                        }
                    }
                })
            });

            $('a.email-plan').bind('click', function (e) {
                e.preventDefault();

                var form    = $('#email-plan-form');
                var div     = form.parent();

                $.ajax({
                    type    : 'GET',
                    url     : '/plan/' + $(this).data('rel') + '/show',
                    dataType: 'json',
                    success : function (json) {
                        form.find('#id').val(json.id);
                        form.find('#project_id').val(json.project_id);
                        form.find('#version').val(json.version);
                        div.modal();
                    }
                });
            });

            $('#email-plan-form').bind('submit', function (e) {
                e.preventDefault();

                var form    = $(this);
                var div     = $(this).parent();

                $.ajax({
                    url     : form.attr('action'),
                    type    : form.attr('method'),
                    data    : form.serialize(),
                    dataType: 'json',
                    error   : function (json) {
                        form.children().find('.errors').html( showAjaxErrors(json) );
                        div.modal();
                    },
                    success : function (json) {
                        console.log(json.msg);
                        if (json.response === 200) {
                            div.modal('hide');
                            form.find("#message").val('').end();
                        }
                    }
                })
            });
        });



    </script>

    <style>

        .input-with-language > .form-control {
            width: 50%;
        }


        a.hide-plans {
            /*display: none;*/
        }

        .hidden {
            visibility: hidden;
            over-flow: hidden;
            width: 0px;
            height: 0px;
        }

        div.dashboard-plan-info {
            font-style: italic;
        }

        div.dashboard-plan-info div.version {
            margin-top: 10px !important;
        }

        div.dashboard-plan-create-new {
            line-height:100px;
        }





    </style>

    <div class="panel panel-default">
        <div class="panel-heading text-center">
            {{ trans('dashboard.my-plans-header') }}
        </div>
        <div class="panel-body">

            @foreach ($projects as $project)
                @include('partials.project.modal', $project)
            @endforeach

            <div class="table-responsive">
                <table class="table table-fixed">
                    <thead>
                        <tr>
                            <th style="width: 15%">Project</th>
                            <th style="width: 35%">Metadata</th>
                            <th style="width: 20%;">Members</th>
                            <th style="width: 5%;">Plans</th>
                            <th style="width: 5%;">Projects</th>
                            <th style="width: 10%;">Data Source</th>
                            <th>Status</th>
                            <th style="width: 10%;">Tools</th>
                            <th style="width: 5%;">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @foreach ($projects as $project)
                                    @include('partials.project.info', $project)
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @include('partials.plan.modal')

@stop