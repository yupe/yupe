<?php $filter = Yii::app()->getComponent('attributesFilter');?>
<div class="filter-block-checkbox-list">
    <div class="filter-block-header">
        <strong><?= $attribute->title ?></strong>
    </div>
    <div class="filter-block-body">
        <?php foreach ($attribute->options as $option): ?>
            <div class="checkbox">
                <label>
                    <?= CHtml::checkBox($filter->getDropdownOptionName($option), $filter->getIsDropdownOptionChecked($option, $option->id), ['value' => $option->id]) ?>
                    <?= $option->value ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<hr/>
