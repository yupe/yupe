/**
 * handle jQuery plugin naming conflict between jQuery UI and Bootstrap
 * see https://github.com/twbs/bootstrap/issues/6303#issuecomment-12715745
 *
 * You obviously have to include this file AFTER the jQueryUI
 */
(function ($) {
    "use strict";
    if (!($.widget && $.widget.bridge && $.ui)) {
        return;
    }
    $.widget.bridge('uibutton', $.ui.button);
    $.widget.bridge('uitooltip', $.ui.tooltip);
})(jQuery);

