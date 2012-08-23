<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'blog-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well form-vertical'),
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ 'delay' : 500 });
    });
");
?>

    <div class="alert alert-info">
        <?php echo Yii::t('blog', 'Поля, отмеченные'); ?> 
        <span class="required">*</span> 
        <?php echo Yii::t('blog', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span3 popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('slug') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'slug', array('class' => 'span3 popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('icon') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'icon', array('class' => 'span3 popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('icon'), 'data-content' => $model->getAttributeDescription('icon'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <?php echo $form->labelEx($model, 'publish_date'); ?>
        <?php $this->widget($this->module->editor, array(
            'model' => $model,
            'attribute' => 'description',
            'options' => array(
                'toolbar' => 'main',
                'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxFileUpload/',
            ),
            'htmlOptions' => array('rows' => 20, 'cols' => 6),
        )); ?>
        <br />
        <?php $this->widget('bootstrap.widgets.TbLabel', array('type' => 'info', 'label' => $model->getAttributeDescription('description'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('type') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'type', $model->getTypeList(), array('class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('type'), 'data-content' => $model->getAttributeDescription('type'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
    </div>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('blog', 'Добавить блог') : Yii::t('blog', 'Сохранить блог'),
    )); ?>

<?php $this->endWidget(); ?>