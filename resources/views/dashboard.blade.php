@extends('layouts.bootstrap')

@section('navigation')
    <li>{!! link_to_route( 'dashboard', 'Dashboard' ) !!}</li>
@stop

@section('headline')
    <!--<h1>Ihre Datenmanagementpläne</h1>-->
@stop

@section('body')

    <script>

        $(document).ready(function () {

            getVisibleProjects();

            function getVisibleProjects()
            {
                $('a.hide-plans').addClass('hidden');

                var opened = $.cookie('tub-dmp_dashboard' );
                var projects = opened.split(',');

                $('.dashboard-project-plans').filter(function() {
                    return $.inArray($(this).attr('data-content'), projects) > -1;
                }).removeClass('hidden');

                $('a.show-plans').filter(function() {
                    return $.inArray($(this).attr('data-href'), projects) > -1;
                }).addClass('hidden');

                $('a.hide-plans').filter(function() {
                    return $.inArray($(this).attr('data-href'), projects) > -1;
                }).removeClass('hidden');
            }


            function setVisibleProjects()
            {
                var open = [];
                $('tr.dashboard-project-plans').not('.hidden').each(function(index, item){
                    open.push($(this).data('content'));
                });
                $.cookie('tub-dmp_dashboard', open);
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
                        console.log(json.responseJSON);
                        div.modal();
                    },
                    success : function (json) {
                        console.log(json);
                        if (json.response === 200) {
                            div.modal('hide');
                            form.find("#message").val('').end();
                        }
                    }
                })
            });


            $('a.show-plans').bind('click', function (e) {
                e.preventDefault();
                //console.log($(this).data('href'));
                var project_id  = $(this).data('href');
                var show_link   = $(this).filter(function(){
                    return $(this).data('href') === project_id
                });
                var hide_link   = $('a.hide-plans').filter(function(){
                    return $(this).data('href') === project_id
                });

                //show_link.hide();
                //hide_link.show();
                $('tr[data-content=' + project_id + ']').removeClass('hidden');
                setVisibleProjects();
            });

            $('a.hide-plans').bind('click', function (e) {
                e.preventDefault();
                var project_id = $(this).data('href');
                var show_link   = $('a.show-plans').filter(function(){
                    return $(this).data('href') === project_id
                });
                var hide_link   = $(this).filter(function(){
                    return $(this).data('href') === project_id
                });

                hide_link.hide();
                show_link.show();

                $('tr[data-content=' + project_id + ']').addClass('hidden');
                setVisibleProjects();
            });


            $('a.edit-project').bind('click', function (e) {
                e.preventDefault();

                var form    = $('#edit-project-form');
                var div     = form.parent();

                $.ajax({
                    type    : 'GET',
                    url     : '/my/project/' + $(this).data('rel') + '/show',
                    dataType: 'json',
                    success : function (json) {
                        $.each(json, function (field, value) {
                            form.find('#' + field).val(value);
                        });
                        div.modal();
                    }
                });
            });

            /*
            $('#edit-project-form').bind('submit', function (e) {
                e.preventDefault();

                var form    = $(this);
                var div     = $(this).parent();

                $.ajax({
                    url     : form.attr('action'),
                    type    : form.attr('method'),
                    data    : form.serialize(),
                    dataType: 'json',
                    error   : function (json) {
                        console.log(json.responseJSON);
                        div.modal();
                    },
                    success : function (json) {
                        if (json.response == 200) {
                            div.modal('hide');
                            location.reload();
                        }
                    }
                })
            });
            */

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
                        console.log(json.responseJSON);
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
                        console.log(json.responseJSON);
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
                        console.log(json.responseJSON);
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
                        console.log(json.responseJSON);
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
                        @foreach ($projects as $project)
                            @include('partials.project.info', $project)
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('partials.project.modal')
    @include('partials.plan.modal')

@stop