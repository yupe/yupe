<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'content-block-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });
");
?>
    <div class="alert alert-info">
        <?php echo Yii::t('contentblock', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('contentblock', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('type') ? 'error' : ''; ?>">
        <div class="span7">
            <?php echo $form->dropDownListRow($model, 'type', $model->getTypes(), array('class' => 'span7')); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'type'); ?>
        </div>
    </div>
    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("code") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('content') ? 'error' : ''; ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'content'); ?>
            <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                'model'       => $model,
                'attribute'   => 'content',
                'options'     => array(
                    'toolbar'     => 'main',
                    'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxFileUpload/',
                ),
                'htmlOptions' => array('rows' => 20, 'cols' => 6),
            )); ?>
            <?php echo $form->error($model, 'content'); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                'model'       => $model,
                'attribute'   => 'description',
                'options'     => array(
                    'toolbar'     => 'main',
                    'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxFileUpload/',
                ),
                'htmlOptions' => array('rows' => 20, 'cols' => 6),
            ))?>
            <?php echo $form->error($model, 'description'); ?>
        </div>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('contentblock', 'Добавить блок и продолжить') : Yii::t('contentblock', 'Сохранить блок и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'admin'),
        'label'       => $model->isNewRecord ? Yii::t('contentblock', 'Добавить блок и закрыть') : Yii::t('contentblock', 'Сохранить блок и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>