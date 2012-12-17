<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'menu-form',
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
        <?php echo Yii::t('menu', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('menu', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'popover-help span7', 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors("code") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'popover-help span7', 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('code'), 'data-content' => $model->getAttributeDescription('code'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors("description") ? "error" : ""; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('description'); ?>' data-content='<?php echo $model->getAttributeDescription('description'); ?>'>
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                'model'     => $model,
                'attribute' => 'description',
                'options'   => array(
                    'toolbar'     => 'main',
                    'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/',
                ),
                'htmlOptions' => array('rows' => 20, 'cols' => 6),
            )); ?>
        </div>
     </div>
     <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : '' ?>">
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
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