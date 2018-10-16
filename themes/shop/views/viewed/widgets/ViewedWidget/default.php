<?php
/**
 * @var array $products
 * @var Product $product
 */
?>
<div class="main__recently-viewed-slider">
    <div class="grid">
        <div class="h3"><?= Yii::t('ViewedModule.viewed', 'You have already seen'); ?></div>
        <div data-show="3" data-scroll="3" data-infinite="data-infinite" class="h-slider js-slick">
            <div class="h-slider__buttons h-slider__buttons_noclip">
                <div class="btn h-slider__control h-slider__next js-slick__next"></div>
                <div class="btn h-slider__control h-slider__prev js-slick__prev"></div>
            </div>
            <div class="h-slider__slides js-slick__container">
                <?php foreach ($products as $product): ?>
                    <div class="h-slider__slide">
                        <div class="grid-module-4">
                            <div class="product-mini">
                                <div class="product-mini__thumbnail">
                                    <a href="<?= ProductHelper::getUrl($product); ?>">
                                        <img src="<?= StoreImage::product($product, 92, 92, false) ?>"
                                             class="product-mini__img"
                                             alt="<?= CHtml::encode($product->getImageAlt()); ?>"
                                             title="<?= CHtml::encode($product->getImageTitle()); ?>"
                                            >
                                    </a>
                                </div>
                                <div class="product-mini__info">
                                    <div class="product-mini__title">
                                        <a href="<?= ProductHelper::getUrl($product); ?>" class="product-mini__link">
                                            <?= CHtml::encode($product->getName()); ?>
                                        </a>
                                    </div>
                                    <div class="product-mini__price">
                                        <div class="product-price">
                                            <?= $product->getResultPrice() ?>
                                            <span class="ruble"> <?= Yii::t('StoreModule.store', Yii::app()->getModule('store')->currency); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
