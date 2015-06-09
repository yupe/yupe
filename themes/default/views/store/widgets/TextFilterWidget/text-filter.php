<?php
/* @var $attribute Attribute */
$filter = new AttributeFilter();
?>
<div class="filter-block-checkbox-list">
    <div class="filter-block-header">
        <strong><?= $attribute->title ?></strong>
    </div>
    <div class="filter-block-body">
        <div class="row">
            <div class="col-xs-12">
                <?= CHtml::textField($filter->getNumberName($attribute, 'from'), $filter->getNumberValue($attribute, 'from'), ['class' => 'form-control']) ?>
            </div>
        </div>
    </div>
</div>
<hr/>
