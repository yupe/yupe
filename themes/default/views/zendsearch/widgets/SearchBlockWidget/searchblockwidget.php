<?php Yii::import('application.modules.zendsearch.ZendSearchModule'); ?>
<?php echo CHtml::beginForm(array('/zendsearch/search/search'), 'get'); ?>
    <?php echo CHtml::textField('q', '', array('placeholder' => Yii::t('ZendSearchModule.zendsearch','Search...'), 'class' => ''));?>
    <?php echo CHtml::submitButton(Yii::t('ZendSearchModule.zendsearch','Find!'), array('class' => 'btn'));?>
<?php echo CHtml::endForm();?>
