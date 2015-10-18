<?php
/**
 * @var Product $product
 */
$productUrl = Yii::app()->createUrl('/store/product/view', ['name' => CHtml::encode($product->slug)]);
?>
<div class="col-sm-1"></div>
<div class="col-sm-10">
    <div class="photo">
        <a href="<?= $productUrl; ?>">
            <img src="<?= $product->getImageUrl(190, 190, false); ?>"/>
        </a>
    </div>
    <div class="info separator">
        <div class="row">
            <div class="price col-sm-12">
                <h5>
                    <a href="<?= $productUrl; ?>"><?= CHtml::encode($product->getName()); ?></a>
                </h5>
                <h5 class="price-text-color">
                    <?= $product->getResultPrice(); ?> <i class="fa fa-rub"></i>
                </h5>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-sm-1"></div>