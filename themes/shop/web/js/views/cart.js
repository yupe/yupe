$(function () {
    'use strict';

    var PRICE_SPACER = ' ';

    function formatPrice(x) {
        var s = x.toString(),
            part = '',
            parts = [];

        while (part = s.slice(-3)) {
            parts.unshift(part);
            s = s.slice(0, -3);
        }

        return parts.join(PRICE_SPACER);
    }


    function recalculateCart(el) {
        var items = $('.js-cart__item', el),
            totalEl = $('.js-cart__total', el),
            subtotalEl = $('.js-cart__subtotal', el),
            totalOldEl = $('.js-cart__total-old', el),
            countEl = $('.js-cart__items-count', el),
            deliveryValue = Number($('input.js-cart__delivery', el).val()) || 0,
            totalOldValue = 0,
            totalValue = 0,
            subtotalValue = 0;

        items.each(function (i, el) {
            var $priceEl = $('.js-cart__item-price', el),
                $quantityEl = $('.js-cart__item-quantity', el),
                price = 0,
                quantity = 0;

            if($quantityEl.length){
                quantity = $quantityEl.val();
            }
            if($priceEl.length){
                price = $priceEl.val();
            }

            subtotalValue += price * quantity;

        });

        if (countEl.length) {
            countEl.html(items.length);
        }
        if (subtotalEl.length) {
            subtotalEl.html(formatPrice(subtotalValue));
        }

    }

    $.fn.cart = function () {
        this.off('change.cart');
        this.off('click.cart');

        this.on('change.cart', function () {
            recalculateCart(this);
        });

        this.delegate('.js-cart__item', 'click.cart', function (event) {
            var el = this,
                parent = el.parentNode,
                $target = $(event.target);

            if ($target.closest('.js-cart__delete').length > 0) {
                parent.removeChild(el);
                $('.js-cart').trigger('update');
                $(parent).trigger('change.cart');
                event.stopPropagation();
            }
        });
    };
});
