<?php
Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/order-backend.css');

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'order-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'well'),
    )
);
?>

<div class="alert alert-info hidden">
    <?php echo Yii::t('OrderModule.order', 'Поля, отмеченные'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('OrderModule.order', 'обязательны.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-4">
                <?php echo $form->dropDownListGroup(
                    $model,
                    'status',
                    array(
                        'widgetOptions' => array(
                            'data' => $model->getStatusList(),
                        ),
                    )
                ); ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->datePickerGroup(
                    $model,
                    'date',
                    array(
                        'widgetOptions' => array(
                            'options' => array(
                                'format' => 'dd.mm.yyyy',
                                'weekStart' => 1,
                                'autoclose' => true,

                            ),
                            'htmlOptions' => array('id'=>'orderDate'),
                        ),

                        'prepend' => '<i class="fa fa-calendar"></i>',
                    )
                );
                ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->labelEx($model, 'user_id'); ?>
                <?php $this->widget(
                    'bootstrap.widgets.TbSelect2',
                    array(
                        'model' => $model,
                        'attribute' => 'user_id',
                        'data' => CHtml::listData(User::model()->findAll(), 'id', 'email'),
                        'options' => array(
                            'placeholder' => Yii::t("OrderModule.order", 'E-mail пользователя'),
                            'width' => '100%',
                            'allowClear' => true,
                        )
                    )
                );?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label class="checkbox">
                    <input class="" name="notify_user" value="1" type="checkbox"><?php echo Yii::t("OrderModule.deliveorderry", "Оповестить покупателя о состоянии заказа"); ?>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title"><?php echo Yii::t("OrderModule.order", 'Товары'); ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div id="products" class="col-sm-12">
                                <?php $totalProductCost = 0; ?>
                                <?php foreach ((array)$model->products as $orderProduct): ?>
                                    <?php $totalProductCost += $orderProduct->price * $orderProduct->quantity; ?>
                                    <?php $this->renderPartial('_product_row', array('model' => $orderProduct)); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="row product-row" id="orderAddProduct">
                            <div class="col-sm-10">
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
                                                'url' => Yii::app()->controller->createUrl('/store/productBackend/ajaxSearch'),
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
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-default btn-sm" href="#" id="add-product"><?php echo Yii::t("OrderModule.order", "Добавить"); ?></a>
                            </div>
                        </div>
                        <div class="text-right">
                            <h4>
                                <?php echo Yii::t("OrderModule.order", "Всего"); ?>:
                                <span id="total-product-cost"><?php echo $totalProductCost; ?></span>
                                <?php echo Yii::t("OrderModule.order", "руб."); ?>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title"><?php echo Yii::t("OrderModule.order", "Доставка"); ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <?php
                                $options = array();
                                /* @var $delivery Delivery */
                                foreach ((array)Delivery::model()->published()->findAll() as $delivery) {
                                    $options[$delivery->id] = array(
                                        'data-separate-payment' => $delivery->separate_payment,
                                        'data-price' => $delivery->price,
                                        'data-available-from' => $delivery->available_from
                                    );
                                };?>
                                <?php echo $form->dropDownListGroup(
                                    $model,
                                    'delivery_id',
                                    array(
                                        'widgetOptions' => array(
                                            'data' => CHtml::listData(Delivery::model()->published()->findAll(), 'id', 'name'),
                                            'htmlOptions' => array(
                                                'empty' => Yii::t("OrderModule.order", 'Не выбрано'),
                                                'id' => 'delivery-type',
                                                'options' => $options,
                                            ),
                                        ),
                                    )
                                ); ?>
                            </div>
                            <div class="col-sm-4">
                                <?php echo $form->textFieldGroup($model, 'delivery_price'); ?>
                            </div>
                            <div class="col-sm-4">
                                <br/>
                                <?php echo $form->checkBoxGroup($model, 'separate_delivery'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">Оплата</span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <?php echo $form->dropDownListGroup(
                                    $model,
                                    'payment_method_id',
                                    array(
                                        'widgetOptions' => array(
                                            'data' => CHtml::listData(Payment::model()->published()->findAll(), 'id', 'name'),
                                            'htmlOptions' => array(
                                                'empty' => 'Не выбрано',
                                            ),
                                        ),
                                    )
                                ); ?>
                            </div>
                            <div class="col-sm-2">
                                <br/>
                                <?php echo $form->checkBoxGroup($model, 'paid'); ?>
                            </div>
                            <div class="col-sm-6 text-right">
                                <br/>
                                <h4>
                                    <?php echo Yii::t("OrderModule.order", "Итого"); ?>: <?php echo $model->total_price; ?> <?php echo Yii::t("OrderModule.order", "руб."); ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo $form->textAreaGroup($model, 'note'); ?>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">Детали заказа</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $form->textFieldGroup($model, 'name'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $form->textFieldGroup($model, 'phone'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $form->textFieldGroup($model, 'email'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $form->textFieldGroup($model, 'address'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo $form->textAreaGroup($model, 'comment'); ?>
                    </div>
                </div>
                <?php if (!$model->isNewRecord): ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php echo CHtml::link(Yii::t("OrderModule.order", 'Ссылка на заказ'), array('/order/order/view', 'url' => $model->url)); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if (Yii::app()->hasModule('coupon')): ?>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title"><?php echo Yii::t("OrderModule.order", "Купоны"); ?></span>
                </div>
                <div class="panel-body coupons">
                    <?php if ($model->coupon_code): ?>
                        <?php foreach ($model->couponCodes as $code): ?>
                            <?php $coupon = Coupon::model()->getCouponByCode($code); ?>
                            <span class="label alert alert-<?php echo $coupon ? 'info' : 'error'; ?> coupon" title="<?php echo !$coupon ? Yii::t(
                                "OrderModule.order",
                                'При сохранении купон будет удален'
                            ) : ''; ?>">
                                <?php
                                if ($coupon) {
                                    echo CHtml::link($code, array('/coupon/couponBackend/view', 'id' => $coupon->id), array('title' => $coupon->name));
                                } else {
                                    echo $code . ' ' . Yii::t("OrderModule.order", '[Удален]');
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
    <?php endif; ?>
</div>


<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => Yii::t('OrderModule.order', 'Сохранить и продолжить'),
    )
);
?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label' => Yii::t('OrderModule.order', 'Сохранить и вернуться к списку'),
    )
);
?>

<?php $this->endWidget(); ?>

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
                    url: '<?php echo Yii::app()->controller->createUrl('/order/orderBackend/productRow')?>',
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
            markup += "<td width='30px'><img src='" + product.thumb + "' class=''/></td>";
        }
        markup += "<td class='info'><div class='title'>" + product.name + "</div>";
        markup += "</td></tr></table>";
        return markup;
    }

    function productFormatSelection(product) {
        return product.name;
    }

</script>
