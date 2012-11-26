<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'menu-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', 'delay' : 500 });
    });
");
?>

    <div class="alert alert-info">
        <?php echo Yii::t('menu', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('menu', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>

     <div class='control-group <?php echo $model->hasErrors("code") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>

      <div class='row-fluid control-group <?php echo $model->hasErrors("description")?"error":"" ?>'>
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                                                'model' => $model,
                                                'attribute' => 'description',
                                                'options'   => array(
                                                    'toolbar' => 'main',
                                                    'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'
                                                ),
                                                'htmlOptions' => array('rows' => 20,'cols' => 6)
                                            ))?>
            <br /><?php echo $form->error($model, 'description'); ?>
     </div>

     <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : '' ?>">
         <div class="span7  popover-help" data-content="<?php echo Yii::t('menu', "<span class='label label-success'>Активно</span> &ndash;Меню отображается на сайте.<br /><br /><span class='label label-default'>Не активно</span> &ndash; Меню не отображается на сайте.<br /><br />"); ?>" data-original-title="<?php echo $model-> getAttributeLabel('status'); ?>">
             <?php echo $form->labelEx($model, 'status'); ?>
             <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
         </div>
         <div class="span5">
             <?php echo $form->error($model, 'status'); ?>
         </div>
     </div>

     <?php $this->widget('bootstrap.widgets.TbButton', array(
         'buttonType' => 'submit',
         'type'       => 'primary',
         'label'      => $model->isNewRecord ? Yii::t('menu', 'Добавить меню и продолжить') : Yii::t('menu', 'Сохранить меню и продолжить'),
     )); ?>
 
      <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('menu', 'Добавить меню и закрыть') : Yii::t('menu', 'Сохранить меню и закрыть'),
      )); ?>

<?php $this->endWidget(); ?>