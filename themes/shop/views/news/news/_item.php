<?php
/* @var $data News */
?>
<div class="fast-order__inputs">
    <h4 class="h3"><?= CHtml::link(CHtml::encode($data->title), $data->getUrl(), ['class' => 'cart-item__link']); ?></h4>
    <p> <?= $data->short_text; ?></p>
    <p class="pull-right">
        <?= CHtml::link(Yii::t('NewsModule.news', 'read...'), $data->getUrl(), ['class' => 'btn btn_primary']); ?>
    </p>
</div>