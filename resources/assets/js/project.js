$(window).ready(function ()
{









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