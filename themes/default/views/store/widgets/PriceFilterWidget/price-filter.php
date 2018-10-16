<?php $filter = Yii::app()->getComponent('attributesFilter');?>
<div class="filter-block-checkbox-list">
    <div class="filter-block-header">
        <strong><?= Yii::t('StoreModule.store', 'Price filter'); ?></strong>
    </div>
    <div class="filter-block-body">
        <div class="row">
            <div class="col-xs-6">
                <?= CHtml::textField('price[from]', Yii::app()->attributesFilter->getMainSearchParamsValue('price', 'from', Yii::app()->getRequest()) , ['class' => 'form-control', 'placeholder' => Yii::t('StoreModule.store', 'from')]); ?>
            </div>
            <div class="col-xs-6">
                <?= CHtml::textField('price[to]', Yii::app()->attributesFilter->getMainSearchParamsValue('price', 'to', Yii::app()->getRequest()), ['class' => 'form-control', 'placeholder' => Yii::t('StoreModule.store', 'to')]); ?>
            </div>
        </div>
    </div>
</div>
<hr/>
