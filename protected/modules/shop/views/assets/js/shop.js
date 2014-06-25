$(document).ready(function () {
    var cartWidgetSelector = '#shopping-cart-widget';

    /*страница продукта*/
    var priceElement = $('#result-price'); //итоговая цена на странице продукта
    var basePrice = parseFloat($('#base-price').val()); //базовая цена на странице продукта
    var quantityElement = $('#product-quantity');

    /*корзина*/

    var shippingCostElement = $('#cart-shipping-cost');
    var cartFullCostElement = $('#cart-full-cost');
    var cartFullCostWithShippingElement = $('#cart-full-cost-with-shipping');

    function showNotify(element, result, message) {
        element.notify(message, {className: result, autoHideDelay: 2000, elementPosition: 'top center'});
    }

    function updatePrice() {
        var _basePrice = basePrice;
        var variants = [];
        var varElements = $('select[name="ProductVariant[]"');
        /* выбираем вариант, меняющий базовую цену максимально*/
        var hasBasePriceVariant = false;
        $.each(varElements, function (index, elem) {
            var varId = elem.value;
            if (varId) {
                var option = $(elem).find('option[value="' + varId + '"]');
                var variant = {amount: option.data('amount'), type: option.data('type')};
                switch (variant.type) {
                    case 2: // base price
                        // еще не было варианта
                        if (!hasBasePriceVariant) {
                            _basePrice = variant.amount;
                            hasBasePriceVariant = true;
                        }
                        else {
                            if (_basePrice < variant.amount) {
                                _basePrice = variant.amount;
                            }
                        }
                        break;
                }
            }
        });
        var newPrice = _basePrice;
        $.each(varElements, function (index, elem) {
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
                        newPrice += _basePrice * ( variant.amount / 100);
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
        updateCartTotalCost();
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
                    updateCartTotalCost();
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

    $('input[name="Order[delivery_id]"]').change(function () {
        updateShippingCost();
    });

    function getCartTotalCost() {
        var cost = 0;
        $.each($('.position-sum-price'), function (index, elem) {
            cost += parseFloat($(elem).text());
        });
        return cost;
    }

    function updateCartTotalCost() {
        cartFullCostElement.html(getCartTotalCost());
        refreshDeliveryTypes();
        updateShippingCost();
        updateFullCostWithShipping();
    }

    function refreshDeliveryTypes() {
        var cartTotalCost = getCartTotalCost();
        $.each($('input[name="Order[delivery_id]"]'), function (index, el) {
            var elem = $(el);
            var availableFrom = elem.data('available-from');
            if (availableFrom.length && parseFloat(availableFrom) > cartTotalCost) {
                if (elem.prop('checked')) {
                    checkFirstAvailableDeliveryType();
                }
                elem.prop('disabled', true);
            } else {
                elem.prop('disabled', false);
            }
        });
    }

    function checkFirstAvailableDeliveryType() {
        $('input[name="Order[delivery_id]"]:not(:disabled):first').prop('checked', true);
    }


    function getShippingCost() {
        var cartTotalCost = getCartTotalCost();
        var selectedDeliveryType = $('input[name="Order[delivery_id]"]:checked');
        if (!selectedDeliveryType[0]) {return 0;}
        if (parseInt(selectedDeliveryType.data('separate-payment')) || parseFloat(selectedDeliveryType.data('free-from')) < cartTotalCost) {
            return 0;
        } else {
            return parseFloat(selectedDeliveryType.data('price'));
        }
    }

    function updateShippingCost() {
        shippingCostElement.html(getShippingCost());
        updateFullCostWithShipping();
    }

    function updateFullCostWithShipping() {
        cartFullCostWithShippingElement.html(getShippingCost() + getCartTotalCost());
    }

    refreshDeliveryTypes();
    checkFirstAvailableDeliveryType();
    updateFullCostWithShipping();

    $('#start-payment').click(function () {
        $('.payment-method-radio:checked').parents('.payment-method').find('form').submit();
    });

    $('body').on('click', '.clear-cart', function (e) {
        e.preventDefault();
        var data = {};
        data[yupeTokenName] = yupeToken;
        $.ajax({
            url: '/cart/clear',
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
});