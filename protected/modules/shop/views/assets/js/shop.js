$(document).ready(function () {
    var priceElement = $('#result-price');
    var basePrice = parseFloat($('#base-price').val());
    var quantityElement = $('#product-quantity');
    var cartWidgetSelector = '#shopping-cart-widget';

    function showNotify(element, result, message) {
        element.notify(message, {className: result, autoHideDelay: 2000, elementPosition: 'top center'});
    }

    function updatePrice() {
        var newPrice = basePrice;
        var variants = [];
        $.each($('select[name="ProductVariant[]"'), function (index, elem) {
            var varId = elem.value;
            if (varId) {
                var option = $(elem).find('option[value="' + varId + '"]');
                var variant = {amount: option.data('amount'), type: option.data('type')};
                variants.push(variant);
                switch (variant.type) {
                    case 0: // sum
                        newPrice += variant.amount;
                        break;
                    case 1: // percent
                        newPrice += basePrice * ( variant.amount / 100);
                        break;
                }
            }
        });

        priceElement.html(parseFloat(newPrice.toFixed(2)));
    }

    $('select[name="ProductVariant[]"').change(function () {
        updatePrice();
    });


    $('.product-quantity-increase').click(function () {
        quantityElement.val(parseInt(quantityElement.val()) + 1);
    });

    $('.product-quantity-decrease').click(function () {
        if (parseInt(quantityElement.val()) > 1) {
            quantityElement.val(parseInt(quantityElement.val()) - 1);
        }
    });

    function updateCartWidget() {
        $(cartWidgetSelector).load('/cart/cartWidget');
    }

    $('#add-product-to-cart').click(function (e) {
        e.preventDefault();
        var button = $(this);
        button.button('loading');
        var form = $(this).parents('form');
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: form.serialize(),
            url: form.attr('action'),
            success: function (data) {
                if (data.result == 'success') {
                    updateCartWidget();
                }
                showNotify(button, data.result, data.message);
            }
        }).always(function () {
            button.button('reset');
        });
    });

    $('body').on('click', '.quick-add-product-to-cart', function (e) {
        e.preventDefault();
        var el = $(this);
        var data = {'Product[id]': el.data('product-id')};
        data[yupeTokenName] = yupeToken;
        $.ajax({
            url: '/cart/add',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.result == 'success') {
                    updateCartWidget();
                }
                showNotify(el, data.result, data.message);
            }
        });
    });


    /*cart*/

    function updatePositionSumPrice(tr) {
        var count = parseInt(tr.find('.position-count').val());
        var price = parseFloat(tr.find('.position-price').text());
        tr.find('.position-sum-price').html(price * count);
        updateTotalCost();
    }

    function changePositionQuantity(productId, quantity) {
        var data = {'Product[quantity]': quantity};
        data[yupeTokenName] = yupeToken;
        $.ajax({
            url: '/cart/update/' + productId,
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.result == 'success') {

                }
            }
        });
    }

    $('.cart-quantity-increase').click(function () {
        var target = $($(this).data('target'));
        target.val(parseInt(target.val()) + 1).trigger('change');
    });

    $('.cart-quantity-decrease').click(function () {
        var target = $($(this).data('target'));
        if (parseInt(target.val()) > 1) {
            target.val(parseInt(target.val()) - 1).trigger('change');
        }
    });

    $('.cart-delete-product').click(function () {
        var el = $(this);
        var data = {};
        data[yupeTokenName] = yupeToken;
        $.ajax({
            url: '/cart/delete/' + el.data('position-id'),
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.result == 'success') {
                    el.parents('tr').remove();
                    updateTotalCost();
                }
            }
        });

    });

    $('.position-count').change(function () {
        var tr = $(this).parents('tr');
        updatePositionSumPrice(tr);
        var quantity = tr.find('.position-count').val();
        var productId = tr.find('.position-id').val();
        changePositionQuantity(productId, quantity);
    });

    function updateTotalCost() {
        var cost = 0;
        $.each($('.position-sum-price'), function (index, elem) {
            cost += parseFloat($(elem).text());
        });
        $('#cart-full-cost').html(cost);
    }

});