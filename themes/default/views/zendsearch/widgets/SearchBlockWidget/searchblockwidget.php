<?php Yii::import('application.modules.zendsearch.ZendSearchModule'); ?>
<?php echo CHtml::beginForm(array('/zendsearch/search/search'), 'get', array('class' => 'form-inline')); ?>
<?php echo CHtml::textField(
    'q',
    '',
    array('placeholder' => Yii::t('ZendSearchModule.zendsearch', 'Search...'), 'class' => 'form-control')
); ?>
<?php echo CHtml::submitButton(
    Yii::t('ZendSearchModule.zendsearch', 'Find!'),
    array('class' => 'btn btn-default', 'name' => '')
); ?>
<?php echo CHtml::endForm(); ?>
