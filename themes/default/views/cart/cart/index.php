<?php
/* @var $positions Product[] */
/* @var $order Order */
/* @var $coupons Coupon[] */
Yii::app()->getClientScript()->registerCssFile(
    Yii::app()->getModule('cart')->getAssetsUrl(). '/css/cart-frontend.css'
);

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

$this->pageTitle = Yii::t('CartModule.cart', 'Корзина');
$this->breadcrumbs = array(Yii::t("CartModule.cart", 'Корзина'));
?>


<script type="text/javascript">
    var yupeCartDeleteProductUrl = '<?= Yii::app()->createUrl('/cart/cart/delete/')?>';
    var yupeCartUpdateUrl = '<?= Yii::app()->createUrl('/cart/cart/update/')?>';
    var yupeCartWidgetUrl = '<?= Yii::app()->createUrl('/cart/cart/widget/')?>';
</script>

<div class="row">
    <div class="col-sm-12">
        <?php if (Yii::app()->cart->isEmpty()): ?>
            <h1><?php echo Yii::t("CartModule.cart", "Корзина пуста"); ?></h1>
            <?php echo Yii::t("CartModule.cart", "В корзине нет товаров"); ?>
        <?php else: ?>
            <?php
            $form = $this->beginWidget(
                'bootstrap.widgets.TbActiveForm',
                array(
                    'action' => array('/order/order/create'),
                    'id' => 'order-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                        'validateOnType' => false,
                        'beforeValidate' => 'js:function(form){$(form).find("button[type=\'submit\']").prop("disabled", true); return true;}',
                        'afterValidate' => 'js:function(form, data, hasError){$(form).find("button[type=\'submit\']").prop("disabled", false); return !hasError;}',
                    ),
                    'htmlOptions' => array(
                        'hideErrorMessage' => false,
                        'class' => 'order-form',
                    )
                )
            );
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo Yii::t("CartModule.cart", "Продукт"); ?></th>
                        <th><?php echo Yii::t("CartModule.cart", "Количество"); ?></th>
                        <th class="text-center"><?php echo Yii::t("CartModule.cart", "Цена"); ?></th>
                        <th class="text-center"><?php echo Yii::t("CartModule.cart", "Сумма"); ?></th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($positions as $position): ?>
                        <tr>
                            <td class="col-sm-5">
                                <?php $positionId = $position->getId(); ?>
                                <?php echo CHtml::hiddenField('OrderProduct[' . $positionId . '][product_id]', $position->id); ?>
                                <input type="hidden" class="position-id" value="<?php echo $positionId; ?>"/>

                                <div class="media">
                                    <?php $productUrl = Yii::app()->createUrl('store/catalog/show', array('name' => $position->alias)); ?>
                                    <a class="img-thumbnail pull-left" href="<?php echo $productUrl; ?>">
                                        <img class="media-object" src="<?php echo $position->getProductModel()->getImageUrl(72, 72); ?>" style="width: 72px; height: 72px;">
                                    </a>

                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="<?php echo $productUrl; ?>"><?php echo $position->name; ?></a>
                                        </h4>
                                        <?php foreach ($position->selectedVariants as $variant): ?>
                                            <h6><?php echo $variant->attribute->title; ?>: <?php echo $variant->getOptionValue(); ?></h6>
                                            <?php echo CHtml::hiddenField('OrderProduct[' . $positionId . '][variant_ids][]', $variant->id); ?>
                                        <?php endforeach; ?>
                                        <span>
                                            <?php echo Yii::t("CartModule.cart", "Статус"); ?>:
                                        </span>
                                        <span class="text-<?php echo $position->in_stock ? "success" : "warning"; ?>">
                                            <strong><?php echo $position->in_stock ? Yii::t("CartModule.cart", "В наличии") : Yii::t("CartModule.cart", "Нет в наличии"); ?></strong>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="col-sm-2">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default cart-quantity-decrease" type="button" data-target="#cart_<?php echo $positionId; ?>">-</button>
                                    </div>
                                    <?php echo CHtml::textField(
                                        'OrderProduct[' . $positionId . '][quantity]',
                                        $position->getQuantity(),
                                        array('id' => 'cart_' . $positionId, 'class' => 'form-control text-center position-count')
                                    ); ?>
                                    <div class="input-group-btn">
                                        <button class="btn btn-default cart-quantity-increase" type="button" data-target="#cart_<?php echo $positionId; ?>">+</button>
                                    </div>
                                </div>
                            </td>
                            <td class="col-sm-2 text-center">
                                <strong>
                                    <span class="position-price"><?php echo $position->getPrice(); ?></span>
                                    <?php echo Yii::t("CartModule.cart", "руб."); ?>
                                </strong>
                            </td>
                            <td class="col-sm-2 text-center">
                                <strong>
                                    <span class="position-sum-price"><?php echo $position->getSumPrice(); ?></span>
                                    <?php echo Yii::t("CartModule.cart", "руб."); ?>
                                </strong>
                            </td>
                            <td class="col-sm-1 text-right">
                                <button type="button" class="btn btn-danger cart-delete-product" data-position-id="<?php echo $positionId; ?>">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>  </td>
                        <td colspan="2">
                            <h5><?php echo Yii::t("CartModule.cart", "Промежуточный итог"); ?></h5>
                        </td>
                        <td colspan="2" style="text-align: right;">
                            <h4>
                                <strong id="cart-full-cost">
                                    <?php echo Yii::app()->cart->getCost(); ?>
                                </strong>
                                <?php echo Yii::t("CartModule.cart", "руб."); ?>
                            </h4>
                        </td>
                    </tr>
                    <?php if (Yii::app()->hasModule('coupon')): ?>
                        <tr>
                            <td colspan="5" class="coupons">
                                <p>
                                    <b><?php echo Yii::t("CartModule.cart", "Купоны"); ?></b>
                                </p>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="input-group">
                                            <input id="coupon-code" type="text" class="form-control">
                                            <div class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="add-coupon-code"><?php echo Yii::t("CartModule.cart", "Добавить купон"); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php foreach ($coupons as $coupon): ?>
                                            <span class="label alert alert-info coupon" title="<?php echo $coupon->name; ?>">
                                                <?php echo $coupon->code; ?>
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <?php echo CHtml::hiddenField(
                                                    "Order[couponCodes][{$coupon->code}]",
                                                    $coupon->code,
                                                    array(
                                                        'class' => 'coupon-input',
                                                        'data-code' => $coupon->code,
                                                        'data-name' => $coupon->name,
                                                        'data-value' => $coupon->value,
                                                        'data-type' => $coupon->type,
                                                        'data-min-order-price' => $coupon->min_order_price,
                                                        'data-free-shipping' => $coupon->free_shipping,
                                                    )
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
                            <fieldset>
                                <div class="form-group">
                                    <label class="control-label" for="radios">
                                        <b><?php echo Yii::t("CartModule.cart", "Способ доставки"); ?></b>
                                    </label>
                                    <div class="controls">
                                        <?php foreach ($deliveryTypes as $key => $delivery): ?>
                                            <label class="radio" for="delivery-<?php echo $delivery->id; ?>">
                                                <input type="radio" name="Order[delivery_id]" id="delivery-<?php echo $delivery->id; ?>"
                                                       value="<?php echo $delivery->id; ?>"
                                                       data-price="<?php echo $delivery->price; ?>"
                                                       data-free-from="<?php echo $delivery->free_from; ?>"
                                                       data-available-from="<?php echo $delivery->available_from; ?>"
                                                       data-separate-payment="<?php echo $delivery->separate_payment; ?>">
                                                <?php echo $delivery->name; ?> - <?php echo $delivery->price; ?>
                                                <?php echo Yii::t("CartModule.cart", "руб."); ?>(
                                                <?php echo Yii::t("CartModule.cart", "доступно от"); ?>
                                                <?php echo $delivery->available_from; ?>
                                                <?php echo Yii::t("CartModule.cart", "руб."); ?>;
                                                <?php echo Yii::t("CartModule.cart", "бесплатно от"); ?> <?php echo $delivery->free_from; ?>
                                                <?php echo Yii::t("CartModule.cart", "руб."); ?>; )
                                                <?php echo($delivery->separate_payment ? Yii::t("CartModule.cart", "Оплачивается отдельно") : ""); ?>
                                            </label>
                                            <div class="text-muted">
                                                <?php echo $delivery->description; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td>  </td>
                        <td colspan="2">
                            <h5>
                                <?php echo Yii::t("CartModule.cart", "Стоимость доставки"); ?>
                            </h5>
                        </td>
                        <td colspan="2" style="text-align: right;">
                            <h4><strong id="cart-shipping-cost">0</strong> <?php echo Yii::t("CartModule.cart", "руб."); ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td>  </td>
                        <td colspan="2"><h4><?php echo Yii::t("CartModule.cart", "Всего"); ?></h4></td>
                        <td colspan="2" style="text-align: right;">
                            <h4><strong id="cart-full-cost-with-shipping">0</strong> <?php echo Yii::t("CartModule.cart", "руб."); ?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <table class="col-sm-6 order-receiver">
                                <thead>
                                    <tr>
                                        <th>
                                            <?php echo Yii::t("CartModule.cart", "Адрес получателя"); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div>
                                                <?php echo $form->errorSummary($order); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?php echo $form->labelEx($order, 'name'); ?>
                                                <?php echo $form->textField($order, 'name', array('class' => 'form-control')); ?>
                                                <?php echo $form->error($order, 'name'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?php echo $form->labelEx($order, 'phone'); ?>
                                                <?php echo $form->textField($order, 'phone', array('class' => 'form-control')); ?>
                                                <?php echo $form->error($order, 'phone'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?php echo $form->labelEx($order, 'email'); ?>
                                                <?php echo $form->emailField($order, 'email', array('class' => 'form-control')); ?>
                                                <?php echo $form->error($order, 'email'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <?php echo $form->labelEx($order, 'address'); ?>
                                                <?php echo $form->textField($order, 'address', array('class' => 'form-control')); ?>
                                                <?php echo $form->error($order, 'address'); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo $form->labelEx($order, 'comment'); ?>
                                            <?php echo $form->textArea($order, 'comment', array('class' => 'form-control')); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right;">
                            <a href="<?php echo Yii::app()->createUrl('store/catalog/index'); ?>" class="btn btn-default">
                                <span class="glyphicon glyphicon-shopping-cart"></span>
                                <?php echo Yii::t("CartModule.cart", "Вернуться к каталогу"); ?>
                            </a>
                            <button type="submit" class="btn btn-success">
                                <?php echo Yii::t("CartModule.cart", "Создать заказ и перейти к оплате"); ?>
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
