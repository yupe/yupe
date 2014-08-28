'use strict';

// Опредедяем объект:
var listCell = {};

// Настраиваем инициализатор:
listCell.init = function () {
    // Запоминаем текущий объект,
    // так как он не доступен внутри
    // других методов:
    var self = this,
    // Объект нашего listView:
        parent = undefined,
    // Объект loader:
        loader = undefined,
    // Текущий элемент:
        curentItem = undefined;

    // Объявляем нужные обработчики:
    self.prepare = function () {
        // Обработчик для кнопок управления записями:
        $(document).on('click', '.list-cell [data-action]', function () {
            listCell.buttons($(this));
        });

        // Обработчик submit-а формы:
        $(document).on('submit', '.ajax-form', function () {
            // Запоминаем объект формы:
            var form = $(this);

            // Отключаем дефолтное событие:
            event.preventDefault();

            // Обрабатываем Ajax-запрос:
            $.post(form.attr('action'), form.serialize())
                .done(function (response) {
                    form.closest('.modal').modal('hide');
                    self.update();

                    // Если нам вернули форму - значит есть ошибки:
                    if (response.data.html !== undefined) {
                        self.answerForm(response, self.currentItem);
                    } else {
                        bootbox.alert(response.data.message);
                    }
                })
                .fail(function () {
                    // Выполняем при ошибке.
                })
                .always(function () {
                    // Всегда выполняется.
                });
        });

        $(document).on("hide", '.modal', function () {
            var modal = $(this);
            setTimeout(function () {
                modal.remove();
            }, 500);

        });
    };

    // Обработчики action'ов:
    self.buttons = function (item) {
        var callback,
            confirm = undefined;

        // Получаем родителя:
        self.parent = item.closest('.list-view');

        // Сбрасываем текущий элемент:
        self.currentItem = item;

        // Получаем loader-элемент:
        self.loader = item.closest('.list-cell').find('.loader');

        console.log(item.data('action'), item);

        // Определяем callback:
        switch (item.data('action')) {
            case 'toggle-faq':
                callback = self.toggleFaq;
                break;
            case 'delete':
                callback = self.delete;
                break;
            case 'answer':
                callback = self.answer;
                break;
            case 'show':
                callback = self.show;
                break;

            // Если действие нам неизвестно:
            default:
                return null;
        }

        // Если необходимо спрашиваем подтверждение:
        if ((confirm = item.data('confirm')) !== undefined) {
            bootbox.confirm(confirm, function (result) {
                // При положительном результате - запускаем callback:
                if (result) return callback(item);
            })
        } else {
            callback(item);
        }
    };

    // Обновляем listView:
    self.update = function () {
        $.fn.yiiListView.update(self.parent.attr('id'));
    }

    // Основной Ajax-обработчик:
    self.postWithUpdate = function (item) {
        // Показываем процесс выполнения:
        self.loader.show();

        var response = undefined;

        // Запускаем AJAX-зарос:
        $.ajax({
            url: item.data('url'),
            data: item.data('params'),
            async: item.data('return') == undefined,
            type: 'POST'
        }).done(function (data) {
            self.update();

            // Если необходимо, возвращаем данные:
            if (item.data('return')) {
                response = data;
            }
        }).fail(function () {
            bootbox.alert(self.parent.data('failMessage'));
        }).always(function () {
            self.loader.hide();
        });

        // Если необходимо, возвращаем данные:
        if (item.data('return')) {
            return response;
        }
    }

    // Просмотр сообщения:
    self.show = function (item) {
        var response = self.postWithUpdate(item),
            modal = $('<div class="modal hide fade"></div>');

        if (response.result) {
            modal.append('<div class="modal-header"><h4>' + item.data('title') + '</h4></div>');
            modal.append('<div class="modal-body">' + response.data.html + '</div>');
            modal.modal('show');
        } else {
            bootbox.confirm(response.data.message);
        }
    };

    // Метод отрисовки формы ответа:
    self.answerForm = function (response, item) {
        var modal = $('<div class="modal hide fade"></div>');

        if (response.result) {
            modal.append('<div class="modal-header"><h4>' + item.data('title') + '</h4></div>');
            modal.append('<div class="modal-body">' + response.data.html + '</div>');
            modal.modal('show').css({width: '600px'});

            setTimeout(function () {
                $('.answer-text').redactor();
            }, 300);
        } else {
            bootbox.alert(response.data.message);
        }
    }

    // Метож для ответа пользователю:
    self.answer = function (item) {
        var response = self.postWithUpdate(item);

        self.answerForm(response, item);
    };

    // Метод удаления записи:
    self.delete = function (item) {
        return self.postWithUpdate(item);
    };

    // выполняем toggle-faq (добавляем/удаляем сообщение в FAQ):
    self.toggleFaq = function (item) {
        return self.postWithUpdate(item);
    };

    // Включаем обработчики:
    self.prepare();
};

// Инициализация:
jQuery(document).ready(function ($) {

    // Инициализируем наш объект:
    listCell.init();

});