<?php $filter = Yii::app()->getComponent('attributesFilter');?>
<div class="filter-block-checkbox-list">
    <div class="filter-block-header">
        <a href="#size-filter-collapse" data-toggle="collapse">
            <span class="fa fa-chevron-right"></span>
            <strong>По размерам</strong>
        </a>
    </div>
    <div id="size-filter-collapse" class="filter-block-body collapse">
        <div class="row">
            <div class="col-xs-12">
                <br>Длина
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <?= CHtml::textField('length[from]', Yii::app()->attributesFilter->getMainSearchParamsValue('length', 'from', Yii::app()->getRequest()) , ['class' => 'form-control', 'placeholder' => Yii::t('StoreModule.store', 'from')]); ?>
            </div>
            <div class="col-xs-6">
                <?= CHtml::textField('length[to]', Yii::app()->attributesFilter->getMainSearchParamsValue('length', 'to', Yii::app()->getRequest()), ['class' => 'form-control', 'placeholder' => Yii::t('StoreModule.store', 'to')]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <br>Ширина
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <?= CHtml::textField('width[from]', Yii::app()->attributesFilter->getMainSearchParamsValue('width', 'from', Yii::app()->getRequest()) , ['class' => 'form-control', 'placeholder' => Yii::t('StoreModule.store', 'from')]); ?>
            </div>
            <div class="col-xs-6">
                <?= CHtml::textField('width[to]', Yii::app()->attributesFilter->getMainSearchParamsValue('width', 'to', Yii::app()->getRequest()), ['class' => 'form-control', 'placeholder' => Yii::t('StoreModule.store', 'to')]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <br>Высота
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <?= CHtml::textField('height[from]', Yii::app()->attributesFilter->getMainSearchParamsValue('height', 'from', Yii::app()->getRequest()) , ['class' => 'form-control', 'placeholder' => Yii::t('StoreModule.store', 'from')]); ?>
            </div>
            <div class="col-xs-6">
                <?= CHtml::textField('height[to]', Yii::app()->attributesFilter->getMainSearchParamsValue('height', 'to', Yii::app()->getRequest()), ['class' => 'form-control', 'placeholder' => Yii::t('StoreModule.store', 'to')]); ?>
            </div>
        </div>
    </div>
</div>
<hr>
