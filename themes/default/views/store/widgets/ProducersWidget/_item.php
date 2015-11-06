<?php
/**
 * @var Producer $brand
 */
$brandUrl = Yii::app()->createUrl('/store/producer/view', ['slug' => CHtml::encode($brand->slug)]);
?>
<div class="col-sm-1"></div>
<div class="col-sm-10">
    <div class="photo">
        <a href="<?= $brandUrl; ?>">
            <img src="<?= $brand->getImageUrl(190, 190, false); ?>"/>
        </a>
    </div>
    <div class="info separator">
        <div class="row">
            <div class="text-center col-sm-12">
                <a href="<?= $brandUrl; ?>"><?= CHtml::encode($brand->name); ?></a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-sm-1"></div>