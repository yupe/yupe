$(document).ready(function ($) {
    $('.list-expanding').on('click', function () {
        if ($(this).hasClass('btn-disabled')) return false;
        $(this).closest('.blog-description-members').toggleClass('expand-list');
    });

    $('.join-blog').on('click', function (event) {
        event.preventDefault();
        var $button = $(this);
        var data = {
            'blogId': parseInt($(this).attr('href'))
        };
        data[yupeTokenName] = yupeToken;
        $.post($(this).data('url'), data, function (response) {
            if (response.result) {
                $button.hide();
                $('#notifications').notify({ message: { text: response.data } }).show();
            } else {
                $('#notifications').notify({ message: { text: response.data }, type: 'error' }).show();
            }
        }, 'json');
    });

    $('.leave-blog').on('click', function (event) {
        event.preventDefault();
        var $button = $(this);
        var data = {
            'blogId': parseInt($(this).attr('href'))
        };
        data[yupeTokenName] = yupeToken;
        $.post($(this).data('url'), data, function (response) {
            if (response.result) {
                $button.hide();
                $('#notifications').notify({ message: { text: response.data } }).show();
            } else {
                $('#notifications').notify({ message: { text: response.data }, type: 'error' }).show();
            }
        }, 'json');
    });
});