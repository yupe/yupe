<?php $filter = Yii::app()->getComponent('attributesFilter');?>
<div class="filter-block-checkbox-list">
    <div class="filter-block-header">
        <strong><?= $attribute->title ?></strong>
    </div>
    <div class="filter-block-body">
        <div class="row">
            <div class="col-xs-6">
                <?= CHtml::textField($filter->getFieldName($attribute, 'from'), $filter->getFieldValue($attribute, 'from'), ['class' => 'form-control', 'placeholder' => Yii::t('StoreModule.store', 'from')]) ?>
            </div>
            <div class="col-xs-6">
                <?= CHtml::textField($filter->getFieldName($attribute, 'to'), $filter->getFieldValue($attribute, 'to'), ['class' => 'form-control', 'placeholder' => Yii::t('StoreModule.store', 'to')]) ?>
            </div>
        </div>
    </div>
</div>
<hr/>
