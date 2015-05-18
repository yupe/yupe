<?php
/* @var $attribute Attribute */
$filter = new AttributeFilter();
?>
<div class="filter-block-checkbox-list">
    <div class="filter-block-header">
        <?= $attribute->title ?>
    </div>
    <div class="filter-block-body">
        <div class="radio">
            <label>
                <?= CHtml::radioButton($filter->getCheckboxName($attribute), $filter->getIsCheckboxChecked($attribute, 1), ['value' => 1]) ?>
                Да
            </label>
        </div>
        <div class="radio">
            <label>
                <?= CHtml::radioButton($filter->getCheckboxName($attribute), $filter->getIsCheckboxChecked($attribute, 0), ['value' => 0]) ?>
                Нет
            </label>
        </div>
        <div class="radio">
            <label>
                <?= CHtml::radioButton($filter->getCheckboxName($attribute), $filter->getIsCheckboxChecked($attribute, -1), ['value' => -1]) ?>
                Неважно
            </label>
        </div>
    </div>
</div>
