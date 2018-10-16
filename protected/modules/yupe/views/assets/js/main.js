jQuery(document).ready(function ($) {
    // Сериализация формы в объект:
    $.fn.serializeObject = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    $('body').addClass('admin-panel');

    $('.popover-help').popover({ trigger: 'hover', delay: 500, html: true });
    /**
     * Ajax-управление статусами модулей:
     **/
    $(document).on('click', '.changeStatus', function (e) {
        e.preventDefault();
        if ((link = this) === undefined || (method = $(this).attr('method')) === undefined || (message = actionToken.messages['confirm_' + method]) === undefined)
            bootbox.confirm(actionToken.messages['unknown']);
        else {
            bootbox.confirm(message, function (result) {
                if (result) {
                    sendModuleStatus($(link).attr('module'), $(link).attr('status'));
                }
            });
        }
        return false;
    });
    /**
     * Ajax-управление сбросом кеша и ресурсов (assets):
     **/
    $(document).on('click', '.flushAction', function (e) {
        e.preventDefault();
        if ((link = this) === undefined || (method = $(this).attr('method')) === undefined || (message = actionToken.messages['confirm_' + method]) === undefined)
            bootbox.confirm(actionToken.messages['unknown']);
        else {
            bootbox.confirm(message, function (result) {
                if (result) {
                    sendFlush(link);
                }
            });
        }
        return false;
    });

    /**
     * Ajax-перехватчик для повторной отправки письма активации:
     */
    $(document).on('click', '.user.sendactivation', function () {
        var link = $(this);
        $.ajax({
            url: link.attr('href'),
            data: actionToken.token,
            dataType: 'json',
            type: 'post',
            success: function (data) {
                if (typeof data.data != 'undefined' && typeof data.result != 'undefined')
                    bootbox.alert('<i class="fa fa-fw fa-' + (data.result ? 'check' : 'times') + '-circle"></i> ' + data.data);
                else
                    bootbox.alert('<i class="fa fa-fw fa-times-circle"></i> ' + actionToken.error);
            },
            error: function (data) {
                if (typeof data.data != 'undefined' && typeof data.result != 'undefined')
                    bootbox.alert('<i class="fa fa-fw fa-' + (data.result ? 'check' : 'times') + '-circle"></i> ' + data.data);
                else
                    bootbox.alert('<i class="fa fa-fw fa-times-circle"></i> ' + actionToken.error);
            }
        });
        return false;
    });
});

function ajaxSetStatus(elem, id) {
    $.ajax({
        url: $(elem).attr('href'),
        success: function () {
            $('#' + id).yiiGridView.update(id, {
                data: $('#' + id + '>.keys').attr('title')
            });
        }
    });
}

function ajaxSetSort(elem, id) {
    $.ajax({
        url: $(elem).attr('href'),
        success: function () {
            $('#' + id).yiiGridView.update(id);
        }
    });
}

function sendFlush(link) {
    var dataArray = [
        actionToken.token,
        'method=' + $(link).attr('method')
    ];

    var myDialog = bootbox.alert(actionToken.message);

    $(myDialog).find('div.modal-footer .btn').hide();
    $(myDialog).find('div.modal-footer').append(actionToken.loadingimg);
    /**
     * Запрет на закрытие бокса:
     **/
    $('.modal-backdrop').unbind('click');
    /**
     * Запрашиваем ответ сервера:
     **/
    $.ajax({
        url: $(link).attr('href'),
        data: dataArray.join('&'),
        type: 'POST',
        dataType: 'json',
        error: function (data) {
            $(myDialog).find('.modal-body').html(
                data.data ? data.data : actionToken.error
            );
            $(myDialog).find('div.modal-footer .btn').show();
            $(myDialog).find('div.modal-footer img').hide();
        },
        success: function (data) {
            if (typeof data.result != 'undefined' && typeof data.data != 'undefined' && data.result === true) {
                $(myDialog).find('.modal-body').html(data.data);
            } else {
                $(myDialog).find('.modal-body').html(
                    typeof data.data == 'undefined' ? actionToken.error : data.data
                );
            }
            $(myDialog).find('div.modal-footer .btn').show();
            $(myDialog).find('div.modal-footer img').hide();
            // При клике на кнопку - перегружаем страницу:
            $(myDialog).find('div.modal-footer .btn').click(function () {
                location.reload();
            });
        }
    });
}

function sendModuleStatus(name, status) {
    var dataArray = [
        actionToken.token,
        'module=' + name,
        'status=' + status
    ];

    var myDialog = bootbox.alert(actionToken.message);
    $(myDialog).find('div.modal-footer .btn').hide();
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
        error: function (data) {
            if (typeof data.result != 'undefined' && typeof data.data != 'undefined' && data.result === true) {
                $(myDialog).find('.modal-body').html(data.data);
            } else {
                $(myDialog).find('.modal-body').html(
                    typeof data.data == 'undefined' ? actionToken.error : data.data
                );
            }
            $(myDialog).find('div.modal-footer a.btn').show();
            $(myDialog).find('div.modal-footer img').hide();
            // При клике на кнопку - перегружаем страницу:
            $(myDialog).find('div.modal-footer a.btn').click(function () {
                location.reload();
            });
        },
        success: function (data) {
            if (typeof data.result != 'undefined' && typeof data.data != 'undefined' && data.result === true) {
                $(myDialog).find('.modal-body').html(data.data);
            } else {
                $(myDialog).find('.modal-body').html(
                    typeof data.data == 'undefined' ? actionToken.error : data.data
                );
            }
            $(myDialog).find('div.modal-footer .btn').show();
            $(myDialog).find('div.modal-footer img').hide();
            // При клике на кнопку - перегружаем страницу:
            $(myDialog).find('div.modal-footer .btn').click(function () {
                location.reload();
            });
        }
    });
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.preview-image').attr('src', e.target.result).show();
        };

        reader.readAsDataURL(input.files[0]);
    }
}
