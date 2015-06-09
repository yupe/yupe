<?php $filter = Yii::app()->getComponent('attributesFilter');?>
<div class="filter-block-checkbox-list">
    <div class="filter-block-header">
        <strong><?= $attribute->title ?></strong>
    </div>
    <div class="filter-block-body">
        <div class="row">
            <div class="col-xs-6">
                <?= CHtml::textField($filter->getNumberName($attribute, 'from'), $filter->getNumberValue($attribute, 'from'), ['class' => 'form-control']) ?>
            </div>
            <div class="col-xs-6">
                <?= CHtml::textField($filter->getNumberName($attribute, 'to'), $filter->getNumberValue($attribute, 'to'), ['class' => 'form-control']) ?>
            </div>
        </div>
    </div>
</div>
<hr/>
