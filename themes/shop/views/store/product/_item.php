<?php
$productUrl = Yii::app()->createUrl('/store/product/view', ['name' => CHtml::encode($data->slug)]);
$basePrice = (float)$data->getBasePrice();
$price = $data->getResultPrice();
?>
<div class="catalog__item">
    <article class="product-vertical">
        <a href="<?= $productUrl; ?>">
            <div class="product-vertical__thumbnail">
                <img src="<?= $data->getImageUrl(150, 280, false); ?>" class="product-vertical__img" />
            </div>
        </a>
        <div class="product-vertical__content"><a href="<?= $productUrl; ?>" class="product-vertical__title"><?= CHtml::encode($data->getName()); ?></a>
            <div class="product-vertical__price">
                <div class="product-price"><?= $price ?><span class="ruble"> руб.</span></div>
                <?php if ($basePrice != $price): ?>
                    <div class="product-price product-price_old"><?= $basePrice ?><span class="ruble"> руб.</span></div>
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
                    <div class="product-vertical-extra__reviews"><a href="javascript:void(0);" class="reviews-link">6 отзывов</a></div>
                    <?php if($data->isInStock()):?>
                        <div class="product-vertical-extra__stock">
                            <div class="in-stock">В наличии</div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="product-vertical-extra__toolbar">
                    <div class="product-vertical-extra__button"><i class="fa fa-heart-o"></i></div>
                    <div class="product-vertical-extra__button"><i class="fa fa-balance-scale"></i></div>
                    <div class="product-vertical-extra__cart">
                        <?php if (Yii::app()->hasModule('cart')): ?>
                            <a href="javascript:void(0);" class="btn btn_cart quick-add-product-to-cart" data-product-id="<?= $data->id; ?>" data-cart-add-url="<?= Yii::app()->createUrl('/cart/cart/add');?>">
                                <?= Yii::t('StoreModule.store', 'Into cart') ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
