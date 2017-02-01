<?php $form = $this->beginWidget(
    'CActiveForm',
    [
        'action' => ['/store/product/index'],
        'method' => 'GET',
    ]
) ?>
<?= CHtml::textField(
    AttributeFilter::MAIN_SEARCH_QUERY_NAME,
    CHtml::encode(Yii::app()->getRequest()->getQuery(AttributeFilter::MAIN_SEARCH_QUERY_NAME)),
    ['class' => 'search-bar__input']
); ?>
<?php $this->endWidget(); ?>
