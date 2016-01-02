function showNotify(element, result, message) {
    $('#notifications').html('<div>' + message + '</div>').fadeIn().delay(3000).fadeOut();
}

$(document).ajaxError(function () {
    $('#notifications').html('<div>Произошла ошибка =(</div>').fadeIn().delay(3000).fadeOut();
});

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

    miniCartListeners();
    refreshDeliveryTypes();
    checkFirstAvailableDeliveryType();
    updateAllCosts();

    // Галерея дополнительных изображений в карточке товара
    $('.js-product-gallery').productGallery();

    // Табы в карточке товара
    $('.js-tabs').tabs();

    $(".js-select2").select2();

    $('#start-payment').on('click', function () {
        $('.payment-method-radio:checked').parents('.payment-method').find('form').submit();
    });

    $('body').on('click', '.clear-cart', function (e) {
        e.preventDefault();
        var data = {};
        data[yupeTokenName] = yupeToken;
        $.ajax({
            url: '/coupon/clear',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.result) {
                    updateCartWidget();
                }
            }
        });
    });

    $('#add-coupon-code').click(function (e) {
        e.preventDefault();
        var code = $('#coupon-code').val();
        var button = $(this);
        if (code) {
            var data = {'code': code};
            data[yupeTokenName] = yupeToken;
            $.ajax({
                url: '/coupon/add',
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (data) {
                    if (data.result) {
                        window.location.reload();
                    }
                    showNotify(button, data.result ? 'success' : 'danger', data.data.join('; '));
                }
            });
            $('#coupon-code').val('');
        }
    });

    $('.coupon .close').click(function (e) {
        e.preventDefault();
        var code = $(this).siblings('input[type="hidden"]').data('code');
        var data = {'code': code};
        var el = $(this).closest('.coupon');
        data[yupeTokenName] = yupeToken;
        $.ajax({
            url: '/coupon/remove',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (data) {
                showNotify(this, data.result ? 'success' : 'danger', data.data);
                if (data.result) {
                    el.remove();
                    updateAllCosts();
                }
            }
        });
    });

    $('#coupon-code').keypress(function (e) {
        if (e.which == 13) {
            e.preventDefault();
            $('#add-coupon-code').click();
        }
    });

    $('.order-form').submit(function () {
        $(this).find("button[type='submit']").prop('disabled', true);
    });

    $('select[name="ProductVariant[]"]').change(function () {
        updatePrice();
    });

    $('.product-quantity-increase').on('click', function () {
        var quantity = parseFloat(quantityElement.text()) + 1;
        quantityElement.text(quantity);
        $('#product-quantity-input').val(quantity);
        $('#product-total-price').text(parseFloat($('#result-price').text()) * quantity);
    });

    $('.product-quantity-decrease').on('click', function () {
        var quantity = parseFloat(quantityElement.text());
        if (parseInt(quantityElement.text()) > 1) {
            --quantity;
            quantityElement.text(quantity);
            $('#product-quantity-input').val(quantity);
            $('#product-total-price').text(parseFloat($('#result-price').text()) * quantity);
        }
    });

    $('#product-quantity-input').change(function (event) {
        var el = $(this);
        quantity = parseFloat(el.val());

        if (quantity <= 0) {
            quantity = 1;
        }

        el.val(quantity);
        quantityElement.text(quantity);
        $('#product-total-price').text(parseFloat($('#result-price').text()) * quantity);
    });

    $('#add-product-to-cart').on('click', function (e) {
        e.preventDefault();
        var button = $(this);
        var form = $(this).parents('form');
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: form.serialize(),
            url: form.attr('action'),
            success: function (data) {
                if (data.result) {
                    updateCartWidget();
                }
                showNotify(button, data.result ? 'success' : 'danger', data.data);
            }
        });
    });

    $('body').on('click', '.quick-add-product-to-cart', function (e) {
        e.preventDefault();
        var el = $(this);
        var data = {'Product[id]': el.data('product-id')};
        data[yupeTokenName] = yupeToken;
        $.ajax({
            url: el.data('cart-add-url'),
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.result) {
                    updateCartWidget();
                }
                showNotify(el, data.result ? 'success' : 'danger', data.data);
            }
        });
    });

    $('.cart-quantity-increase').on('click', function () {
        var target = $($(this).data('target'));
        target.val(parseInt(target.val()) + 1).trigger('change');
    });

    $('.cart-quantity-decrease').on('click', function () {
        var target = $($(this).data('target'));
        if (parseInt(target.val()) > 1) {
            target.val(parseInt(target.val()) - 1).trigger('change');
        }
    });

    $('.cart-delete-product').click(function (e) {
        e.preventDefault();
        var el = $(this);
        var data = {'id': el.data('position-id')};
        data[yupeTokenName] = yupeToken;
        $.ajax({
            url: yupeCartDeleteProductUrl,
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.result) {
                    el.closest('.cart-list__item').remove();

                    if ($('.cart-list .cart-item').length == 0) {
                        $('#order-form').remove();
                        $('.main__title h1').text('Корзина пуста');
                    }
                    $('#cart-total-product-count').text($('.cart-list .cart-item').length);
                    updateCartTotalCost();
                    updateCartWidget();
                }
            }
        });
    });

    $('.position-count').change(function () {
        var el = $(this).parents('.cart-list__item');
        var quantity = parseInt(el.find('.position-count').val());
        var productId = el.find('.position-id').val();

        if (quantity <= 0) {
            quantity = 1;
            el.find('.position-count').val(quantity);
        }

        updatePositionSumPrice(el);
        changePositionQuantity(productId, quantity);
    });

    $('input[name="Order[delivery_id]"]').change(function () {
        updateShippingCost();
    });

    function miniCartListeners() {
        $('.mini-cart-delete-product').click(function (e) {
            e.preventDefault();
            var el = $(this);
            var data = {'id': el.data('position-id')};
            data[yupeTokenName] = yupeToken;
            $.ajax({
                url: yupeCartDeleteProductUrl,
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (data) {
                    if (data.result) {
                        updateCartWidget();
                    }
                }
            });
        });

        $('#cart-toggle-link').click(function (e) {
            e.preventDefault();
            $('#cart-mini').toggle();
        });
    }

    function getCartTotalCost() {
        var cost = 0;
        $.each($('.position-sum-price'), function (index, elem) {
            cost += parseFloat($(elem).text());
        });
        var delta = 0;
        var coupons = getCoupons();
        $.each(coupons, function (index, el) {
            if (cost >= el.min_order_price) {
                switch (el.type) {
                    case 0: // руб
                        delta += parseFloat(el.value);
                        break;
                    case 1: // %
                        delta += (parseFloat(el.value) / 100) * cost;
                        break;
                }
            }
        });

        return delta > cost ? 0 : cost - delta;
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
            if (availableFrom.length && parseFloat(availableFrom) >= cartTotalCost) {
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
        var coupons = getCoupons();
        var freeShipping = false;
        $.each(coupons, function (index, el) {
            if (el.free_shipping && cartTotalCost >= el.min_order_price) {
                freeShipping = true;
            }
        });
        if (freeShipping) {
            return 0;
        }
        var selectedDeliveryType = $('input[name="Order[delivery_id]"]:checked');
        if (!selectedDeliveryType[0]) {
            return 0;
        }
        if (parseInt(selectedDeliveryType.data('separate-payment')) || parseFloat(selectedDeliveryType.data('free-from')) <= cartTotalCost) {
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

    function updateAllCosts() {
        updateCartTotalCost();
    }

    function updatePrice() {
        var _basePrice = basePrice;
        var variants = [];
        var varElements = $('select[name="ProductVariant[]"]');
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

        var price = parseFloat(newPrice.toFixed(2));
        priceElement.html(price);
        $('#product-result-price').text(price);
        $('#product-total-price').text(price * parseInt($('#product-quantity').text()));
    }

    function updateCartWidget() {
        $(cartWidgetSelector).load($('#cart-widget').data('cart-widget-url'), function () {
            miniCartListeners();
        });
    }

    function getCoupons() {
        var coupons = [];
        $.each($('.coupon-input'), function (index, elem) {
            var $elem = $(elem);
            coupons.push({
                code: $elem.data('code'),
                name: $elem.data('name'),
                value: $elem.data('value'),
                type: $elem.data('type'),
                min_order_price: $elem.data('min-order-price'),
                free_shipping: $elem.data('free-shipping')
            })
        });
        return coupons;
    }

    function updatePositionSumPrice(tr) {
        var count = parseInt(tr.find('.position-count').val());
        var price = parseFloat(tr.find('.position-price').text());
        tr.find('.position-sum-price').html(price * count);
        updateCartTotalCost();
    }

    function changePositionQuantity(productId, quantity) {
        var data = {'quantity': quantity, 'id': productId};
        data[yupeTokenName] = yupeToken;
        $.ajax({
            url: yupeCartUpdateUrl,
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.result) {
                    updateCartWidget();
                }
            }
        });
    }
});
