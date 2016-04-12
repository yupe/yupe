<?php
/* @var $data News */
$url = Yii::app()->createUrl('/news/news/view', ['slug' => $data->slug]);
?>
<div class="fast-order__inputs">
    <h4 class="h3"><?= CHtml::link(CHtml::encode($data->title), $url, ['class' => 'cart-item__link']); ?></h4>
    <p> <?= $data->short_text; ?></p>
    <p class="pull-right">
        <?= CHtml::link(Yii::t('NewsModule.news', 'read...'), $url, ['class' => 'btn btn_primary']); ?>
    </p>
</div>