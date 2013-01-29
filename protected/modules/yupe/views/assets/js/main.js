jQuery(document).ready(function($) {
    $('.popover-help').popover({ trigger : 'hover', delay : 500, html: true });
});

function ajaxSetStatus(elem, id) {
    $.ajax({
        url: $(elem).attr('href'),
        success: function() {
            $('#'+id).yiiGridView.update(id);
        }
    });
}

function ajaxSetSort(elem, id) {
    $.ajax({
        url: $(elem).attr('href'),
        success: function() {
            $('#'+id).yiiGridView.update(id);
        }
    });
}

