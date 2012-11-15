   <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array('class' => 'well search-form'),
            ));
    ?>

    <fieldset class="inline">        
        <?php echo $form->textFieldRow($model, 'id', array('size' => 10, 'maxlength' => 10)); ?>   
        <?php echo $form->textFieldRow($model, 'model', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'model_id', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'creation_date'); ?>
        <?php echo $form->textFieldRow($model, 'name', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'url', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textAreaRow($model, 'text', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->textFieldRow($model, 'ip', array('size' => 20, 'maxlength' => 20)); ?>
        <div class="form-actions">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(       
                'buttonType' => 'submit',
                'type' => 'primary',
                'encodeLabel' => false,
                'label' => '<i class="icon-search icon-white"></i> ' . Yii::t('mail', 'Искать')
            ));
            ?>
        </div>
    </fieldset>

    <?php $this->endWidget(); ?>
