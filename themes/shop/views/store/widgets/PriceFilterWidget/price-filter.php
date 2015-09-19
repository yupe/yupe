<?php $filter = Yii::app()->getComponent('attributesFilter');?>
<div data-collapse="persist" id="filter-price" class="filter-block">
    <div class="filter-block__title"><?= Yii::t('StoreModule.store', 'Price filter'); ?></div>
    <div class="filter-block__body">
        <div class="filter-block__range">
            <span sign-title="<?= Yii::t('StoreModule.store', 'from') ?>" class="filter-input filter-input_range">
                <span class="filter-input__box">
                    <?= CHtml::textField('price[from]', Yii::app()->attributesFilter->getMainSearchParamsValue('price', 'from', Yii::app()->getRequest()),
                    ['class' => 'filter-input__control']); ?>
                </span>
            </span><span sign-title="<?= Yii::t('StoreModule.store', 'to') ?>" class="filter-input filter-input_range">
                <span class="filter-input__box">
                    <?= CHtml::textField('price[to]', Yii::app()->attributesFilter->getMainSearchParamsValue('price', 'to', Yii::app()->getRequest()),
                    ['class' => 'filter-input__control']); ?>
                </span>
            </span>
        </div>
    </div>
</div>
