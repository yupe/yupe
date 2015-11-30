(function ($) {
    'use strict';

    if (typeof $.tabs !== 'undefined') {
        throw('$.tabs is already defined');
    }

    $.tabs = function (el, options) {
        var ACTIVE_CLASS = 'is-active',
            root = this,
            $root = $(root);

        root.$el = $(el);
        root.$nav = root.$el.find('[data-nav]').first();

        root.init = function () {
            root.options = $.extend({}, $.tabs.defaultOptions, options);

            root.$nav.on('click', '[href]', function () {
                var current = $root.data().current,
                    $this = $(this),
                    tabID = $this.attr('href').substring(1),
                    scrollToTarget = ($this.attr('data-scroll-to-target') !== undefined),

                    $bodiesWrapper = root.$el.find('.js-tabs-bodies'),
                    currentHeight = $bodiesWrapper.height();

                $bodiesWrapper.height(currentHeight);

                if ((tabID !== current) /*&& (root.$el.find(':animated').length === 0)*/) {

                    root.$el.find('#' + current).fadeOut(root.options.speed, function () {
                        var $target = root.$el.find('#' + tabID),
                            targetHeight = $target.innerHeight();

                        $target.fadeIn(root.options.speed);

                        if (scrollToTarget) {
                            $('html, body').animate({
                                scrollTop: $target.offset().top
                            });
                        }

                        $bodiesWrapper.animate({
                            height: targetHeight
                        }, function () {
                            var
                                navHeight = $('.js-sticky-nav').height(),
                                targetScrollTop = root.$nav.offset().top,
                                threshold = $(window).scrollTop() + $(window).height() * 0.75;

                            $(this).css('height', '');

                            if (targetScrollTop > threshold) {
                                if (navHeight) {
                                    targetScrollTop -= navHeight;
                                }

                                $('html, body').animate({
                                    scrollTop: targetScrollTop
                                });
                            }
                        });

                        root.$nav.find('.' + ACTIVE_CLASS).removeClass(ACTIVE_CLASS);
                        $this.addClass(ACTIVE_CLASS);

                        $target.find('.js-slick').each(function () {
                            $(this).slider();
                        });
                    });

                    $.publish('tabs.show', tabID);
                }

                $root.data().current = tabID;

                return false;
            });

            (function () {
                var hash = window.location.hash,
                    $bodiesWrapper = root.$el.find('.js-tabs-bodies').first(),
                    $first = root.$nav.find('.' + ACTIVE_CLASS);

                if ($first.length) {
                    hash = $first.attr('href');
                } else {
                    $first = null;
                }

                if (hash) {
                    $first = root.$nav.find('[href=' + hash + ']');
                }

                if (!$first || !$first.length) {
                    $first = root.$nav.find('[href]').first();
                    hash = $first.attr('href');
                }

                $root.data().current = hash.substring(1);
                $bodiesWrapper.children('.js-tab').not(hash).hide();
                $first.addClass(ACTIVE_CLASS);

                $.publish('tabs.show', hash.substring(1));
            })();

            $(window).bind('hashchange', function () {
                $('[href=' + window.location.hash + ']').trigger('click');
            });
        };

        root.init();
    };

    $.tabs.defaultOptions = {
        speed: 0
    };

    $.fn.tabs = function (options) {
        return this.each(function () {
            (new $.tabs(this, options));
        });
    };
})(jQuery);
