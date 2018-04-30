/*global $, Modernizr, console */
/*jslint browser:true */

$(document).ready(function ()
{
    'use strict';

    /* Display toastr notifications from AJAX calls who are saved in localStorage */
    if(localStorage.getItem('flash-status')) {
        toastr[localStorage.getItem('flash-type')](localStorage.getItem('flash-message'));
        localStorage.clear();
    }

    /* Make sure that the privacy statements on login page aren't check (looking at you, Chrome!) */
    $('#login-form div.checkbox input').attr('checked', false);

    /* http://bootstrapswitch.com/options.html */
    $('form input[type=checkbox]').not('.classic').bootstrapSwitch({
        size: 'mini',
        onText: 'Yes',
        onColor: 'success',
        offText: 'No',
        offColor: 'default',
    });

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
            let opened = $.cookie('tub-dmp_dashboard');
            let projects = opened.split(',');
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
        let open = [];
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
        let errors = json.responseJSON.errors;
        let errorsHtml = '<ul>';
        $.each( errors , function( key, value ) {
            errorsHtml += '<li>' + value[0] + '</li>';
        });
        errorsHtml += '</ul>';
        return errorsHtml;
    }


    function hasValue(nodes, value) {
        let deletes = [];
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

    /* Prevent Form Submission by Enter Key,
     * except for
     * - ENTERs in Tags Input Fields
     * - Demo Login Form
     */
    $('form:not(#demo-login-form) input').not('div.tagsinput input').on('keyup keypress', function(e) {
        let code = e.keyCode || e.which;
        if (code === 13) {
            e.preventDefault();
            return false;
        }
    });

    /**
     * Focus on username input in #demo-login-form
     */
    $("form#demo-login-form input#username").focus();

    /**
     * Builds the section tabs for survey edit
     * FIXME: Was not working in survey.js anymore after switch to webpack mix
     *
     * @param {Json} json
     *
     * @return {String} errorsHtml
     */
    $("#plan-section-steps").steps({
        headerTag: "div.section-title",
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

        let form    = $(this);
        let div     = $(this).parent();

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
                if (json.status === 200) {
                    // http://stackoverflow.com/questions/13177426/how-to-destroy-bootstrap-modal-window-completely/18169689
                    div.modal('hide');
                    form.find("#message").val('').end();
                    toastr[json.type](json.message);
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

        let form    = $(this);
        let div     = $(this).parent();

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
                if (json.status === 200) {
                    div.modal('hide');
                    localStorage.setItem("flash-status", json.status);
                    localStorage.setItem("flash-message", json.message);
                    localStorage.setItem("flash-type", json.type);
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

        let project_id  = $(this).data('href');
        let toggleState = ($(this).find('i').hasClass('fa-caret-down')) ? 'open' : 'closed';

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

        let form    = $('#create-plan-form');
        let div     = form.parent();

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
     * Serializes the create plan form and passes the form data to controller method.
     * If successsful, close the modal and reload the page. Otherwise errors in modal.
     * *
     * @return {Json} json
     */
    $('#create-plan-form').bind('submit', function (e) {
        e.preventDefault();

        let form    = $(this);
        let div     = $(this).parent();

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
                if (json.status === 200) {
                    div.modal('hide');
                    localStorage.setItem("flash-status", json.status);
                    localStorage.setItem("flash-message", json.message);
                    localStorage.setItem("flash-type", json.type);
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

        let form    = $('#edit-plan-form');
        let div     = form.parent();

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

        let form    = $(this);
        let div     = $(this).parent();

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
                if (json.status === 200) {
                    div.modal('hide');
                    localStorage.setItem("flash-status", json.status);
                    localStorage.setItem("flash-message", json.message);
                    localStorage.setItem("flash-type", json.type);
                    location.reload();
                }
            }
        });
    });


    $('a.create-plan-snapshot').bind('click', function (e) {
        e.preventDefault();

        let form    = $('#create-plan-snapshot-form');
        let div     = form.parent();

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

        let form    = $(this);
        let div     = $(this).parent();

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
                if (json.status === 200) {
                    div.modal('hide');
                    localStorage.setItem("flash-status", json.status);
                    localStorage.setItem("flash-message", json.message);
                    localStorage.setItem("flash-type", json.type);
                    location.reload();
                }
            }
        });
    });


    $('a.email-plan').bind('click', function (e) {
        e.preventDefault();

        let form    = $('#email-plan-form');
        let div     = form.parent();

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

        let form    = $(this);
        let div     = $(this).parent();

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
                if (json.status === 200) {
                    div.modal('hide');
                    localStorage.setItem("flash-status", json.status);
                    localStorage.setItem("flash-message", json.message);
                    localStorage.setItem("flash-type", json.type);
                    location.reload();
                    //form.find('.form-group').children().filter('input, textarea').val('').end();
                }
            }
        });
    });


    $('a.export-plan').bind('click', function (e) {
        e.preventDefault();

        let plan_id = $(this).data('rel');
        let div     = $('div#export-plan-' + plan_id);

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

        let plan_id = $(this).data('rel');
        let div     = $('div#delete-plan-' + plan_id);

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

        let form    = $(this);
        let div     = $(this).closest('modal');

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
                if (json.status === 200) {
                    div.modal('hide');
                    localStorage.setItem("flash-status", json.status);
                    localStorage.setItem("flash-message", json.message);
                    localStorage.setItem("flash-type", json.type);
                    location.reload();
                }
            }
        });
    });


    $('a.show-project').bind('click', function (e) {
        e.preventDefault();

        //let form    = $('#show-project-form');
        let project_id  = $(this).data('rel');//form.parent();
        let div         = $('#show-project-' + project_id);//form.parent();

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

        let project_id  = $(this).data('rel');
        let div     = $('#edit-project-' + project_id);
        let form    = div.find('#edit-project-form');

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

        let form    = $(this);
        let div     = $(this).closest('modal');

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
                if (json.status === 200) {
                    div.modal('hide');
                    location.reload();
                }
            }
        });
    });


    $('a.import-project').bind('click', function (e) {
        e.preventDefault();

        let project_id  = $(this).data('rel');

        $.ajax({
            type    : 'GET',
            url     : '/my/project/' + project_id + '/import',
            dataType: 'json',
            error   : function (json) {
                console.log(json.responseText);
            },
            success : function (json) {
                if (json.status === 200) {
                    location.reload();
                }
            }
        });
    });


    $('.modal')
        .on('click', '.add-form-group', function(e){
            e.preventDefault();
            let current_form_group = $(this).closest('.form-group');
            current_form_group.find('button.remove-form-group').remove();
            let next_form_group = current_form_group.clone();
            let current_index = current_form_group.data('rel');
            let next_index = current_index + 1;
            let plus_button = current_form_group.children().last().find('button');

            next_form_group.attr('data-rel', next_index);

            /* Adjust array name index to next iterator and reset (cloned) values in new form group */
            next_form_group.children().find('input, select, textarea').each(function(index, element){
                $(element).attr('name', $(element).attr('name').replace(current_index, next_index));
                $(element).attr('value', '');
                $(element).val('');
            });

            /* Create minus button from plus button */
            let minus_button = plus_button.clone();
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
            let current_form_group = $(this).closest('.form-group');
            let buttons = current_form_group.find('button');
            buttons.first().append('&nbsp;');

            /* Get the previous form group, replace its buttons with the grepped buttons */
            let previous_form_group = current_form_group.prev();
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
});
