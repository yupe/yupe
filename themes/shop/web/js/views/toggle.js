$(function () {
    'use strict';

    var ACTIVE_CLASS = 'toggle-active',
        $triggers = $('[data-toggle]');

    $triggers.on('click', function () {
        var target = $(this).data('toggle');
        $(target).toggleClass(ACTIVE_CLASS);

        return false;
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.' + ACTIVE_CLASS).length) {
            $('.' + ACTIVE_CLASS).removeClass(ACTIVE_CLASS);
        }
    });
});
