<?php
/**
 * @var Producer $data
 */
$brandUrl = Yii::app()->createUrl('/store/producer/view', ['slug' => $data->slug])
?>
<div class="category-item">
    <a href="<?= $brandUrl; ?>">
        <img src="<?= $data->getImageUrl(250, 250, false); ?>"/>
    </a>
    <div class="text-center">
        <a href="<?= $brandUrl; ?>" class="category-item-title"><?= CHtml::encode($data->name); ?></a>
    </div>
</div>
