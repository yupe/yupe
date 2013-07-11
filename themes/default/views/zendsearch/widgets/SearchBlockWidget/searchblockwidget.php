<?php echo CHtml::beginForm(array('/zendsearch/search/search'), 'get'); ?>
    <?php echo CHtml::textField('q', '', array('placeholder' => 'Поиск...', 'class' => ''));?>
    <?php echo CHtml::submitButton('Искать!', array('class' => 'btn'));?>
<?php echo CHtml::endForm();?>
