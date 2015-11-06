<?php
/**
 * @var Producer $data
 */
$brandUrl = Yii::app()->createUrl('/store/producer/view', ['slug' => $data->slug])
?>

<div class="catalog__item">
<div class="product-mini">
    <div class="product-mini__thumbnail">
        <a href="<?= $brandUrl ?>">
            <img src="<?= $data->getImageUrl(120, 120, false); ?>" class="product-mini__img" />
        </a>
    </div>
    <div class="product-mini__info">
        <div class="product-mini__title">
            <a href="<?= $brandUrl ?>" class="product-mini__link"><?= CHtml::encode($data->name); ?></a>
        </div>
    </div>
</div>
</div>