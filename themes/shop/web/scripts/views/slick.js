$(function () {

    'use strict';

    $.fn.slider = function () {
        var opt = {};

        opt.prevArrow = $('.js-slick__prev', this);
        opt.nextArrow = $('.js-slick__next', this);

        opt.autoplay = Boolean(this.attr('data-autoplay'));
        opt.autoplaySpeed = Number(this.attr('data-autoplay')) || 5000;
        opt.speed = Number(this.attr('data-speed')) || 200;
        opt.infinite = Boolean(this.attr('data-infinite')) || false;
        opt.dots = Boolean(this.attr('data-dots')) || false;
        if (opt.dots) {
            opt.dotsClass = 'slick__dot';
        }
        opt.slidesToShow = Number(this.attr('data-show')) || 4;
        opt.slidesToScroll = Number(this.attr('data-scroll')) || opt.slidesToShow;
        opt.useCSS = true;
        var slickContaner = $('.js-slick__container', this);

        if (slickContaner.hasClass('slick-initialized')) {
            slickContaner.slick('unslick');
        }
        slickContaner.slick(opt);
    };

    // item slider
    $('.js-slick').each(function () {
        $(this).slider();
    });

});
