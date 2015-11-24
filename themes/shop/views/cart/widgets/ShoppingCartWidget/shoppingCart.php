<div class="header__item header-cart js-cart" id="cart-widget" data-cart-widget-url="<?= Yii::app()->createUrl('/cart/cart/widget');?>">
    <div class="header-cart__icon">
        <div class="badge badge_light-blue"><?= CHtml::link(Yii::app()->cart->getCount(), ['/cart/cart/index']);?></div>
    </div>
    <div class="header-cart__text-wrap">
        <div class="header-cart__label"><?= CHtml::link(Yii::t('CartModule.cart', 'Cart'), ['/cart/cart/index']);?>
            <a href="javascript:void(0);" data-toggle="#cart-mini" class="header-cart__cart-toggle" id="cart-toggle-link"></a>
            <div class="cart-mini" id="cart-mini">
                <?php if (Yii::app()->cart->isEmpty()): ?>
                    <p><?= Yii::t("CartModule.cart", "There are no products in cart"); ?></p>
                <?php else: ?>
                    <?php foreach (Yii::app()->cart->getPositions() as $product): ?>
                        <?php
                        $basePrice = (float)$product->getBasePrice();
                        $price = $product->getResultPrice();
                        ?>
                        <div class="cart-mini__item js-cart__item">
                            <div class="cart-mini__thumbnail">
                                <img src="<?= $product->getImageUrl(60, 60, false); ?>" class="cart-mini__img" />
                            </div>
                            <div class="cart-mini__info">
                                <div class="cart-mini__title">
                                    <?= CHtml::link($product->title, ['/store/product/view', 'name' => $product->slug], ['class' => 'cart-mini__link']) ?>
                                </div>
                                <div class="product-price"><?= $price ?><span class="ruble"> <?= Yii::t("CartModule.cart", "RUB"); ?></span></div>
                                <?php if ($basePrice != $price): ?>
                                    <div class="product-price product-price_old"><?= $basePrice ?><span class="ruble"> <?= Yii::t("CartModule.cart", "RUB"); ?></span></div>
                                <?php endif; ?>
                            </div>
                            <div class="cart-mini__delete-btn js-cart__delete mini-cart-delete-product" data-position-id="<?= $product->getId(); ?>"><i class="fa fa-trash-o"></i></div>
                        </div>
                    <?php endforeach; ?>
                    <div class="cart-mini__bottom">
                        <a href="<?= Yii::app()->createUrl('cart/cart/index'); ?>" class="btn btn_success">Оформить заказ</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="header-cart__cost">
            <div class="header-cart__cost-title"><?= Yii::t("CartModule.cart", "Sum"); ?>:</div>
            <div class="header-cart__cost-price">
                <span class="js-cart__subtotal"><?= Yii::app()->cart->getCost(); ?></span>
                <span class="ruble"> <?= Yii::t("CartModule.cart", "RUB"); ?></span>
            </div>
        </div>
    </div>
</div>