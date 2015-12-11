<?php
/* @var $this CartController */
/* @var $positions Product[] */
/* @var $order Order */
/* @var $coupons Coupon[] */

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();

Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/cart-frontend.css');

$this->title = Yii::t('CartModule.cart', 'Cart');
$this->breadcrumbs = [
    Yii::t("CartModule.cart", 'Catalog') => ['/store/product/index'],
    Yii::t("CartModule.cart", 'Cart')
];
?>


<script type="text/javascript">
    var yupeCartDeleteProductUrl = '<?= Yii::app()->createUrl('/cart/cart/delete/')?>';
    var yupeCartUpdateUrl = '<?= Yii::app()->createUrl('/cart/cart/update/')?>';
    var yupeCartWidgetUrl = '<?= Yii::app()->createUrl('/cart/cart/widget/')?>';
    var yupeCartEmptyMessage = '<h1><?= Yii::t("CartModule.cart", "Cart is empty"); ?></h1><?= Yii::t("CartModule.cart", "There are no products in cart"); ?>';
</script>

<div class="row">
    <div id="cart-body" class="col-sm-12">
        <?php if (Yii::app()->cart->isEmpty()): ?>
            <h1><?= Yii::t("CartModule.cart", "Cart is empty"); ?></h1>
            <?= Yii::t("CartModule.cart", "There are no products in cart"); ?>
        <?php else: ?>
            <?php
            $form = $this->beginWidget(
                'bootstrap.widgets.TbActiveForm',
                [
                    'action' => ['/order/order/create'],
                    'id' => 'order-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions' => [
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                        'validateOnType' => false,
                        'beforeValidate' => 'js:function(form){$(form).find("button[type=\'submit\']").prop("disabled", true); return true;}',
                        'afterValidate' => 'js:function(form, data, hasError){$(form).find("button[type=\'submit\']").prop("disabled", false); return !hasError;}',
                    ],
                    'htmlOptions' => [
                        'hideErrorMessage' => false,
                        'class' => 'order-form',
                    ]
                ]
            );
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th><?= Yii::t("CartModule.cart", "Product"); ?></th>
                        <th><?= Yii::t("CartModule.cart", "Amount"); ?></th>
                        <th class="text-center"><?= Yii::t("CartModule.cart", "Price"); ?></th>
                        <th class="text-center"><?= Yii::t("CartModule.cart", "Sum"); ?></th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($positions as $position): ?>
                        <tr class="cart-position">
                            <td class="col-sm-5">
                                <?php $positionId = $position->getId(); ?>
                                <?= CHtml::hiddenField('OrderProduct[' . $positionId . '][product_id]', $position->id); ?>
                                <input type="hidden" class="position-id" value="<?= $positionId; ?>"/>

                                <div class="media">
                                    <?php $productUrl = Yii::app()->createUrl('/store/product/view', ['name' => $position->slug]); ?>
                                    <a class="img-thumbnail pull-left" href="<?= $productUrl; ?>">
                                        <img class="media-object" src="<?= $position->getProductModel()->getImageUrl(72, 72); ?>">
                                    </a>

                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="<?= $productUrl; ?>"><?= $position->name; ?></a>
                                        </h4>
                                        <?php foreach ($position->selectedVariants as $variant): ?>
                                            <h6><?= $variant->attribute->title; ?>: <?= $variant->getOptionValue(); ?></h6>
                                            <?= CHtml::hiddenField('OrderProduct[' . $positionId . '][variant_ids][]', $variant->id); ?>
                                        <?php endforeach; ?>
                                        <span>
                                            <?= Yii::t("CartModule.cart", "Status"); ?>:
                                        </span>
                                        <span class="text-<?= $position->in_stock ? "success" : "warning"; ?>">
                                            <strong><?= $position->in_stock ? Yii::t("CartModule.cart", "In stock") : Yii::t("CartModule.cart", "Not in stock"); ?></strong>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="col-sm-2">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default cart-quantity-decrease" type="button" data-target="#cart_<?= $positionId; ?>">-</button>
                                    </div>
                                    <?= CHtml::textField(
                                        'OrderProduct[' . $positionId . '][quantity]',
                                        $position->getQuantity(),
                                        ['id' => 'cart_' . $positionId, 'class' => 'form-control text-center position-count']
                                    ); ?>
                                    <div class="input-group-btn">
                                        <button class="btn btn-default cart-quantity-increase" type="button" data-target="#cart_<?= $positionId; ?>">+</button>
                                    </div>
                                </div>
                            </td>
                            <td class="col-sm-2 text-center">
                                <strong>
                                    <span class="position-price"><?= $position->getPrice(); ?></span>
                                    <?= Yii::t("CartModule.cart", "RUB"); ?>
                                </strong>
                            </td>
                            <td class="col-sm-2 text-center">
                                <strong>
                                    <span class="position-sum-price"><?= $position->getSumPrice(); ?></span>
                                    <?= Yii::t("CartModule.cart", "RUB"); ?>
                                </strong>
                            </td>
                            <td class="col-sm-1 text-right">
                                <button type="button" class="btn btn-danger cart-delete-product" data-position-id="<?= $positionId; ?>">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>  </td>
                        <td colspan="2">
                            <h5><?= Yii::t("CartModule.cart", "Subtotal"); ?></h5>
                        </td>
                        <td colspan="2" style="text-align: right;">
                            <h4>
                                <strong id="cart-full-cost">
                                    <?= Yii::app()->cart->getCost(); ?>
                                </strong>
                                <?= Yii::t("CartModule.cart", "RUB"); ?>
                            </h4>
                        </td>
                    </tr>
                    <?php if (Yii::app()->hasModule('coupon')): ?>
                        <tr>
                            <td colspan="5" class="coupons">
                                <p>
                                    <b><?= Yii::t("CartModule.cart", "Coupons"); ?></b>
                                </p>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input id="coupon-code" type="text" class="form-control">
                                            <div class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="add-coupon-code"><?= Yii::t("CartModule.cart", "Add coupon"); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php foreach ($coupons as $coupon): ?>
                                            <span class="label alert alert-info coupon" title="<?= $coupon->name; ?>">
                                                <?= $coupon->code; ?>
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <?= CHtml::hiddenField(
                                                    "Order[couponCodes][{$coupon->code}]",
                                                    $coupon->code,
                                                    [
                                                        'class' => 'coupon-input',
                                                        'data-code' => $coupon->code,
                                                        'data-name' => $coupon->name,
                                                        'data-value' => $coupon->value,
                                                        'data-type' => $coupon->type,
                                                        'data-min-order-price' => $coupon->min_order_price,
                                                        'data-free-shipping' => $coupon->free_shipping,
                                                    ]
                                                );?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="5">
                        <?php if(!empty($deliveryTypes)):?>
                            <fieldset>
                                <div class="form-group">
                                    <label class="control-label" for="radios">
                                        <b><?= Yii::t("CartModule.cart", "Delivery method"); ?></b>
                                    </label>
                                    <div class="controls">
                                        <?php foreach ($deliveryTypes as $key => $delivery): ?>
                                            <label class="radio" for="delivery-<?= $delivery->id; ?>">
                                                <input type="radio" name="Order[delivery_id]" id="delivery-<?= $delivery->id; ?>"
                                                       value="<?= $delivery->id; ?>"
                                                       data-price="<?= $delivery->price; ?>"
                                                       data-free-from="<?= $delivery->free_from; ?>"
                                                       data-available-from="<?= $delivery->available_from; ?>"
                                                       data-separate-payment="<?= $delivery->separate_payment; ?>">
                                                <?= $delivery->name; ?> - <?= $delivery->price; ?>
                                                <?= Yii::t("CartModule.cart", "RUB"); ?>(
                                                <?= Yii::t("CartModule.cart", "available from"); ?>
                                                <?= $delivery->available_from; ?>
                                                <?= Yii::t("CartModule.cart", "RUB"); ?>;
                                                <?= Yii::t("CartModule.cart", "free from"); ?> <?= $delivery->free_from; ?>
                                                <?= Yii::t("CartModule.cart", "RUB"); ?>; )
                                                <?=($delivery->separate_payment ? Yii::t("CartModule.cart", "Pay separately") : ""); ?>
                                            </label>
                                            <div class="text-muted">
                                                <?= $delivery->description; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </fieldset>
                        <?php else:?>
                            <div class="alert alert-danger">
                                <?= Yii::t("CartModule.cart", "Delivery method aren't selected! The ordering is impossible!") ?>
                            </div>
                        <?php endif;?>   
                        </td>
                    </tr>
                    <tr>
                        <td>  </td>
                        <td colspan="2">
                            <h5>
                                <?= Yii::t("CartModule.cart", "Delivery price"); ?>
                            </h5>
                        </td>
                        <td colspan="2" style="text-align: right;">
                            <h4><strong id="cart-shipping-cost">0</strong> <?= Yii::t("CartModule.cart", "RUB"); ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td>  </td>
                        <td colspan="2"><h4><?= Yii::t("CartModule.cart", "Total"); ?></h4></td>
                        <td colspan="2" style="text-align: right;">
                            <h4><strong id="cart-full-cost-with-shipping">0</strong> <?= Yii::t("CartModule.cart", "RUB"); ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <table class="col-sm-6 order-receiver">
                                <thead>
                                    <tr>
                                        <th>
                                            <?= Yii::t("CartModule.cart", "Address"); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div>
                                                <?= $form->errorSummary($order); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?= $form->labelEx($order, 'name'); ?>
                                                <?= $form->textField($order, 'name', ['class' => 'form-control']); ?>
                                                <?= $form->error($order, 'name'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?= $form->labelEx($order, 'email'); ?>
                                                <?= $form->emailField($order, 'email', ['class' => 'form-control']); ?>
                                                <?= $form->error($order, 'email'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?= $form->labelEx($order, 'phone'); ?>
                                                <?= $form->textField($order, 'phone', ['class' => 'form-control']); ?>
                                                <?= $form->error($order, 'phone'); ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div>
                                                <?= $form->labelEx($order, 'zipcode'); ?>
                                                <?= $form->textField($order, 'zipcode', ['class' => 'form-control']); ?>
                                                <?= $form->error($order, 'zipcode'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?= $form->labelEx($order, 'country'); ?>
                                                <?= $form->textField($order, 'country', ['class' => 'form-control']); ?>
                                                <?= $form->error($order, 'country'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?= $form->labelEx($order, 'city'); ?>
                                                <?= $form->textField($order, 'city', ['class' => 'form-control']); ?>
                                                <?= $form->error($order, 'city'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?= $form->labelEx($order, 'street'); ?>
                                                <?= $form->textField($order, 'street', ['class' => 'form-control']); ?>
                                                <?= $form->error($order, 'street'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?= $form->labelEx($order, 'house'); ?>
                                                <?= $form->textField($order, 'house', ['class' => 'form-control']); ?>
                                                <?= $form->error($order, 'house'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?= $form->labelEx($order, 'apartment'); ?>
                                                <?= $form->textField($order, 'apartment', ['class' => 'form-control']); ?>
                                                <?= $form->error($order, 'apartment'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?= $form->labelEx($order, 'comment'); ?>
                                            <?= $form->textArea($order, 'comment', ['class' => 'form-control']); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right;">
                            <a href="<?= Yii::app()->createUrl('store/product/index'); ?>" class="btn btn-default">
                                <span class="glyphicon glyphicon-shopping-cart"></span>
                                <?= Yii::t("CartModule.cart", "Back to catalog"); ?>
                            </a>
                            <button type="submit" class="btn btn-success">
                                <?= Yii::t("CartModule.cart", "Create order and proceed to payment"); ?>
                                <span class="glyphicon glyphicon-play"></span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php $this->endWidget(); ?>
        <?php endif; ?>
    </div>
</div>
