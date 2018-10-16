<?php $filter = Yii::app()->getComponent('attributesFilter'); ?>
<div class="filter-block-checkbox-list">
    <div class="filter-block-header">
        <strong><?= $attribute->title ?></strong>
    </div>
    <div class="filter-block-body">
        <div class="checkbox">
            <?= CHtml::checkBox(
                $filter->getFieldName($attribute),
                $filter->isFieldChecked($attribute, 1),
                ['value' => 1]
            ) ?>
            <?= CHtml::label('да/нет', $filter->getFieldName($attribute)); ?>
        </div>
    </div>
</div>
<hr/>
