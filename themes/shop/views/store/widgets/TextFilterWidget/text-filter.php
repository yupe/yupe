<?php $filter = Yii::app()->getComponent('attributesFilter');?>
<div class="filter-block">
    <div class="filter-block__title">
        <?= $attribute->title ?>
        <div class="filter-block__range">
            <span class="filter-input__box">
            <?= CHtml::textField($filter->getFieldName($attribute), $filter->getFieldValue($attribute), ['class' => 'filter-input__control']) ?>
                </span>
        </div>
    </div>
</div>