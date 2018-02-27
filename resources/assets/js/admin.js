let table = $('table.data-table').DataTable({
    'paging': false,
    'info': false,
    'order-column': true,
    'hover': true,
    'dom': '<"row"<"col-sm-12"l><"col-sm-12"f>>' +
           '<"row"<"col-md-24"tr>>' +
           '<"row"<"col-sm-5"i><"col-sm-7"p>>'
});

$('tbody tr').tooltip({
    track: true
});

$('table.sortable tbody').sortable({
    cursor: 'move',
    placeholder: 'success',
    revert: false,
    dropOnEmpty: true,
    animation: 150,
    update: function (event, ui) {
        let data = $(this).sortable('serialize',{expression: /(.+)_(.+)/ });
        let model = $(this).children().filter('.ui-sortable-handle').removeClass('ui-sortable-handle').attr('class');
        let url = '/admin/' + model + '/sort';
        $.ajax({
            data: data,
            type: 'POST',
            url: url,
            success: function (response) {
                location.reload();
            }
        });
        // TODO: get color from bootstrap CSS class
        $(ui.item).effect('highlight', {'color': '#3c763d'}, 200);
    }
});