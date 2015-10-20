<?php
/**
 * @var Product $product
 */
$productUrl = Yii::app()->createUrl('/store/product/view', ['name' => CHtml::encode($product->slug)]);
$basePrice = (float)$product->getBasePrice();
$price = $product->getResultPrice();
?>
<div class="h-slider__slide js-overlay-item">
    <div class="grid-module-3">
        <article class="product-vertical">
            <a href="<?= $productUrl; ?>">
                <div class="product-vertical__thumbnail">
                    <img src="<?= $product->getImageUrl(150, 280, false); ?>" class="product-vertical__img" />
                </div>
            </a>
            <div class="product-vertical__content"><a href="<?= $productUrl; ?>" class="product-vertical__title"><?= CHtml::encode($product->getName()); ?></a>
                <div class="product-vertical__price">
                    <div class="product-price"><?= $price ?><span class="ruble"> <?= Yii::t("StoreModule.store", "RUB"); ?></span></div>
                    <?php if ($basePrice != $price): ?>
                        <div class="product-price product-price_old"><?= $basePrice ?><span class="ruble"> <?= Yii::t("StoreModule.store", "RUB"); ?></span></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="product-vertical__extra">
                <div class="product-vertical-extra">
                    <div class="product-vertical-extra__top">
                        <div class="product-vertical-extra__rating">
                            <div data-rate='5' class="rating">
                                <div class="rating__label">4.5</div>
                                <div class="rating__corner">
                                    <div class="rating__triangle"></div>
                                </div>
                            </div>
                        </div>
                        <div class="product-vertical-extra__reviews">
                            <a href="javascript:void(0);" class="reviews-link">6 отзывов</a>
                        </div>
                        <div class="product-vertical-extra__stock">
                            <?php if($product->isInStock()):?>
                                <div class="in-stock"><?= Yii::t("StoreModule.store", "In stock");?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="product-vertical-extra__toolbar">
                        <div class="product-vertical-extra__button"><i class="fa fa-heart-o"></i></div>
                        <div class="product-vertical-extra__button"><i class="fa fa-balance-scale"></i></div>
                        <?php if (Yii::app()->hasModule('cart')): ?>
                            <div class="product-vertical-extra__cart">
                                <a href="#" class="btn btn-add btn_cart hidden-sm quick-add-product-to-cart" data-product-id="<?= $product->id; ?>" data-cart-add-url="<?= Yii::app()->createUrl('/cart/cart/add');?>">
                                    <?= Yii::t('StoreModule.store', 'Into cart') ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>
