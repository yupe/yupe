jQuery(document).ready(function($) {
    $('.popover-help').popover({ trigger : 'hover', delay : 500, html: true });
    $(document).on('click', '.changeStatus', function() {
        if ((link = this) === undefined || (method = $(this).attr('method')) === undefined || (message = actionToken.messages['confirm_' + method]) === undefined)
            bootbox.confirm(actionToken.messages['unknown']);
        else {
            bootbox.confirm(message, actionToken.buttons['no'], actionToken.buttons['yes'], function(result) {
                if (result) {
                    sendModuleStatus($(link).attr('module'), $(link).attr('status'));
                }
            });
        }
        return false;
    });
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

function sendModuleStatus(name, status) {
    dataArray = [
        actionToken.token,
        'module=' + name,
        'status=' + status
    ];

    myDialog = bootbox.alert(actionToken.message);
    $(myDialog).find('div.modal-footer a.btn').hide();
    $(myDialog).find('div.modal-footer').append(actionToken.loadingimg);
    /**
     * Запрет на закрытие бокса:
     **/
    $('.modal-backdrop').unbind('click');
    /**
     * Запрашиваем ответ сервера:
     **/
    $.ajax({
        url: actionToken.url,
        data: dataArray.join('&'),
        type: 'POST',
        dataType: 'json',
        error: function(data) {
            if (typeof data.result != 'undefined' && typeof data.data != 'undefined' && data.result === true ) {
                $(myDialog).find('.modal-body').html(data.data);
            } else {
                $(myDialog).find('.modal-body').html(
                    typeof data.data == 'undefined' ? actionToken.error : data.data
                );
            }
            $(myDialog).find('div.modal-footer a.btn').show();
            $(myDialog).find('div.modal-footer img').hide();
            // При клике на кнопку - перегружаем страницу:
            $(myDialog).find('div.modal-footer a.btn').click(function() {
                location.reload();
            });
        },
        success: function(data) {
            if (typeof data.result != 'undefined' && typeof data.data != 'undefined' && data.result === true ) {
                $(myDialog).find('.modal-body').html(data.data);
            } else {
                $(myDialog).find('.modal-body').html(
                    typeof data.data == 'undefined' ? actionToken.error : data.data
                );
            }
            $(myDialog).find('div.modal-footer a.btn').show();
            $(myDialog).find('div.modal-footer img').hide();
            // При клике на кнопку - перегружаем страницу:
            $(myDialog).find('div.modal-footer a.btn').click(function() {
                location.reload();
            });
        }
    });
}