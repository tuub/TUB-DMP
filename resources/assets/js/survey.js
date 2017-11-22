$(window).on('load', function()
{
    /* Autoheight for textareas with prefilled content, based on line breaks
     * TODO: Still room for improvement.
     */

    $('textarea').each(function(e){
        if( $(this).val().length > 0 )
        {
            var text = $(this).val(),
                matches = text.match(/\n/g),
                breaks = matches ? matches.length : 2;
            $(this).attr('rows',breaks + 2);
        } else {
            $(this).attr('rows', 2);
        }
    });

    $("div.tagsinput select").tagsinput('items');

    $('div.bootstrap-tagsinput').css('width', '100%');

    $('a.expander').simpleexpand({
        'defaultTarget': '.content',
        'keepStateInCookie': true,
        'cookieName': 'simple-expand'
    });

    /* Prevent Form Submission by Enter Key, except for ENTERs in Tags Input Fields */
    $('form input').not('div.tagsinput input').on('keyup keypress', function(e) {
        var code = e.keyCode || e.which;
        if (code === 13) {
            e.preventDefault();
            return false;
        }
    });

    var $text_inputs = $('form :input[class^="question"]').not( ':radio' );
    var $choice_inputs = $('form input[type=radio],form input[type=checkbox]');

    $text_inputs.each(function() {
        var id = $(this).attr('name').slice(0,-2);
        if( $(this).val() !== '' )
        {
            var id = $(this).attr('name').slice(0,-2);
            $('form div.question-status[id=' + id + ']').find('div.saved').show();
        }
    });

    $choice_inputs.each(function() {
        var id = $(this).attr('name').slice(0,-2);
        if( $(this).filter(':checked').size() > 0 )
        {
            var id = $(this).attr('name').slice(0,-2);
            $('form div.question-status[id=' + id + ']').find('div.saved').show();
        }
    });

    $('input, textarea, select').on('change keyup keydown keypress paste slide remove', function(e){
        if( !$(this).attr('readonly') ) {
            if ($.trim($(this).val() != '')) {
                $(this).closest('div.row').find('div.saved').hide();
                $(this).closest('div.row').find('div.unsaved').show();
            }
        }
    });

    var token = $('meta[name="csrf-token"]').attr('content');

    $('.ajaxsave').on('click', function(e){
        e.preventDefault();
        var project_number = $('input[name="project_number"]').val();
        var version = $('input[name="version"]').val();
        var question_id = $(this).attr('data-rel') + '[]';
        //var save_method = $('form :input[name="' + question_id + '"]').attr('data-type');
        var input_data = $('form :input[name="' + question_id + '"]').serialize();

        $.ajax({
            url: url + 'plan/update',
            type: 'POST',
            data: {
                _token:token,
                project_number:project_number,
                version:version,
                question_id:question_id,
                input_data:input_data
            },
            dataType: 'json',
            success: function ()
            {
                question_id = question_id.slice(0,-2);
                $('form div.question-status[id=' + question_id + ']').find('div.unsaved').hide();
                $('form div.question-status[id=' + question_id + ']').find('div.saved').show();
            },
            error: function (e)
            {
                console.log(e);
            }
        });
    });
});