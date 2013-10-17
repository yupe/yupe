<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'htmlOptions' => array('class' => 'well search-form'),
        ));
?>
<fieldset class="inline">

    <?php echo $form->textFieldRow($model, 'id', array('class' => 'span5', 'maxlength' => 10)); ?>

    <?php echo $form->textFieldRow($model, 'code', array('class' => 'span5', 'maxlength' => 100)); ?>

    <?php echo $form->textFieldRow($model, 'event_id', array('class' => 'span5', 'maxlength' => 10)); ?>

    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 300)); ?>

    <?php echo $form->textAreaRow($model, 'description', array('rows' => 2, 'cols' => 40, 'class' => 'span8')); ?>

    <?php echo $form->textFieldRow($model, 'from', array('class' => 'span5', 'maxlength' => 300)); ?>

    <?php echo $form->textFieldRow($model, 'to', array('class' => 'span5', 'maxlength' => 300)); ?>

    <?php echo $form->textAreaRow($model, 'theme', array('rows' => 2, 'cols' => 20, 'class' => 'span8')); ?>

    <?php echo $form->textAreaRow($model, 'body', array('rows' => 2, 'cols' => 20, 'class' => 'span8')); ?>

    <?php echo $form->textFieldRow($model, 'status', array('class' => 'span5')); ?>
    
    <div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'encodeLabel' => false,
        'label' => '<i class="icon-search icon-white"></i> ' . Yii::t('MailModule.mail', 'Find')
    ));
    ?>
    </div>
</fieldset>

<?php $this->endWidget(); ?>
