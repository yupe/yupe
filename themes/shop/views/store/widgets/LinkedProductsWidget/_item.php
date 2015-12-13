<?php $productUrl = Yii::app()->createUrl('/store/product/view', ['name' => CHtml::encode($data->slug)]); ?>

<div class="h-slider__slide">
    <div class="grid-module-4">
        <div class="product-mini">
            <div class="product-mini__thumbnail">
                <a href="javascript:void(0);">
                    <img src="<?= $data->getImageUrl(90, 90, false); ?>"
                         class=" product-mini__img">
                </a>
            </div>
            <div class="product-mini__info">
                <div class="product-mini__title"><a href="<?= $productUrl; ?>"
                                                    class="product-mini__link"><?= Chtml::encode($data->getName()); ?></a>
                </div>
                <div class="product-mini__price">
                    <div class="product-price"><?= $data->getResultPrice(); ?><span class="ruble"> <?= Yii::app()->getModule('store')->currency;?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>