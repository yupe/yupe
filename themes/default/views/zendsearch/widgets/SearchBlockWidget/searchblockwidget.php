<?php Yii::import('application.modules.zendsearch.ZendSearchModule'); ?>
<?php echo CHtml::beginForm(['/zendsearch/search/search'], 'get', ['class' => 'form-inline']); ?>
<?php echo CHtml::textField(
    'q',
    '',
    ['placeholder' => Yii::t('ZendSearchModule.zendsearch', 'Search...'), 'class' => 'form-control']
); ?>
<?php echo CHtml::submitButton(
    Yii::t('ZendSearchModule.zendsearch', 'Find!'),
    ['class' => 'btn btn-default', 'name' => '']
); ?>
<?php echo CHtml::endForm(); ?>
