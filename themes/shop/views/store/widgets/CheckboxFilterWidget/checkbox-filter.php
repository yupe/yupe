<?php $filter = Yii::app()->getComponent('attributesFilter'); ?>
<div class="filter-block">
    <div class="filter-block__title">
        <div class="filter-block__list-item">
            <?= CHtml::checkBox(
                $filter->getFieldName($attribute),
                $filter->isFieldChecked($attribute, 1),
                ['value' => 1, 'class' => 'checkbox']
            ) ?>
            <?= CHtml::label($attribute->title, $filter->getFieldName($attribute), ['class' => 'checkbox__label']); ?>
        </div>
    </div>
</div>