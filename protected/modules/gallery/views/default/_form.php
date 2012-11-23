<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'gallery-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ 'trigger' : 'hover', 'delay' : 500 });
    });
");
?>

    <div class="alert alert-info">
        <?php echo Yii::t('gallery', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('gallery', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("name")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'name',array('class'=>'span7','maxlength'=>300)); ?></div>
   
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
            <div class="span12">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                    'model' => $model,
                    'attribute' => 'description',
                    'options' => array(
                        'toolbar' => 'main',
                        'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxFileUpload/'
                    ),
                    'htmlOptions' => array('rows' => 20, 'cols' => 6)
                ))?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
    </div>

    
    <div class='control-group <?php echo $model->hasErrors("status")?"error":"" ?>'><?php echo  $form->dropDownListRow($model,'status',$model->getStatusList()); ?></div>
   
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('gallery', 'Сохранить галерею и закрыть'),
    )); ?>
    
   <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
        'label'      => Yii::t('gallery','Сохранить галерею и продолжить'),
    )); ?>

<?php $this->endWidget(); ?>