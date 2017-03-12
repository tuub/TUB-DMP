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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('a.show-plans').bind('click', function (e) {
                e.preventDefault();
                $(this).hide();
                $('a.hide-plans').show();
                $('tr[data-content=' + $(this).data('href') + ']').removeClass('hidden');
            })

            $('a.hide-plans').bind('click', function (e) {
                e.preventDefault();
                $(this).hide();
                $('a.show-plans').show();
                $('tr[data-content=' + $(this).data('href') + ']').addClass('hidden');
            })

            $('a.create-plan').bind('click', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: '<?=URL::to('/')?>/project/' + $(this).data('rel') + '/show',
                    dataType:'json',
                    success: function(result) {
                        $('#create-plan-form #project_id').val(result.id);
                        $('#create-plan').modal();
                    }
                });
            })

            $('#create-plan-form').bind('submit', function (e) {
                e.preventDefault();
                var datastring = $('#create-plan-form').serialize();
                $.ajax({
                    type: 'POST',
                    url: '<?=URL::to('/')?>/plan/store',
                    data: datastring,
                    dataType:'json',
                    error: function(result) {
                        console.log(result);
                        //$('#edit-plan').modal();
                    },
                    success: function(result) {
                        if( result.response == '200' ) {
                            //$('#edit-form').html('Saved!');
                            $('#edit-plan').modal('hide');
                            //$('div#plan-1').hide().html('goo').fadeIn(1000);
                            //$('div#plan-1').fadeOut(800, function(){
                            //    $(this).html(result.msg).fadeIn().delay(2000);
                            //});
                            location.reload();
                        }
                    }
                });
            })

            $('a.edit-plan').bind('click', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: '<?=URL::to('/')?>/plan/' + $(this).data('rel') + '/show',
                    dataType:'json',
                    success: function(result) {
                        $.each(result, function(field, value) {
                            $('#edit-plan-form #' + field).val(value);//name is database field name such as id,name,address etc
                        });
                        console.log(result);
                        $('#edit-plan').modal();
                    }
                });
            })

            $('#edit-plan-form').bind('submit', function (e) {
                e.preventDefault();
                //var plan_id = $('#edit-plan-form #id').val();
                var datastring = $('form#edit-plan-form').serialize();
                $.ajax({
                    type: 'POST',
                    url: '<?=URL::to('/')?>/plan/update',
                    data: datastring,
                    dataType:'json',
                    error: function(result) {
                        console.log(result);
                        //$('#edit-plan').modal();
                    },
                    success: function(result) {
                        if( result.response == '200' ) {
                            //$('#edit-form').html('Saved!');
                            $('#edit-plan').modal('hide');
                            //$('div#plan-1').hide().html('goo').fadeIn(1000);
                            //$('div#plan-1').fadeOut(800, function(){
                            //    $(this).html(result.msg).fadeIn().delay(2000);
                            //});
                            location.reload();
                        }
                    }
                });

            })
        })
    </script>

    <style>

        a.hide-plans {
            display: none;
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
                            <th style="width: 25%">Metadata</th>
                            <th style="width: 20%;">Members</th>
                            <th style="width: 5%;">Plans</th>
                            <th style="width: 5%;">Projects</th>
                            <th style="width: 15%;">Data Source</th>
                            <th>Status</th>
                            <th>&nbsp;</th>
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

    @include('partials.plan.modal')

@stop