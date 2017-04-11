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
             * Read open state of project's plan panel from cookie value
             */
            getVisibleProjects();


            /**
             * Gets the state of project's plan panel based on project_id from
             * cookie values and toggles the plus/minus buttons, located in
             * partials/project/info.php
             */
            function getVisibleProjects()
            {
                $('a.hide-plans').addClass('hidden');
                if (!$.cookie('tub-dmp_dashboard')) {
                    setVisibleProjects();
                } else {
                    var opened = $.cookie('tub-dmp_dashboard');
                    var projects = opened.split(',');
                    $('.dashboard-project-plans').filter(function () {
                        return $.inArray($(this).attr('data-content'), projects) > -1;
                    }).removeClass('hidden');
                    $('a.toggle-plans').filter(function () {
                        return $.inArray($(this).attr('data-href'), projects) > -1;
                    }).find('i').toggleClass('fa-plus fa-minus');
                }
            }


            /**
             * Sets the state of project's plan panel based on project_id from
             * cookie values and toggles the plus/minus buttons, located in
             * partials/project/info.php
             */
            function setVisibleProjects()
            {
                var open = [];
                $('tr.dashboard-project-plans').not('.hidden').each(function(index, item){
                    open.push($(this).data('content'));
                });
                $.cookie('tub-dmp_dashboard', open);
            }






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


            /**
             * Ensures that every Ajax request includes the CSRF token from the page metadata
             * @param {Json} json
             * @return {String} errorsHtml
             */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            /**
             * Serializes the feedback form and passes the form data to controller method
             * @param {Json} json
             * @return {String} errorsHtml
             */
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


            /**
             * Sets the state of project's plan panel based on project_id from
             * cookie values and toggles the plus/minus buttons, located in
             * partials/project/info.php
             */
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

            $('a.show-project').bind('click', function (e) {
                e.preventDefault();

                //var form    = $('#show-project-form');
                var project_id  = $(this).data('rel');//form.parent();
                var div         = $('#show-project-' + project_id);//form.parent();

                $.ajax({
                    type    : 'GET',
                    url     : '/my/project/' + project_id + '/show',
                    dataType: 'json',
                    error   : function (json) {
                        //console.log(json);
                        div.modal();
                    },
                    success : function (json) {
                        //$.each(json, function (field, value) {
                        //    form.find('#' + field).val(value);
                        //});
                        div.modal();
                    }
                });
            });


            $('a.edit-project').bind('click', function (e) {
                e.preventDefault();

                var project_id  = $(this).data('rel');
                var div     = $('#edit-project-' + project_id);
                var form    = div.find('#edit-project-form');

                $.ajax({
                    type    : 'GET',
                    url     : '/my/project/' + $(this).data('rel') + '/show',
                    dataType: 'json',
                    error   : function (json) {
                        div.modal();
                    },
                    success : function (json) {
                        //form.find("input, textarea, select").val('').end();
                        $.each(json, function (field, value) {
                            form.find('#' + field).val(value);
                        });
                        div.modal();
                    }
                });
            });




            $('form.edit-project-form').on('submit', function (e) {
                e.preventDefault();

                var form    = $(this);
                var div     = $(this).closest('modal');

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
                        console.log(json);
                        if (json.response == 200) {
                            div.modal('hide');
                            location.reload();
                        }
                    }
                })

            });



            $('.modal').on('click', '.add-form-group', function(e){
                e.preventDefault();
                var project_id = $(this).data('rel');

                //var form = $(this).parents('div#edit-project-' + project_id).find('form');
                var current_form_group = $(this).closest('.form-group');
                current_form_group.find('button.remove-form-group').remove();
                var next_form_group = current_form_group.clone();
                var current_index = current_form_group.data('rel');
                var next_index = current_index + 1;
                var plus_button = current_form_group.children().last().find('button');

                next_form_group.attr('data-rel', next_index);

                /* Adjust array name index to next iterator and reset (cloned) values in new form group */
                next_form_group.children().find('input, select, textarea').each(function(index, element){
                    $(element).attr('name', $(element).attr('name').replace(current_index, next_index));
                    $(element).attr('value', '');
                    $(element).val('');
                });

                /* Create minus button from plus button */
                var minus_button = plus_button.clone();
                minus_button.removeClass('add-form-group')
                    .addClass('remove-form-group')
                    .find('i.fa')
                    .removeClass('fa-plus').addClass('fa-minus')
                    .end();

                /* Change plus button to minus button in current form group */
                current_form_group.find('button.add-form-group').removeClass('add-form-group').addClass('remove-form-group');
                current_form_group.find('i.fa').removeClass('fa-plus').addClass('fa-minus');

                /* Insert minus button before plus button in next form group */
                minus_button.insertBefore(next_form_group.find('button.add-form-group'));
                /* ... */

                /* Finally, add the fresh new form group after the last form group */
                next_form_group.insertAfter(current_form_group);
            });

            $('.modal').on('click', '.remove-form-group', function(e){
                e.preventDefault();

                /* Get the current form group and grep its buttons */
                var current_form_group = $(this).closest('.form-group');
                var buttons = current_form_group.find('button');
                buttons.first().append('&nbsp;');

                /* Get the previous form group, replace its buttons with the grepped buttons */
                var previous_form_group = current_form_group.prev();
                previous_form_group.find('button').remove();
                previous_form_group.children().last().append(buttons);

                /* Finally, remove the current form group */
                current_form_group.remove();
            })

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
                @foreach ($project->children as $project)
                    @include('partials.project.modal', $project)
                @endforeach
            @endforeach

            <div class="table-responsive">
                <table class="table table-fixed">
                    <thead>
                        <tr>
                            <th style="width: 40%">Project</th>
                            <th style="width: 20%;">Members</th>
                            <th style="width: 5%;">Plans</th>
                            <th style="width: 10%;">Data Source</th>
                            <th style="width: 10%;">Status</th>
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