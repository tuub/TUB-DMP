/*global $, Modernizr, console */
/*jslint browser:true */

$(document).ready(function ()
{
    'use strict';

    /* Make sure that the privacy statements on login page aren't check (looking at you, Chrome!) */
    $('#login-form div.checkbox input').attr('checked', false);
 

    /**
     * Read open state of project's plan panel from cookie value
     */
    getVisibleProjects();


    /**
     * Gets the state of project's plan panel based on project_id from
     * cookie values and toggles the plus/minus buttons, located in
     * resources/views/partials/project/info.php
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
            }).find('i').toggleClass('fa-caret-down fa-caret-up');
        }
    }


    /**
     * Sets the state of project's plan panel based on project_id from
     * cookie values and toggles the plus/minus buttons, located in
     * resources/views/partials/partials/project/info.php
     */
    function setVisibleProjects()
    {
        var open = [];
        $('div.dashboard-project-plans').not('.hidden').each(function(){
            open.push($(this).data('content'));
        });
        $.cookie('tub-dmp_dashboard', open);
    }


    /**
     * Reads in JSON error messages and returns them as unordered alert-styled list
     *
     * @param {Json} json
     * @param {String} json.responseJSON
     *
     * @return {String} errorsHtml
     */
    function showAjaxErrors(json)
    {
        var errors = json.responseJSON.errors;
        var errorsHtml = '<ul>';
        $.each( errors , function( key, value ) {
            errorsHtml += '<li>' + value[0] + '</li>';
        });
        errorsHtml += '</ul>';
        return errorsHtml;
    }


    function hasValue(nodes, value) {
        var deletes = [];
        nodes.each(function() {
            if ($(this).val() === value || $(this).attr('title') === value ) {
                deletes.push($(this).val());
            }
        });
        return deletes.length > 0;
    }

    function areYouSure() {
        if (!confirm("DELETE: Are You Sure?")) {
            event.preventDefault();
        }
    }

    $('.btn').bind('click', function(e){
        if (hasValue($(this),'Delete') ) {
            areYouSure();
        }
    });

    /**
     * Ensures that every Ajax request includes the CSRF token from the page metadata
     *
     * @param {Json} json
     *
     * @return {String} errorsHtml
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * Builds the section tabs for survey edit
     * FIXME: Was not working in survey.js anymore after switch to webpack mix
     *
     * @param {Json} json
     *
     * @return {String} errorsHtml
     */
    $("#plan-section-steps").steps({
        headerTag: "h4",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        enableAllSteps: true,
        saveState: true,
        enablePagination: false,
        titleTemplate: '#title#',
        stepsOrientation: 1,
        transitionEffectSpeed: 100,
        onStepChanging: function (event, currentIndex, newIndex) {
            if($(window).scrollTop() > 0) {
                $('html, body').animate({
                    scrollTop:0
                }, 300);
            }
            return true;
        },
    });


    /**
     * Serializes the feedback form and passes the form data to controller method
     *
     * @param {Json} json
     *
     * @return {String} errorsHtml FIXME
     */
    $('#feedback-form').bind('submit', function (e)
    {
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
        });
    });


    /**
     * Validate the privacy statements at login page.
     *
     * @param {Json} json
     *
     * @return {String} errorsHtml
     */
    $('#login-form').bind('submit', function (e)
    {
        if ($(this).find('input').not(':checked').length > 0) {
            e.preventDefault();
            alert('Please check the privacy statements!');
        }
    });

    /**
     * Serializes the project request form and passes the form data to controller method.
     * If successsful, close the modal and reload the page. Otherwise errors in modal.
     *
     * @param {Json} json
     *
     * @return {String} errorsHtml FIXME
     */
    $('#project-request-form').bind('submit', function (e) {
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


    /**
     * Sets the state of project's plan panel based on project_id from
     * cookie values and toggles the plus/minus buttons, located in
     * partials/project/info.php
     */
    $('a.toggle-plans').bind('click', function (e) {
        e.preventDefault();

        var project_id  = $(this).data('href');
        var toggleState = ($(this).find('i').hasClass('fa-caret-down')) ? 'open' : 'closed';

        if( toggleState === 'open' ) {
            $(this).find('i').removeClass('fa-caret-down').addClass('fa-caret-up');
            $('div[data-content=' + project_id + ']').removeClass('hidden');
        } else {
            $(this).find('i').removeClass('fa-caret-up').addClass('fa-caret-down');
            $('div[data-content=' + project_id + ']').addClass('hidden');
        }

        setVisibleProjects();
    });



    /**
     * Create Plan
     *
     * While modal is loaded, the project's show method is called and the returning json attribute
     * "id" is then injected into the hidden input field in the form.
     *
     * FIXME: do we really need this? find a non js way.
     *
     * @return {Json} json
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

    /**
     * Create Plan
     *
     * Serializes the creatw plan form and passes the form data to controller method.
     * If successsful, close the modal and reload the page. Otherwise errors in modal.
     * *
     * @return {Json} json
     */
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

    /**
     * Edit Plan
     *
     * While modal is loaded, the plan's show method is called and the returning json attribute
     * "id" is then injected into the hidden input field in the form.
     *
     * FIXME: do we really need this? find a non js way.
     *
     * @return {Json} json
     */

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
        });
    });


    $('a.create-plan-snapshot').bind('click', function (e) {
        e.preventDefault();

        var form    = $('#create-plan-snapshot-form');
        var div     = form.parent();

        $.ajax({
            type    : 'GET',
            url     : '/plan/' + $(this).data('rel') + '/show',
            dataType: 'json',
            success : function (json) {
                form.find('#id').val(json.id);
                form.find('#project_id').val(json.project_id);
                form.find('#title').val(json.title);
                form.find('#version').val('');
                div.modal();
            }
        });
    });

    $('#create-plan-snapshot-form').bind('submit', function (e) {
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
                if (json.response === 200) {
                    div.modal('hide');
                    form.find("#message").val('').end();
                }
            }
        });
    });


    $('a.export-plan').bind('click', function (e) {
        e.preventDefault();

        //var form    = $('#export-plan-form');
        var plan_id = $(this).data('rel');
        var div     = $('div#export-plan-' + plan_id);

        $.ajax({
            type    : 'GET',
            url     : '/plan/' + plan_id + '/show',
            dataType: 'json',
            error   : function () {
                div.modal();
            },
            success : function () {
                div.modal();
            }
        });
    });

    $('a.delete-plan').bind('click', function (e) {
        e.preventDefault();

        var plan_id = $(this).data('rel');
        var div     = $('div#delete-plan-' + plan_id);

        $.ajax({
            type    : 'GET',
            url     : '/plan/' + plan_id + '/show',
            dataType: 'json',
            error   : function () {
                div.modal();
            },
            success : function () {
                div.modal();
            }
        });
    });

    $('form.delete-plan-form').on('submit', function (e) {
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
                if (json.response === 200) {
                    div.modal('hide');
                    location.reload();
                }
            }
        });
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
            error   : function () {
                div.modal();
            },
            success : function () {
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
            error   : function () {
                div.modal();
            },
            success : function (json) {
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
                if (json.response === 200) {
                    div.modal('hide');
                    location.reload();
                }
            }
        });
    });


    $('a.import-project').bind('click', function (e) {
        e.preventDefault();

        var project_id  = $(this).data('rel');

        $.ajax({
            type    : 'GET',
            url     : '/my/project/' + project_id + '/import',
            dataType: 'json',
            error   : function (json) {
                console.log(json.responseText);
            },
            success : function (json) {
                if (json.response === 200) {
                    location.reload();
                }
            }
        });
    });


    $('.modal')
        .on('click', '.add-form-group', function(e){
            e.preventDefault();
            //var project_id = $(this).data('rel');

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
        })
        .on('click', '.remove-form-group', function(e){
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
        });


    if (!Modernizr.inputtypes.date) {
        $('input[type=date]').datepicker(
            { dateFormat: 'mm/dd/yy' }
        );
    }
});


$( window ).on('load', function() {

    'use strict';

    /* Uncheck Login Privacy Statement Checkboxes by default */
    $('#login-form').find(['type="checkbox"']).removeAttr('checked');
    //$('.checkbox input').prop('checked', false);

    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });

    /* Do not submit empty/hashy HREFs */
    $('a[href=\\#]').click(function(e) {
        if (e) { e.preventDefault(); }
    });

    $('.progress .progress-bar').progressbar({
        display_text: 'fill'
        //display_text: 'center'
        //,refresh_speed: 200
    });

    $('.dropdown-toggle').dropdown();

    /*
    $('input.slider').slider({
        tooltip: 'hide'
    }).on('slide', function(slideEvt)
    {
        $(this).parent().next('span.slider-value').html(slideEvt.value);
    });

    $('input.slider-range').slider({
        tooltip: 'hide'
    }).on('slide', function(slideEvt)
    {
        $(this).parent().siblings('input.slider-range-input-alpha').val(slideEvt.value[0]).next('input.slider-range-input-omega').val(slideEvt.value[1]);
        $(this).parent().siblings('span.slider-range-display-alpha').html(slideEvt.value[0]).next('span.slider-range-display-omega').html(slideEvt.value[1]);
    });
    */
});
