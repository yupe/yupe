<?php
/**
 * @var $model Order
 * @var $form TbActiveForm
 */

Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl().'/css/order-backend.css');

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
    <?= Yii::t('OrderModule.order', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('OrderModule.order', 'are required'); ?>
</div>

<?= $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                <?= $form->labelEx($model, 'status_id'); ?>
                <?php $this->widget(
                    'bootstrap.widgets.TbSelect2',
                    [
                        'model' => $model,
                        'attribute' => 'status_id',
                        'data' => OrderStatus::model()->getList(),
                        'options' => [
                            'placeholder' => Yii::t('OrderModule.order', 'Status'),
                            'width' => '100%'
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-4">
                <?=
                $form->datePickerGroup(
                    $model,
                    'date',
                    [
                        'widgetOptions' => [
                            'options' => [
                                'format' => 'dd.mm.yyyy',
                                'weekStart' => 1,
                                'autoclose' => true,

                            ],
                            'htmlOptions' => ['id' => 'orderDate'],
                        ],
                        'prepend' => '<i class="fa fa-calendar"></i>',
                    ]
                );
                ?>
            </div>
            <div class="col-sm-4">
                <?= $form->labelEx($model, 'user_id'); ?>
                <?php $this->widget(
                    'bootstrap.widgets.TbSelect2',
                    [
                        'model' => $model,
                        'attribute' => 'user_id',
                        'asDropDownList' => false,
                        'options' => [
                            'minimumInputLength' => 2,
                            'placeholder' => Yii::t('OrderModule.order', 'Select client'),
                            'width' => '100%',
                            'allowClear' => true,
                            'ajax' => [
                                'url' => Yii::app()->getController()->createUrl(
                                    '/order/orderBackend/ajaxClientSearch'
                                ),
                                'dataType' => 'json',
                                'data' => 'js:function(term, page) { return {q: term }; }',
                                'results' => 'js:function(data) { return {results: data}; }',
                            ],
                            'formatResult' => 'js:productFormatResult',
                            'formatSelection' => 'js:productFormatSelection',
                            'initSelection' => $model->client ?
                                'js:function(element,callback){callback({name:"'.$model->client->getFullName().'"})}'
                                : false,
                        ],
                        'htmlOptions' => [
                            'id' => 'client-select',
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title"><?= Yii::t('OrderModule.order', 'Products'); ?></span>
                    </div>
                    <div class="panel-body">
                        <table id="products" class="table table-hover table-responsive">
                            <tr>
                                <th><?= Yii::t('OrderModule.order', 'Image');?></th>
                                <th><?= Yii::t('OrderModule.order', 'Name');?></th>
                                <th><?= Yii::t('OrderModule.order', 'Variants');?></th>
                                <th><?= Yii::t('OrderModule.order', 'Number');?></th>
                                <th><?= Yii::t('OrderModule.order', 'Price');?></th>
                                <th></th>
                            </tr>
                            <?php $totalProductCost = 0; ?>
                            <?php foreach ((array)$model->products as $orderProduct): ?>
                                <?php $totalProductCost += $orderProduct->price * $orderProduct->quantity; ?>
                                <?php $this->renderPartial('_product_row', ['model' => $orderProduct]); ?>
                            <?php endforeach; ?>
                        </table>

                        <div class="row" id="orderAddProduct">
                            <div class="col-sm-10">
                                <?php $this->widget(
                                    'bootstrap.widgets.TbSelect2',
                                    [
                                        'name' => 'ProductSelect',
                                        'asDropDownList' => false,
                                        'options' => [
                                            'minimumInputLength' => 2,
                                            'placeholder' => Yii::t('OrderModule.order', 'Select product'),
                                            'width' => '100%',
                                            'allowClear' => true,
                                            'ajax' => [
                                                'url' => Yii::app()->getController()->createUrl(
                                                    '/order/orderBackend/ajaxProductSearch'
                                                ),
                                                'dataType' => 'json',
                                                'data' => 'js:function(term, page) { return {q: term }; }',
                                                'results' => 'js:function(data) { return {results: data}; }',
                                            ],
                                            'formatResult' => 'js:productFormatResult',
                                            'formatSelection' => 'js:productFormatSelection',
                                        ],
                                        'htmlOptions' => [
                                            'id' => 'product-select',
                                        ],
                                    ]
                                ); ?>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-primary btn-sm" href="#" id="add-product"><?= Yii::t(
                                        'OrderModule.order',
                                        'Add'
                                    ); ?></a>
                            </div>
                        </div>
                        <div class="text-right">
                            <h4>
                                <?= Yii::t('OrderModule.order', 'Total'); ?>:
                                <span id="total-product-cost"><?= $totalProductCost; ?></span>
                                <?= Yii::t('OrderModule.order', Yii::app()->getModule('store')->currency); ?>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title"><?= Yii::t('OrderModule.order', 'Delivery'); ?></span>
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
                                        'data-available-from' => $delivery->available_from,
                                    ];
                                }; ?>
                                <?=
                                $form->dropDownListGroup(
                                    $model,
                                    'delivery_id',
                                    [
                                        'widgetOptions' => [
                                            'data' => CHtml::listData(
                                                Delivery::model()->published()->findAll(),
                                                'id',
                                                'name'
                                            ),
                                            'htmlOptions' => [
                                                'empty' => Yii::t('OrderModule.order', 'Not selected'),
                                                'id' => 'delivery-type',
                                                'options' => $options,
                                            ],
                                        ],
                                    ]
                                ); ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->textFieldGroup($model, 'delivery_price'); ?>
                            </div>
                            <div class="col-sm-4">
                                <br/>
                                <?= $form->checkBoxGroup($model, 'separate_delivery'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->textFieldGroup($model, 'zipcode'); ?>
                            </div>

                            <div class="col-sm-4">
                                <?= $form->textFieldGroup($model, 'country'); ?>
                            </div>

                            <div class="col-sm-4">
                                <?= $form->textFieldGroup($model, 'city'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <?= $form->textFieldGroup($model, 'street'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <?= $form->textFieldGroup($model, 'house'); ?>
                            </div>

                            <div class="col-sm-3">
                                <?= $form->textFieldGroup($model, 'apartment'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title"><?= Yii::t('OrderModule.order', 'Payment') ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <?=
                                $form->dropDownListGroup(
                                    $model,
                                    'payment_method_id',
                                    [
                                        'widgetOptions' => [
                                            'data' => CHtml::listData(
                                                Payment::model()->published()->findAll(),
                                                'id',
                                                'name'
                                            ),
                                            'htmlOptions' => [
                                                'empty' => Yii::t('OrderModule.order', 'Not selected'),
                                            ],
                                        ],
                                    ]
                                ); ?>
                            </div>
                            <div class="col-sm-2">
                                <br/>
                                <?= $form->checkBoxGroup($model, 'paid'); ?>
                            </div>
                            <div class="col-sm-6 text-right">
                                <br/>
                                <h4>
                                    <?= Yii::t('OrderModule.order', 'Total'); ?>
                                    : <?= $model->getTotalPriceWithDelivery(); ?> <?= Yii::t(
                                        'OrderModule.order',
                                        Yii::app()->getModule('store')->currency
                                    ); ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title"><?= Yii::t('OrderModule.order', 'Note') ?></span>
                    </div>
                    <div class="panel-body">
                        <?= $form->textAreaGroup($model, 'note', ['label' => false]); ?>
                    </div>
                </div>
            </div>
            <?php if (!$model->getIsNewRecord() && isset($model->client)): ?>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="panel-title"><?= Yii::t('OrderModule.order', 'Client'); ?></span>
                        </div>
                        <div class="panel-body">
                            <?php $this->widget(
                                'bootstrap.widgets.TbDetailView',
                                [
                                    'data' => $model->client,
                                    'attributes' => [
                                        [
                                            'name' => 'full_name',
                                            'value' => CHtml::link(
                                                $model->client->getFullName(),
                                                ['/order/clientBackend/view', 'id' => $model->client->id]
                                            ),
                                            'type' => 'html',
                                        ],
                                        'nick_name',
                                        [
                                            'name' => 'email',
                                            'value' => CHtml::mailto($model->client->email, $model->client->email),
                                            'type' => 'html',
                                        ],
                                        'birth_date',
                                        'phone',
                                        [
                                            'label' => Yii::t('OrderModule.order', 'Orders'),
                                            'value' => CHtml::link(
                                                $model->client->getOrderNumber(),
                                                ['/order/orderBackend/index', 'Order[user_id]' => $model->client->id]
                                            ),
                                            'type' => 'html',
                                        ],
                                        [
                                            'label' => Yii::t('OrderModule.order', 'Money'),
                                            'value' => Yii::app()->getNumberFormatter()->formatCurrency(
                                                $model->client->getOrderSum(),
                                                Yii::app()->getModule('store')->currency
                                            ),
                                        ],
                                    ],
                                ]
                            ); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title"><?= Yii::t('OrderModule.order', 'Order details'); ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->textFieldGroup($model, 'name'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->textFieldGroup($model, 'phone'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->textFieldGroup($model, 'email'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->textAreaGroup($model, 'comment'); ?>
                            </div>
                        </div>
                        <?php if (!$model->getIsNewRecord()): ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= CHtml::link(
                                        Yii::t('OrderModule.order', 'Link to order'),
                                        ['/order/order/view', 'url' => $model->url]
                                    ); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (Yii::app()->hasModule('coupon')): ?>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title"><?= Yii::t('OrderModule.order', 'Coupons'); ?></span>
                </div>
                <?php if ($model->hasCoupons()): ?>
                    <div class="panel-body coupons">
                        <?php
                        $this->widget(
                            'yupe\widgets\CustomGridView',
                            [
                                'id' => 'order-coupon-grid',
                                'type' => 'condensed',
                                'dataProvider' => $model->searchCoupons(),
                                'actionsButtons' => false,
                                'bulkActions' => [false],
                                'template' => '{items}',
                                'columns' => [
                                    [
                                        'name' => 'coupon_id',
                                        'value' => function ($data) {
                                            return CHtml::link(
                                                $data->coupon->code,
                                                ['/coupon/couponBackend/update', 'id' => $data->coupon_id]
                                            );
                                        },
                                        'type' => 'html',
                                    ],
                                    'name' => 'create_time',
                                ],
                            ]
                        );
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="row">
    <div class="col-sm-12">
        <label class="checkbox">
            <input class="" name="notify_user" value="1" type="checkbox"><?= Yii::t(
                'OrderModule.order',
                'Inform buyer about order status'
            ); ?>
        </label>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('OrderModule.order', 'Add order and continue') : Yii::t(
            'OrderModule.order',
            'Save order and continue'
        ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('OrderModule.order', 'Add order and close') : Yii::t(
            'OrderModule.order',
            'Save order and close'
        ),
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
        if (!selectedDeliveryType.val()) {
            return 0;
        }
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
                    url: '<?= Yii::app()->getController()->createUrl('/order/orderBackend/productRow')?>',
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
