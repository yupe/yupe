<?php

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id' => 'order-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well'),
        'inlineErrors' => true,
    )
);
?>

    <div class="alert alert-info hidden">
        <?php echo Yii::t('ShopModule.delivery', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('ShopModule.delivery', 'обязательны.'); ?>
    </div>

<?php echo $form->errorSummary($model); ?>
    <div class="row-fluid">
        <div class="span8">
            <div class="row-fluid">
                <div class="span4 control-group <?php echo ($model->hasErrors('status') || $model->hasErrors('status')) ? 'error' : ''; ?>">
                    <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'span12')); ?>
                </div>
                <div class="span4 control-group  <?php echo $model->hasErrors('date') ? 'error' : ''; ?>">
                    <?php
                    echo $form->datepickerRow(
                        $model,
                        'date',
                        array(
                            'options' => array(
                                'format' => 'dd.mm.yyyy',
                                'weekStart' => 1,
                                'autoclose' => true,
                            ),
                            'htmlOptions' => array(
                                'class' => 'span12',
                                'disabled' => 'disabled',
                            ),
                        ),
                        array(
                            'prepend' => '<i class="icon-calendar"></i>',
                        )
                    ); ?>
                </div>
                <div class="span4 control-group  <?php echo $model->hasErrors('user_id') ? 'error' : ''; ?>">
                    <?php echo $form->labelEx($model, 'user_id'); ?>
                    <?php $this->widget(
                        'bootstrap.widgets.TbSelect2',
                        array(
                            'model' => $model,
                            'attribute' => 'user_id',
                            'data' => CHtml::listData(User::model()->findAll(), 'id', 'email'),

                            'options' => array(
                                'placeholder' => 'E-mail пользователя',
                                'width' => '100%',
                                'allowClear' => true,
                            )
                        )
                    );?>
                </div>
            </div>
            <div class="row-fluid  panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">Товары</span>
                </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div id="products" class="span12">
                            <?php $totalProductCost = 0; ?>
                            <?php foreach ((array)$model->products as $orderProduct): ?>
                                <?php $totalProductCost += $orderProduct->price * $orderProduct->quantity; ?>
                                <?php $this->renderPartial('_product_row', array('model' => $orderProduct)); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span8">
                            <?php $this->widget(
                                'bootstrap.widgets.TbSelect2',
                                array(
                                    'name' => 'ProductSelect',
                                    'asDropDownList' => false,
                                    'options' => array(
                                        'minimumInputLength' => 2,
                                        'placeholder' => 'Выберите товар для добавления',
                                        'width' => '100%',
                                        'allowClear' => true,
                                        'ajax' => array(
                                            'url' => Yii::app()->controller->createUrl('/shop/productBackend/ajaxSearch'),
                                            'dataType' => 'json',
                                            'data' => 'js:function(term, page) { return {q: term }; }',
                                            'results' => 'js:function(data) { return {results: data}; }',
                                        ),
                                        'formatResult' => 'js:productFormatResult',
                                        'formatSelection' => 'js:productFormatSelection',
                                    ),
                                    'htmlOptions' => array(
                                        'id' => 'product-select'
                                    ),
                                )
                            );?>
                            <script type="text/javascript">
                                function updateTotalProductCost() {
                                    var cost = 0;
                                    $.each($('#products').find('.product-row'), function (index, elem) {
                                        var quantity = parseInt($(elem).find('.product-quantity').val());
                                        var price = parseFloat($(elem).find('.product-price').val());
                                        cost += quantity * price;
                                    });
                                    $('#total-product-cost').html(parseFloat(cost.toFixed(2)));
                                }
                                function updatePrice($productRowElement) {
                                    var basePrice = parseFloat($productRowElement.find('.product-base-price').val());
                                    var _basePrice = basePrice;
                                    var variants = [];
                                    var hasBasePriceVariant = false;
                                    $.each($productRowElement.find('.product-variant'), function (index, elem) {
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
                                    $.each($productRowElement.find('.product-variant'), function (index, elem) {
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

                                    $productRowElement.find('.product-price').val(parseFloat(newPrice.toFixed(2)));
                                    updateTotalProductCost();
                                }

                                function getShippingCost() {
                                    var cartTotalCost = parseFloat($('#total-product-cost').text());
                                    var selectedDeliveryType = $('#delivery-type').find(':selected');
                                    if (!selectedDeliveryType.val()) {return 0;}
                                    if (parseFloat(selectedDeliveryType.data('free-from')) < cartTotalCost) {
                                        return 0;
                                    } else {
                                        return parseFloat(selectedDeliveryType.data('price'));
                                    }
                                }

                                function updateShippingCost() {
                                    $('#delivery-price').val(getShippingCost());
                                }

                                $(document).ready(function () {
                                    $('#add-product').click(function (e) {
                                        e.preventDefault();
                                        var productId = $("#product-select").select2("val");
                                        if (productId) {
                                            $.ajax({
                                                url: '<?php echo Yii::app()->controller->createUrl('/shop/orderBackend/productRow')?>',
                                                type: 'get',
                                                data: {
                                                    'OrderProduct[product_id]': productId
                                                },
                                                success: function (data) {
                                                    $('#products').append(data);
                                                }
                                            });
                                        }
                                    });

                                    $('#products').on('click', '.remove-product', function (e) {
                                        e.preventDefault();
                                        $(this).parents('.product-row').remove();
                                    });

                                    $('#products').on('change', '.product-variant', function () {
                                        updatePrice($(this).parents('.product-row'));
                                    });

                                    $('#delivery-type').change(function () {
                                        updateShippingCost();
                                    });
                                });

                                function productFormatResult(product) {
                                    var markup = "<table class='result'><tr>";
                                    if (product.thumb !== undefined) {
                                        markup += "<td width='30px'><img src='" + product.thumb + "' class='thumbnail'/></td>";
                                    }
                                    markup += "<td class='info'><div class='title'>" + product.name + "</div>";
                                    markup += "</td></tr></table>";
                                    return markup;
                                }

                                function productFormatSelection(product) {
                                    return product.name;
                                }

                            </script>
                        </div>
                        <div class="span1">
                            <a class="btn btn-small" href="#" id="add-product">Добавить</a>
                        </div>
                        <div class="span3 text-right">
                            <h4>
                                Всего: <span id="total-product-cost"><?php echo $totalProductCost; ?></span> руб.
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid  panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">Доставка</span>
                </div>
                <div class="panel-body">
                    <div class="span4 control-group <?php echo $model->hasErrors('delivery_id') ? 'error' : ''; ?>">
                        <?php
                        $options = array();
                        /* @var $delivery Delivery */
                        foreach ((array)Delivery::model()->published()->findAll() as $delivery)
                        {
                            $options[$delivery->id] = array('data-separate-payment' => $delivery->separate_payment, 'data-price' => $delivery->price, 'data-available-from' => $delivery->available_from);
                        };?>
                        <?php echo $form->dropDownListRow($model, 'delivery_id', CHtml::listData(Delivery::model()->published()->findAll(), 'id', 'name'), array('empty' => 'Не выбрано', 'id' => 'delivery-type', 'options' => $options)); ?>
                    </div>
                    <div class="span4 control-group <?php echo $model->hasErrors('delivery_price') ? 'error' : ''; ?>">
                        <?php echo $form->textFieldRow($model, 'delivery_price', array('class' => '', 'size' => 60, 'maxlength' => 60, 'id' => 'delivery-price')); ?>
                    </div>
                    <div class="span4 control-group <?php echo $model->hasErrors('separate_delivery') ? 'error' : ''; ?>">
                        <br/>
                        <?php echo $form->checkBoxRow($model, 'separate_delivery', array('class' => '',)); ?>
                    </div>
                </div>
            </div>

            <div class="row-fluid  panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">Оплата</span>
                </div>
                <div class="panel-body">
                    <div class="span4 control-group <?php echo $model->hasErrors('payment_method_id') ? 'error' : ''; ?>">
                        <?php echo $form->dropDownListRow($model, 'payment_method_id', CHtml::listData(Payment::model()->published()->findAll(), 'id', 'name'), array('empty' => 'Не выбрано')); ?>
                    </div>
                    <div class="span4 control-group <?php echo $model->hasErrors('paid') ? 'error' : ''; ?>">
                        <br/>
                        <?php echo $form->checkBoxRow($model, 'paid', array('class' => '',)); ?>
                    </div>
                    <div class="row-fluid text-right">
                        <h4>
                            Итого: <?php echo $model->total_price; ?> руб.
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row-fluid control-group <?php echo ($model->hasErrors('note') || $model->hasErrors('comment')) ? 'error' : ''; ?>">
                <?php echo $form->textAreaRow($model, 'note', array('class' => 'span12', 'rows' => 2, 'maxlength' => 1024)); ?>
            </div>
        </div>

        <div class="span4 panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">Детали заказа</span>
            </div>
            <div class="panel-body">
                <div class="row-fluid control-group <?php echo ($model->hasErrors('name') || $model->hasErrors('name')) ? 'error' : ''; ?>">
                    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span12', 'size' => 60, 'maxlength' => 250)); ?>
                </div>
                <div class="row-fluid control-group <?php echo ($model->hasErrors('phone') || $model->hasErrors('phone')) ? 'error' : ''; ?>">
                    <?php echo $form->textFieldRow($model, 'phone', array('class' => 'span12', 'size' => 60, 'maxlength' => 250)); ?>
                </div>
                <div class="row-fluid control-group <?php echo ($model->hasErrors('email') || $model->hasErrors('email')) ? 'error' : ''; ?>">
                    <?php echo $form->textFieldRow($model, 'email', array('class' => 'span12', 'size' => 60, 'maxlength' => 250)); ?>
                </div>
                <div class="row-fluid control-group <?php echo ($model->hasErrors('address') || $model->hasErrors('address')) ? 'error' : ''; ?>">
                    <?php echo $form->textFieldRow($model, 'address', array('class' => 'span12', 'size' => 60, 'maxlength' => 250)); ?>
                </div>
                <div class="row-fluid control-group <?php echo ($model->hasErrors('comment') || $model->hasErrors('comment')) ? 'error' : ''; ?>">
                    <?php echo $form->textAreaRow($model, 'comment', array('class' => 'span12', 'rows' => 2, 'maxlength' => 1024)); ?>
                </div>
                <?php if (!$model->isNewRecord): ?>
                    <div class="row-fluid">
                        <?php echo CHtml::link('Ссылка на заказ', array('/shop/order/view', 'url' => $model->url)); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="span4 panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">Купоны</span>
            </div>
            <div class="panel-body coupons">
                <?php if ($model->coupon_code): ?>
                    <?php foreach ($model->couponCodes as $code): ?>
                        <?php $coupon = Coupon::model()->getCouponByCode($code); ?>
                        <span class="label alert alert-<?php echo $coupon ? 'info' : 'error'; ?> coupon" title="<?php echo !$coupon ? 'При сохранении купон будет удален' : ''; ?>">
                                <?php
                                if ($coupon)
                                {
                                    echo CHtml::link($code, array('/shop/couponBackend/view', 'id' => $coupon->id), array('title' => $coupon->name));
                                }
                                else
                                {
                                    echo $code . ' [Удален]';
                                }
                                ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo CHtml::hiddenField("Order[couponCodes][{$coupon->code}]", $coupon->code); ?>
                        </span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>


<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => Yii::t('ShopModule.delivery', 'Сохранить и продолжить'),
    ));
?>

<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label' => Yii::t('ShopModule.delivery', 'Сохранить и вернуться к списку'),
    ));
?>

<?php $this->endWidget(); ?>