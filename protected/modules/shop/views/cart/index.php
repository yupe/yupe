<?php
/* @var $positions Product[] */
/* @var $order Order */
/* @var $coupons Coupon[] */

$this->pageTitle   = Yii::t('ShopModule.catalog', 'Корзина');
$this->breadcrumbs = array('Корзина');
?>


<div class="row-fluid">
    <div class="span12">
        <?php if (Yii::app()->shoppingCart->isEmpty()): ?>
            <h1>Корзина пуста</h1>
            В корзине нет товаров
        <?php else: ?>
            <?php
            $form = $this->beginWidget(
                'CActiveForm', array(
                    'action' => array('/shop/order/create'),
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
                    <th>Продукт</th>
                    <th>Количество</th>
                    <th class="text-center">Цена</th>
                    <th class="text-center">Сумма</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($positions as $position): ?>
                    <tr>
                        <td class="span5">
                            <?php $positionId = $position->getId(); ?>
                            <?php echo CHtml::hiddenField('OrderProduct[' . $positionId . '][product_id]', $position->id); ?>
                            <input type="hidden" class="position-id" value="<?php echo $positionId; ?>"/>

                            <div class="media">
                                <?php $productUrl = Yii::app()->createUrl('shop/catalog/show', array('name' => $position->alias)); ?>
                                <a class="thumbnail pull-left" href="<?php echo $productUrl; ?>">
                                    <img class="media-object" src="<?php echo $position->mainImage ? $position->mainImage->getImageUrl(72, 72) : ''; ?>" style="width: 72px; height: 72px;">
                                </a>

                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="<?php echo $productUrl; ?>"><?php echo $position->name; ?></a>
                                    </h4>
                                    <?php foreach ($position->selectedVariants as $variant): ?>
                                        <h6><?php echo $variant->attribute->title; ?>: <?php echo $variant->getOptionValue(); ?></h6>
                                        <?php echo CHtml::hiddenField('OrderProduct[' . $positionId . '][variant_ids][]', $variant->id); ?>
                                    <?php endforeach; ?>
                                    <span>Статус: </span><span class="text-<?php echo $position->in_stock ? "success" : "warning"; ?>"><strong><?php echo $position->in_stock ? "В наличии" : "Нет в наличии"; ?></strong></span>
                                </div>
                            </div>
                        </td>
                        <td class="span2">

                            <div class="input-prepend input-append">
                                <button class="btn btn-default cart-quantity-decrease" type="button" data-target="#cart_<?php echo $positionId; ?>">-</button>
                                <?php echo CHtml::textField('OrderProduct[' . $positionId . '][quantity]', $position->getQuantity(), array('id' => 'cart_' . $positionId, 'class' => 'span5 text-center position-count')); ?>
                                <button class="btn btn-default cart-quantity-increase" type="button" data-target="#cart_<?php echo $positionId; ?>">+</button>
                            </div>
                        </td>
                        <td class="span2 text-center"><strong><span class="position-price"><?php echo $position->getPrice(); ?></span> руб.</strong></td>
                        <td class="span2 text-center"><strong><span class="position-sum-price"><?php echo $position->getSumPrice(); ?></span> руб.</strong></td>
                        <td class="span1">
                            <button type="button" class="btn btn-danger cart-delete-product" data-position-id="<?php echo $positionId; ?>">
                                <span class="icon-remove"></span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td>  </td>
                    <td colspan="2"><h5>Промежуточный итог</h5></td>
                    <td colspan="2" style="text-align: right;">
                        <h4><strong id="cart-full-cost"><?php echo Yii::app()->shoppingCart->getCost(); ?></strong> руб.</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="coupons">
                        <p>
                            <b>Купоны</b>
                        </p>

                        <div class="input-append span6">
                            <input class="span8" id="coupon-code" type="text">
                            <button class="btn" type="button" id="add-coupon-code">Добавить купон</button>
                        </div>
                        <?php foreach ($coupons as $coupon): ?>
                            <span class="label alert alert-info coupon" title="<?php echo $coupon->name; ?>">
                                <?php echo $coupon->code; ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php echo CHtml::hiddenField("Order[couponCodes][{$coupon->code}]", $coupon->code, array(
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
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="radios"><b>Способ доставки</b></label>

                                <div class="controls">
                                    <?php $deliveryTypes = Delivery::model()->published()->findAll(); ?>
                                    <?php foreach ($deliveryTypes as $key => $delivery): ?>
                                        <label class="radio" for="delivery-<?php echo $delivery->id; ?>">
                                            <input type="radio" name="Order[delivery_id]" id="delivery-<?php echo $delivery->id; ?>"
                                                   value="<?php echo $delivery->id; ?>"
                                                   data-price="<?php echo $delivery->price; ?>"
                                                   data-free-from="<?php echo $delivery->free_from; ?>"
                                                   data-available-from="<?php echo $delivery->available_from; ?>"
                                                   data-separate-payment="<?php echo $delivery->separate_payment; ?>">
                                            <?php echo $delivery->name; ?> - <?php echo $delivery->price; ?> руб. (доступно от <?php echo $delivery->available_from; ?> руб.; бесплатно от <?php echo $delivery->free_from; ?> руб.; )
                                            <?php echo($delivery->separate_payment ? "Оплачивается отдельно" : ""); ?>
                                        </label>
                                        <div class="muted">
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
                    <td colspan="2"><h5>Стоимость доставки</h5></td>
                    <td colspan="2" style="text-align: right;">
                        <h4><strong id="cart-shipping-cost">0</strong> руб.</h4>
                    </td>
                </tr>
                <tr>
                    <td>  </td>
                    <td colspan="2"><h4>Всего</h4></td>
                    <td colspan="2" style="text-align: right;">
                        <h4><strong id="cart-full-cost-with-shipping">0</strong> руб.</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table class="table-condensed order-receiver">
                            <thead>
                            <tr>
                                <th>
                                    Адрес получателя
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
                                        <?php echo $form->textField($order, 'name', array('class' => 'span12', 'size' => 60, 'maxlength' => 250)); ?>
                                        <?php echo $form->error($order, 'name'); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <?php echo $form->labelEx($order, 'phone'); ?>
                                        <?php echo $form->textField($order, 'phone', array('class' => 'span12', 'size' => 60, 'maxlength' => 250)); ?>
                                        <?php echo $form->error($order, 'phone'); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <?php echo $form->labelEx($order, 'email'); ?>
                                        <?php echo $form->emailField($order, 'email', array('class' => 'span12', 'size' => 60, 'maxlength' => 250)); ?>
                                        <?php echo $form->error($order, 'email'); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <?php echo $form->labelEx($order, 'address'); ?>
                                        <?php echo $form->textField($order, 'address', array('class' => 'span12', 'size' => 60, 'maxlength' => 250)); ?>
                                        <?php echo $form->error($order, 'address'); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $form->labelEx($order, 'comment'); ?>
                                    <?php echo $form->textArea($order, 'comment', array('class' => 'span12', 'rows' => 2, 'maxlength' => 1024)); ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>

                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;">
                        <a href="<?php echo Yii::app()->createUrl('shop/catalog/index'); ?>" class="btn btn-default">
                            <span class="icon-shopping-cart"></span> Вернуться к каталогу
                        </a>
                        <button type="submit" class="btn btn-success">
                            Создать заказ и перейти к оплате <span class="icon-play"></span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
            <?php $this->endWidget(); ?>
        <?php endif; ?>
    </div>
</div>