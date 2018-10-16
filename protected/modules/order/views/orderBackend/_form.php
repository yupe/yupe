<?php
Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/order-backend.css');

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'order-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => ['class' => 'well'],
    ]
);
?>

<div class="alert alert-info hidden">
    <?php echo Yii::t('OrderModule.order', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('OrderModule.order', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-4">
                <?php echo $form->dropDownListGroup(
                    $model,
                    'status',
                    [
                        'widgetOptions' => [
                            'data' => $model->getStatusList(),
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->datePickerGroup(
                    $model,
                    'date',
                    [
                        'widgetOptions' => [
                            'options' => [
                                'format' => 'dd.mm.yyyy',
                                'weekStart' => 1,
                                'autoclose' => true,

                            ],
                            'htmlOptions' => ['id'=>'orderDate'],
                        ],

                        'prepend' => '<i class="fa fa-calendar"></i>',
                    ]
                );
                ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->labelEx($model, 'user_id'); ?>
                <?php $this->widget(
                    'bootstrap.widgets.TbSelect2',
                    [
                        'model' => $model,
                        'attribute' => 'user_id',
                        'data' => CHtml::listData(User::model()->active()->findAll(), 'id', 'email'),
                        'options' => [
                            'placeholder' => Yii::t("OrderModule.order", 'User'),
                            'width' => '100%',
                            'allowClear' => true,
                        ]
                    ]
                );?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label class="checkbox">
                    <input class="" name="notify_user" value="1" type="checkbox"><?php echo Yii::t("OrderModule.order", "Inform buyer about order status"); ?>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title"><?php echo Yii::t("OrderModule.order", 'Products'); ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div id="products" class="col-sm-12">
                                <?php $totalProductCost = 0; ?>
                                <?php foreach ((array)$model->products as $orderProduct): ?>
                                    <?php $totalProductCost += $orderProduct->price * $orderProduct->quantity; ?>
                                    <?php $this->renderPartial('_product_row', ['model' => $orderProduct]); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="row product-row" id="orderAddProduct">
                            <div class="col-sm-10">
                                <?php $this->widget(
                                    'bootstrap.widgets.TbSelect2',
                                    [
                                        'name' => 'ProductSelect',
                                        'asDropDownList' => false,
                                        'options' => [
                                            'minimumInputLength' => 2,
                                            'placeholder' => 'Select product',
                                            'width' => '100%',
                                            'allowClear' => true,
                                            'ajax' => [
                                                'url' => Yii::app()->controller->createUrl('/store/productBackend/ajaxSearch'),
                                                'dataType' => 'json',
                                                'data' => 'js:function(term, page) { return {q: term }; }',
                                                'results' => 'js:function(data) { return {results: data}; }',
                                            ],
                                            'formatResult' => 'js:productFormatResult',
                                            'formatSelection' => 'js:productFormatSelection',
                                        ],
                                        'htmlOptions' => [
                                            'id' => 'product-select'
                                        ],
                                    ]
                                );?>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-default btn-sm" href="#" id="add-product"><?php echo Yii::t("OrderModule.order", "Add"); ?></a>
                            </div>
                        </div>
                        <div class="text-right">
                            <h4>
                                <?php echo Yii::t("OrderModule.order", "Total"); ?>:
                                <span id="total-product-cost"><?php echo $totalProductCost; ?></span>
                                <?php echo Yii::t("OrderModule.order", "RUB"); ?>
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
                        <span class="panel-title"><?php echo Yii::t("OrderModule.order", "Delivery"); ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <?php
                                $options = [];
                                /* @var $delivery Delivery */
                                foreach ((array)Delivery::model()->published()->findAll() as $delivery) {
                                    $options[$delivery->id] = [
                                        'data-separate-payment' => $delivery->separate_payment,
                                        'data-price' => $delivery->price,
                                        'data-available-from' => $delivery->available_from
                                    ];
                                };?>
                                <?php echo $form->dropDownListGroup(
                                    $model,
                                    'delivery_id',
                                    [
                                        'widgetOptions' => [
                                            'data' => CHtml::listData(Delivery::model()->published()->findAll(), 'id', 'name'),
                                            'htmlOptions' => [
                                                'empty' => Yii::t("OrderModule.order", 'Not selected'),
                                                'id' => 'delivery-type',
                                                'options' => $options,
                                            ],
                                        ],
                                    ]
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
                        <span class="panel-title"><?php echo Yii::t("OrderModule.order", 'Payment') ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <?php echo $form->dropDownListGroup(
                                    $model,
                                    'payment_method_id',
                                    [
                                        'widgetOptions' => [
                                            'data' => CHtml::listData(Payment::model()->published()->findAll(), 'id', 'name'),
                                            'htmlOptions' => [
                                                'empty' => Yii::t("OrderModule.order", 'Not selected'),
                                            ],
                                        ],
                                    ]
                                ); ?>
                            </div>
                            <div class="col-sm-2">
                                <br/>
                                <?php echo $form->checkBoxGroup($model, 'paid'); ?>
                            </div>
                            <div class="col-sm-6 text-right">
                                <br/>
                                <h4>
                                    <?php echo Yii::t("OrderModule.order", "Total"); ?>: <?php echo $model->total_price; ?> <?php echo Yii::t("OrderModule.order", "RUB"); ?>
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
                <span class="panel-title"><?php echo Yii::t("OrderModule.order", "Order details"); ?></span>
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
                            <?php echo CHtml::link(Yii::t("OrderModule.order", 'Link to order'), ['/order/order/view', 'url' => $model->url]); ?>
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
                    <span class="panel-title"><?php echo Yii::t("OrderModule.order", "Coupons"); ?></span>
                </div>
                <div class="panel-body coupons">
                    <?php if ($model->coupon_code): ?>
                        <?php foreach ($model->getCouponsCodes() as $code): ?>
                            <?php $coupon = Coupon::model()->getCouponByCode($code); ?>
                            <span class="label alert alert-<?php echo $coupon ? 'info' : 'error'; ?> coupon" title="<?php echo !$coupon ? Yii::t(
                                "OrderModule.order",
                                'Coupon will be deleted after save'
                            ) : ''; ?>">
                                <?php
                                if ($coupon) {
                                    echo CHtml::link($code, ['/coupon/couponBackend/view', 'id' => $coupon->id], ['title' => $coupon->name]);
                                } else {
                                    echo $code . ' ' . Yii::t("OrderModule.order", '[Deleted]');
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
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('OrderModule.order', 'Add order and continue') : Yii::t('OrderModule.order', 'Save order and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('OrderModule.order', 'Add order and close') : Yii::t('OrderModule.order', 'Save order and close'),
    ]
); ?>

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
