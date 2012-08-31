<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'user-to-blog-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well form-vertical'),
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ 'trigger' : 'hover', 'delay' : 500 });
    });
");
?>

    <div class="alert alert-info">
        <?php echo Yii::t('blog', 'Поля, отмеченные'); ?> 
        <span class="required">*</span> 
        <?php echo Yii::t('blog', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('user_id') || $model->hasErrors('blog_id') || $model->hasErrors('role')) ? 'error' : ''; ?>">
        <div class="span2">
            <?php echo $form->dropDownListRow($model, 'user_id', CHtml::listData(User::model()->findAll(), 'id', 'nick_name'), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('user_id'), 'data-content' => $model->getAttributeDescription('user_id'))); ?>
        </div>
        <div class="span2">
            <?php echo $form->dropDownListRow($model, 'blog_id', CHtml::listData(Blog::model()->findAll(), 'id', 'name'), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('blog_id'), 'data-content' => $model->getAttributeDescription('blog_id'))); ?>
        </div>
        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'role', $model->getRoleList(), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('role'), 'data-content' => $model->getAttributeDescription('role'))); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo ($model->hasErrors('role') || $model->hasErrors('status')) ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('note') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'note', array('class' => 'span7 popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('note'), 'data-content' => $model->getAttributeDescription('note'))); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('blog', 'Добавить участника и продолжить') : Yii::t('blog', 'Сохранить участника и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
        'label'      => $model->isNewRecord ? Yii::t('blog', 'Добавить участника и закрыть') : Yii::t('blog', 'Сохранить участника и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>