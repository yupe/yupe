jQuery(document).ready(function ($) {
    (function($){
        var originalPos = null;

        var fixHelperDimensions = function(e, tr) {
            originalPos = tr.prevAll().length;
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index)
            {
                $(this).width($originals.eq(index).width()+1).height($originals.eq(index).height())
                    .css({
                        "border-bottom":"1px solid #ddd"
                    });
            });
            return $helper.css("border-right","1px solid #ddd");
        };

        /**
         * Returns the key values of the currently checked rows.
         * @param id string the ID of the grid view container
         * @param action string the action URL for save sortable rows
         * @param column_id string the ID of the column
         * @param data string the custom POST data
         * @return array the key values of the currently checked rows.
         */
        $.fn.yiiGridView.sortable = function (id, action, callback, data)
        {
            if (data == null)
                data = {};

            var grid = $('#'+id) ;
            $("tbody", grid).sortable({
                helper: fixHelperDimensions,
                update: function(e,ui){
                    // update keys
                    var pos = $(ui.item).prevAll().length;
                    if(originalPos !== null && originalPos != pos)
                    {
                        var keys = grid.children(".keys").children("span");
                        var key = keys.eq(originalPos);
                        var sort = [];//sort number values from to
                        keys.each(function(i) {
                            sort[i] = $(this).attr('data-order');
                        });

                        if(originalPos < pos)
                        {
                            keys.eq(pos).after(key);
                        }
                        if(originalPos > pos)
                        {
                            keys.eq(pos).before(key);
                        }
                        originalPos = null;
                    }
                    var sortOrder = {};
                    keys = grid.children(".keys").children("span");
                    keys.each(function(i) {
                        $(this).attr('data-order', sort[i]);
                        sortOrder[$(this).text()] = sort[i];
                    });

                    data["sortOrder"] = sortOrder;

                    if(action.length)
                    {
                        $.fn.yiiGridView.update(id,
                            {
                                type:'POST',
                                url:action,
                                data:data,
                                success:function(){
                                    grid.removeClass('grid-view-loading');
                                },
                                complete:function(){
                                    if($.isFunction(callback))
                                    {
                                        callback(sortOrder);
                                    }
                                }
                            });
                    }
                    else if($.isFunction(callback))
                    {
                        callback(sortOrder);
                    }
                }
            });
        };
    })(jQuery);

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
