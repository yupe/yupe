<?php
/* @var $this CartController */
/* @var $positions Product[] */
/* @var $order Order */
/* @var $coupons Coupon[] */

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();

Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

$this->title = Yii::t('CartModule.cart', 'Cart');
$this->breadcrumbs = [
    Yii::t("CartModule.cart", 'Catalog') => ['/store/product/index'],
    Yii::t("CartModule.cart", 'Cart')
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
    $form = $this->beginWidget('CActiveForm', [
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
    ]); ?>

    <div class="main__cart-box grid">
        <div class="order-box js-cart">
            <div class="order-box__header order-box__header_black">
                <div class="cart-list-header">
                    <div class="cart-list__column cart-list__column_info"><?= Yii::t("CartModule.cart",
                            "Product"); ?></div>
                    <div class="cart-list__column"><?= Yii::t("CartModule.cart", "Price"); ?></div>
                    <div class="cart-list__column"><?= Yii::t("CartModule.cart", "Amount"); ?></div>
                    <div class="cart-list__column"><?= Yii::t("CartModule.cart", "Sum"); ?></div>
                </div>
            </div>
            <div class="cart-list">
                <?php foreach ($positions as $position): ?>
                    <div class="cart-list__item">
                        <?php $positionId = $position->getId(); ?>
                        <?php $productUrl = Yii::app()->createUrl('/store/product/view', ['name' => $position->slug]); ?>
                        <?= CHtml::hiddenField('OrderProduct[' . $positionId . '][product_id]', $position->id); ?>
                        <input type="hidden" class="position-id" value="<?= $positionId; ?>"/>

                        <div class="cart-item js-cart__item">
                            <div class="cart-item__info">
                                <div class="cart-item__thumbnail">
                                    <img src="<?= $position->getProductModel()->getImageUrl(90, 90, false); ?>" class="cart-item__img"/>
                                </div>
                                <div class="cart-item__content">
                                    <div class="cart-item__category"><?= $position->getProductModel()->mainCategory->name ?></div>
                                    <div class="cart-item__title">
                                        <a href="<?= $productUrl; ?>" class="cart-item__link"><?= $position->name; ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-item__price">
                                <span class="position-price"><?= $position->getPrice(); ?></span>
                                <span class="ruble"> <?= Yii::t("CartModule.cart", "RUB"); ?></span>
                            </div>
                            <div class="cart-item__quantity">
                                <span data-min-value='1' data-max-value='99' class="spinput js-spinput">
                                    <span class="spinput__minus js-spinput__minus cart-quantity-decrease" data-target="#cart_<?= $positionId; ?>"></span>
                                    <?= CHtml::textField(
                                        'OrderProduct[' . $positionId . '][quantity]',
                                        $position->getQuantity(),
                                        ['id' => 'cart_' . $positionId, 'class' => 'spinput__value position-count']
                                    ); ?>
                                    <span class="spinput__plus js-spinput__plus cart-quantity-increase" data-target="#cart_<?= $positionId; ?>"></span>
                                </span>
                            </div>
                            <div class="cart-item__summ">
                                <span class="position-sum-price"><?= $position->getSumPrice(); ?></span>
                                <span class="ruble"> <?= Yii::t("CartModule.cart", "RUB"); ?></span>

                                <div class="cart-item__action">
                                    <a class="js-cart__delete cart-delete-product" data-position-id="<?= $positionId; ?>">
                                        <i class="fa fa-fw fa-trash-o"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="order-box__coupon">
                <div class="coupon-box"><span class="coupon-box__label">Купон на скидку:</span>
                    <input class="input coupon-box__input"><a href="javascript:void(0);"
                                                              class="btn btn_primary coupon-box__button">Применить</a>
                </div>
            </div>
            <div class="order-box__fast-order">
                <div class="fast-order">
                    <div class="fast-order__header">
                        <h2 class="h2">Быстрый заказ:</h2>
                    </div>
                    <div class="fast-order__inputs">
                        <div class="fast-order__column">
                            <input required placeholder="Имя" class="input input_big">
                        </div>
                        <div class="fast-order__column">
                            <input required placeholder="Email" class="input input_big">
                        </div>
                        <div class="fast-order__column">
                            <input required placeholder="Телефон" class="input input_big">
                        </div>
                    </div>
                    <div class="fast-order__bottom"><a href="javascript:void(0);"
                                                       class="btn btn_big btn_wide btn_white">Оформить быстрый заказ</a>
                    </div>
                </div>
            </div>
            <div class="order-box__bottom">
                <div class="cart-box__subtotal">
                    Итого: &nbsp;<span><?= Yii::app()->cart->getCount(); ?></span>&nbsp; товар(а)
                    на сумму &nbsp;<span id="cart-full-cost-with-shipping">0</span><span class="ruble"> <?= Yii::t("CartModule.cart", "RUB"); ?></span>
                </div>
                <div class="cart-box__order-button">
                    <button type="submit" class="btn btn_big btn_primary"><?= Yii::t("CartModule.cart", "Create order and proceed to payment"); ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
<?php endif; ?>