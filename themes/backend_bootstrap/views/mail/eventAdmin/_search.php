<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'htmlOptions' => array( 'class' => 'well' ),
)); ?>

    <fieldset class="inline">
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'id', array('class' => 'span5', 'maxlength' => 10)); ?>
            </div>
            <div class="span2">
                <?php echo  $form->textFieldRow($model, 'code', array('class' => 'span5', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo  $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 300)); ?>
            </div>
            <div class="span4">
                <?php echo  $form->textAreaRow($model, 'description', array('rows' => 2, 'cols' => 20, 'class' => 'span8')); ?>
            </div>
        </div>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'encodeLabel' => false,
            'label' => '<i class="icon-search icon-white"></i> '.Yii::t('menu', 'Искать')
         )); ?>
    </fieldset>
<?php $this->endWidget(); ?>
