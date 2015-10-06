<?php $productUrl = Yii::app()->createUrl('/store/product/view', ['name' => CHtml::encode($data->slug)]); ?>
<div class="h-slider__slide">
    <div class="product-mini">
        <div class="product-mini__thumbnail">
            <a href="<?= $productUrl; ?>">
                <img src="<?= $data->getImageUrl(90, 90, false); ?>" class="product-mini__img" />
            </a>
        </div>
        <div class="product-mini__info">
            <div class="product-mini__title"><a href="<?= $productUrl; ?>" class="product-mini__link"><?= CHtml::encode($data->getName()); ?></a>
            </div>
            <div class="product-mini__price">
                <div class="product-price"><?= $data->getResultPrice(); ?><span class="ruble"> <?= Yii::t("StoreModule.store", "RUB"); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
