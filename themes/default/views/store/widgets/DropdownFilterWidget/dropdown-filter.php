<?php
/* @var $attribute Attribute */
$filter = new AttributeFilter();
?>
<div class="filter-block-checkbox-list">
    <div class="filter-block-header">
        <?= $attribute->title ?>
    </div>
    <div class="filter-block-body">
        <?php foreach ($attribute->options as $option): ?>
            <div class="checkbox">
                <label>
                    <?= CHtml::checkBox($filter->getDropdownOptionName($option), $filter->getIsDropdownOptionChecked($option)) ?>
                    <?= $option->value ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
</div>
