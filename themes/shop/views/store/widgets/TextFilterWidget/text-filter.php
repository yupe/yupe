<?php $filter = Yii::app()->getComponent('attributesFilter');?>
<div class="filter-block">
    <div class="filter-block__title">
        <div class="filter-block__list-item">
            <?= $attribute->title ?>
            <?= CHtml::textField($filter->getFieldName($attribute), $filter->getFieldValue($attribute), ['class' => 'form-control']) ?>
        </div>
    </div>
</div>