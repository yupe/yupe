$.fn.productGallery = function () {
    'use strict';

    var $obj = $(this),
        $main = $('[data-product-image]', $obj),
        fancyboxOptions,
        isThumbnail,
        imageBox;

    fancyboxOptions = {
        padding: 0,
        helpers: {
            media: {},
            title: {
                type: 'outside'
            },
            thumbs: {
                width: 70,
                height: 70
            }
        },
        beforeLoad: function () {
            var $el = this.element,
                isLocked = $('html').hasClass('fancybox-lock');

            if (isThumbnail && !isLocked) {
                $('[data-product-thumbnail]', $obj).removeClass('is-active');
                $el.addClass('is-active');

                this.index = $el.index();

                $main
                    .attr('data-index', this.index)
                    .find('img')
                    .attr('src', $el.attr('href'))
                    .attr('alt', $el.attr('title'));

                return false;
            }

        }
    };

    imageBox = $('[data-product-thumbnail]', $obj).fancybox(fancyboxOptions);

    $main.on('click touchstart', function () {
        isThumbnail = false;
        $.fancybox.open(imageBox, fancyboxOptions);
    });

    $('[data-product-thumbnail]', $obj).on('click touchstart', function () {
        isThumbnail = true;
    });
};
