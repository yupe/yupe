<?php
/* @var $this CartController */
/* @var $positions Product[] */
/* @var $order Order */
/* @var $coupons Coupon[] */
/* @var $form CActiveForm */

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();

Yii::app()->getClientScript()->registerScriptFile($mainAssets.'/js/store.js');

$this->title = Yii::t('CartModule.cart', 'Cart');
$this->breadcrumbs = [
    Yii::t("CartModule.cart", 'Catalog') => ['/store/product/index'],
    Yii::t("CartModule.cart", 'Cart'),
];
?>

<?php if (Yii::app()->cart->isEmpty()): ?>
    <div class="main__title grid">
        <h1 class="h2"><?= Yii::t("CartModule.cart", "Cart is empty"); ?></h1>
        <?= Yii::t("CartModule.cart", "There are no products in cart"); ?>
    </div>
<?php else: ?>
    <div class="main__title grid">
        <h1 class="h2"><?= Yii::t("CartModule.cart", 'Cart') ?></h1>
    </div>
    <?php
    $form = $this->beginWidget(
        'CActiveForm',
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
            ],
        ]
    ); ?>

    <div class="main__cart-box grid">
        <div class="order-box js-cart">
            <div class="order-box__header order-box__header_black">
                <div class="cart-list-header">
                    <div class="cart-list__column cart-list__column_info"><?= Yii::t(
                            "CartModule.cart",
                            "Product"
                        ); ?></div>
                    <div class="cart-list__column"><?= Yii::t("CartModule.cart", "Price"); ?></div>
                    <div class="cart-list__column"><?= Yii::t("CartModule.cart", "Amount"); ?></div>
                    <div class="cart-list__column"><?= Yii::t("CartModule.cart", "Sum"); ?></div>
                </div>
            </div>
            <div class="cart-list">
                <?php foreach ($positions as $position): ?>
                    <div class="cart-list__item">
                        <?php $positionId = $position->getId(); ?>
                        <?php $productUrl = Yii::app()->createUrl(
                            '/store/product/view',
                            ['name' => $position->slug]
                        ); ?>
                        <?= CHtml::hiddenField('OrderProduct['.$positionId.'][product_id]', $position->id); ?>
                        <input type="hidden" class="position-id" value="<?= $positionId; ?>"/>

                        <div class="cart-item js-cart__item">
                            <div class="cart-item__info">
                                <div class="cart-item__thumbnail">
                                    <img src="<?= $position->getProductModel()->getImageUrl(90, 90, false); ?>"
                                         class="cart-item__img"/>
                                </div>
                                <div class="cart-item__content grid-module-4">
                                    <?php if ($position->getProductModel()->getCategoryId()): ?>
                                        <div class="cart-item__category"><?= $position->getProductModel(
                                            )->category->name ?></div>
                                    <?php endif; ?>
                                    <div class="cart-item__title">
                                        <a href="<?= $productUrl; ?>" class="cart-item__link"><?= CHtml::encode(
                                                $position->name
                                            ); ?></a>
                                    </div>
                                    <?php foreach ($position->selectedVariants as $variant): ?>
                                        <h6><?= $variant->attribute->title; ?>: <?= $variant->getOptionValue(); ?></h6>
                                        <?= CHtml::hiddenField('OrderProduct[' . $positionId . '][variant_ids][]', $variant->id); ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="cart-item__price">
                                <span class="position-price"><?= $position->getPrice(); ?></span>
                                <span class="ruble"> <?= Yii::t("CartModule.cart", Yii::app()->getModule('store')->currency); ?></span>
                            </div>
                            <div class="cart-item__quantity">
                                <span data-min-value='1' data-max-value='99' class="spinput js-spinput">
                                    <span class="spinput__minus js-spinput__minus cart-quantity-decrease"
                                          data-target="#cart_<?= $positionId; ?>"></span>
                                    <?= CHtml::textField(
                                        'OrderProduct['.$positionId.'][quantity]',
                                        $position->getQuantity(),
                                        ['id' => 'cart_'.$positionId, 'class' => 'spinput__value position-count']
                                    ); ?>
                                    <span class="spinput__plus js-spinput__plus cart-quantity-increase"
                                          data-target="#cart_<?= $positionId; ?>"></span>
                                </span>
                            </div>
                            <div class="cart-item__summ">
                                <span class="position-sum-price"><?= $position->getSumPrice(); ?></span>
                                <span class="ruble"> <?= Yii::t("CartModule.cart", Yii::app()->getModule('store')->currency); ?></span>

                                <div class="cart-item__action">
                                    <a class="js-cart__delete cart-delete-product"
                                       data-position-id="<?= $positionId; ?>">
                                        <i class="fa fa-fw fa-trash-o"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (Yii::app()->hasModule('coupon')): ?>
                <div class="order-box__coupon">
                    <div class="coupon-box">
                        <span class="coupon-box__label">
                            <?= Yii::t("CartModule.cart", "Coupons"); ?>
                        </span>
                        <input id="coupon-code" class="input coupon-box__input">
                        <button class="btn btn_primary coupon-box__button" type="button"
                                id="add-coupon-code"><?= Yii::t("CartModule.cart", "Add coupon"); ?></button>
                        <div class="row fast-order__inputs">
                            <?php foreach ($coupons as $coupon): ?>
                                <div class="coupon">
                                    <span class="label" title="<?= $coupon->name; ?>">
                                        <?= $coupon->name; ?>
                                        <button type="button" class="btn btn_primary close"
                                                data-dismiss="alert">&times;</button>
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
                                        ); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($deliveryTypes)): ?>
                <div class="order-box">
                    <div class="order-box__header order-box__header_normal"><?= Yii::t(
                            "CartModule.cart",
                            "Delivery method"
                        ); ?></div>
                    <div class="order-box__body">
                        <div class="order-box-delivery">
                            <div class="order-box-delivery__type">
                                <?php foreach ($deliveryTypes as $key => $delivery): ?>
                                    <div class="rich-radio">
                                        <input type="radio" name="Order[delivery_id]"
                                               id="delivery-<?= $delivery->id; ?>"
                                               class="rich-radio__input"
                                               hidden="hidden"
                                               value="<?= $delivery->id; ?>"
                                               data-price="<?= $delivery->price; ?>"
                                               data-free-from="<?= $delivery->free_from; ?>"
                                               data-available-from="<?= $delivery->available_from; ?>"
                                               data-separate-payment="<?= $delivery->separate_payment; ?>">
                                        <label for="delivery-<?= $delivery->id; ?>" class="rich-radio__label">
                                            <div class="rich-radio-body">
                                                <div class="rich-radio-body__content">
                                                    <div class="rich-radio-body__heading">
                                                        <span class="rich-radio-body__title">
                                                            <?= $delivery->name; ?>
                                                            - <?= $delivery->price; ?> <?= Yii::t(
                                                                "CartModule.cart",
                                                                "RUB"
                                                            ); ?>
                                                        </span>
                                                    </div>
                                                    <div
                                                        class="rich-radio-body__text"><?= $delivery->description; ?></div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="order-box-delivery__address">
                                <h3 class="h3"><?= Yii::t("CartModule.cart", "Address"); ?></h3>

                                <div class="order-form">
                                    <div class="order-form__row">
                                        <div class="order-form__item">
                                            <div class="form-group">
                                                <?= $form->labelEx($order, 'name', ['class' => 'form-group__label']); ?>
                                                <div class="form-group__input">
                                                    <?= $form->textField($order, 'name', ['class' => 'input']); ?>
                                                </div>
                                                <div class="form-group__help">
                                                    <?= $form->error($order, 'name'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-form__row">
                                        <div class="order-form__item">
                                            <div class="form-group">
                                                <?= $form->labelEx(
                                                    $order,
                                                    'email',
                                                    ['class' => 'form-group__label']
                                                ); ?>
                                                <div class="form-group__input">
                                                    <?= $form->textField($order, 'email', ['class' => 'input']); ?>
                                                </div>
                                                <div class="form-group__help">
                                                    <?= $form->error($order, 'email'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-form__row">
                                        <div class="order-form__item">
                                            <div class="form-group">
                                                <?= $form->labelEx(
                                                    $order,
                                                    'phone',
                                                    ['class' => 'form-group__label']
                                                ); ?>
                                                <div class="form-group__input">
                                                    <?= $form->textField($order, 'phone', ['class' => 'input']); ?>
                                                </div>
                                                <div class="form-group__help">
                                                    <?= $form->error($order, 'phone'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-form__row">
                                        <div class="order-form__item">
                                            <div class="form-group">
                                                <?= $form->labelEx($order, 'zipcode', ['class' => 'form-group__label']); ?>
                                                <div class="form-group__input">
                                                    <?= $form->textField($order, 'zipcode', ['class' => 'input']); ?>
                                                </div>
                                                <div class="form-group__help">
                                                    <?= $form->error($order, 'zipcode'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-form__row">
                                        <div class="order-form__item">
                                            <div class="form-group">
                                                <?= $form->labelEx($order, 'country', ['class' => 'form-group__label']); ?>
                                                <div class="form-group__input">
                                                    <?= $form->textField($order, 'country', ['class' => 'input']); ?>
                                                </div>
                                                <div class="form-group__help">
                                                    <?= $form->error($order, 'country'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-form__row">
                                        <div class="order-form__item">
                                            <div class="form-group">
                                                <?= $form->labelEx($order, 'city', ['class' => 'form-group__label']); ?>
                                                <div class="form-group__input">
                                                    <?= $form->textField($order, 'city', ['class' => 'input']); ?>
                                                </div>
                                                <div class="form-group__help">
                                                    <?= $form->error($order, 'city'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-form__row">
                                        <div class="order-form__item">
                                            <div class="form-group">
                                                <?= $form->labelEx($order, 'street', ['class' => 'form-group__label']); ?>
                                                <div class="form-group__input">
                                                    <?= $form->textField($order, 'street', ['class' => 'input']); ?>
                                                </div>
                                                <div class="form-group__help">
                                                    <?= $form->error($order, 'street'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-form__row">
                                        <div class="order-form__item">
                                            <div class="form-group">
                                                <?= $form->labelEx($order, 'house', ['class' => 'form-group__label']); ?>
                                                <div class="form-group__input">
                                                    <?= $form->textField($order, 'house', ['class' => 'input']); ?>
                                                </div>
                                                <div class="form-group__help">
                                                    <?= $form->error($order, 'house'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-form__row">
                                        <div class="order-form__item">
                                            <div class="form-group">
                                                <?= $form->labelEx($order, 'apartment', ['class' => 'form-group__label']); ?>
                                                <div class="form-group__input">
                                                    <?= $form->textField($order, 'apartment', ['class' => 'input']); ?>
                                                </div>
                                                <div class="form-group__help">
                                                    <?= $form->error($order, 'apartment'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-form__row">
                                        <div class="order-form__item">
                                            <div class="form-group">
                                                <?= $form->labelEx(
                                                    $order,
                                                    'comment',
                                                    ['class' => 'form-group__label']
                                                ); ?>
                                                <div class="form-group__input">
                                                    <?= $form->textArea($order, 'comment', ['class' => 'input']); ?>
                                                </div>
                                                <div class="form-group__help">
                                                    <?= $form->error($order, 'comment'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    <?= Yii::t("CartModule.cart", "Delivery method aren't selected! The ordering is impossible!") ?>
                </div>
            <?php endif; ?>

            <div class="order-box__bottom">
                <div class="cart-box__subtotal">
                    Итого: &nbsp;<span id="cart-total-product-count"><?= Yii::app()->cart->getCount(); ?></span>&nbsp;
                    товар(а)
                    на сумму &nbsp;<span id="cart-full-cost-with-shipping">0</span><span class="ruble"> <?= Yii::t(
                            "CartModule.cart",
                            "RUB"
                        ); ?></span>
                </div>
                <div class="cart-box__order-button">
                    <button type="submit" class="btn btn_big btn_primary"><?= Yii::t(
                            "CartModule.cart",
                            "Create order and proceed to payment"
                        ); ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
<?php endif; ?>