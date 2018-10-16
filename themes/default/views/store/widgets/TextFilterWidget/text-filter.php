<?php $filter = Yii::app()->getComponent('attributesFilter');?>
<div class="filter-block-checkbox-list">
    <div class="filter-block-header">
        <strong><?= $attribute->title ?></strong>
    </div>
    <div class="filter-block-body">
        <div class="row">
            <div class="col-xs-12">
                <?= CHtml::textField($filter->getFieldName($attribute), $filter->getFieldValue($attribute), ['class' => 'form-control']) ?>
            </div>
        </div>
    </div>
</div>
<hr/>
