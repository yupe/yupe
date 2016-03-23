<?php
/**
 * @var Product $product
 */
?>
<div class="col-sm-1"></div>
<div class="col-sm-10">
    <div class="photo">
        <a href="<?= ProductHelper::getUrl($data); ?>">
            <img src="<?= $product->getImageUrl(190, 190, false); ?>"/>
        </a>
    </div>
    <div class="info separator">
        <div class="row">
            <div class="price col-sm-12">
                <h5>
                    <a href="<?= ProductHelper::getUrl($data); ?>"><?= CHtml::encode($product->getName()); ?></a>
                </h5>
                <h5 class="price-text-color">
                    <?= $product->getResultPrice(); ?> <?= Yii::t("StoreModule.store", Yii::app()->getModule('store')->currency); ?>
                </h5>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-sm-1"></div>