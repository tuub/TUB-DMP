$(window).ready(function ()
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
        //e.preventDefault();

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
                    //console.log(json);
                    div.modal('hide');
                    //form.find("input, textarea, select").val('').end();
                    location.reload();
                }
            }
        })

    });


    $('.modal').on('click', '.add-form-group', function(e){
        e.preventDefault();
        var project_id = $(this).data('rel');
        //console.log( project_id );

        var form = $(this).parents('div#edit-project-' + project_id).find('form');
        var current_form_group = $(this).closest('.form-group');
        var next_form_group = current_form_group.clone();
        var current_index = current_form_group.data('rel');
        var next_index = current_index + 1;
        var button = current_form_group.children().last().find('button');

        console.log(button);

        //var form = $('div#edit-project-' + current_index + ' form');

        next_form_group.attr('data-rel', next_index);

        next_form_group.children().find('input,select,textarea').each(function(index, element) {
            $(element).attr('name', $(element).attr('name').replace(current_index, next_index));
            $(element).attr('value', '');
            $(element).val('');
        });

        console.log(form);

        //console.log(current_index);
        //console.log(current_form_group);
        //console.log(next_index);
        //console.log(next_form_group);
        //console.log(button);

        //$(this).parent().remove();

        //current_form_group.find('button.add-form-group').remove();
        //next_form_group.find('button.add-form-group').insertAfter(button);
        //current_form_group.find('i.fa').removeClass('fa-plus').addClass('fa-minus');

        current_form_group.find('button.add-form-group').removeClass('add-form-group').addClass('remove-form-group');
        current_form_group.find('i.fa').removeClass('fa-plus').addClass('fa-minus');

        /*  */

        next_form_group.insertAfter(current_form_group);
        //form.append(next_form_group);
    });

    $('.modal').on('click', '.remove-form-group', function(e){
        e.preventDefault();
        var form = $(this.form);
        var current_form_group = $(this).closest('.form-group');
        var previous_form_group = current_form_group.prev();
        console.log(previous_form_group);
        current_form_group.remove();
    })





    $('.edit-project-without-modal').on('click', '.add-form-group', function(e){
        e.preventDefault();
        var project_id = $(this).data('rel');
        //console.log( project_id );

        var form = $(this).parents('div#edit-project-' + project_id).find('form');
        var current_form_group = $(this).closest('.form-group');
        var next_form_group = current_form_group.clone();
        var current_index = current_form_group.data('rel');
        var next_index = current_index + 1;
        var button = current_form_group.children().last().find('button');

        console.log(button);

        //var form = $('div#edit-project-' + current_index + ' form');

        next_form_group.attr('data-rel', next_index);

        next_form_group.children().find('input,select,textarea').each(function(index, element) {
            $(element).attr('name', $(element).attr('name').replace(current_index, next_index));
            $(element).attr('value', '');
            $(element).val('');
        });

        console.log(form);

        //console.log(current_index);
        //console.log(current_form_group);
        //console.log(next_index);
        //console.log(next_form_group);
        //console.log(button);

        //$(this).parent().remove();

        //current_form_group.find('button.add-form-group').remove();
        //next_form_group.find('button.add-form-group').insertAfter(button);
        //current_form_group.find('i.fa').removeClass('fa-plus').addClass('fa-minus');

        current_form_group.find('button.add-form-group').removeClass('add-form-group').addClass('remove-form-group');
        current_form_group.find('i.fa').removeClass('fa-plus').addClass('fa-minus');

        /*  */

        next_form_group.insertAfter(current_form_group);
        //form.append(next_form_group);
    });

    $('.edit-project-without-modal').on('click', '.remove-form-group', function(e){
        e.preventDefault();
        var form = $(this.form);
        var current_form_group = $(this).closest('.form-group');
        var previous_form_group = current_form_group.prev();
        console.log(previous_form_group);
        current_form_group.remove();
    })




});