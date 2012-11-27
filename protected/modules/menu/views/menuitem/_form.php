<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'menu-item-form',
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

    <div class="row-fluid control-group <?php echo $model->hasErrors("title") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'title', array('class' => 'popover-help span7', 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('title'), 'data-content' => $model->getAttributeDescription('title'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors("href") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'href', array('class' => 'popover-help span7', 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('href'), 'data-content' => $model->getAttributeDescription('href'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors("sort") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'sort', array('class' => 'popover-help span7', 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('sort'), 'data-content' => $model->getAttributeDescription('sort'))); ?>
    </div>
    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('menu_id') || $model->hasErrors('parent_id')) ? 'error' : ''; ?>">
        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'menu_id', CHtml::listData(Menu::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('menu', '--выберите меню--'), 'class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('menu_id'), 'data-content' => $model->getAttributeDescription('menu_id'))); ?>
        </div>
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'parent_id', $model->parentList, array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('parent_id'), 'data-content' => $model->getAttributeDescription('parent_id'))); ?>
        </div>
    </div>
    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('condition_name') || $model->hasErrors('condition_denial')) ? 'error' : ''; ?>">
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'condition_name', $model->conditionList, array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('condition_name'), 'data-content' => $model->getAttributeDescription('condition_name'))); ?>
        </div>
        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'condition_denial', $model->conditionDenialList, array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('condition_denial'), 'data-content' => $model->getAttributeDescription('condition_denial'))); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
    </div>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('menu', 'Добавить пункт меню и продолжить') : Yii::t('menu', 'Сохранить пункт меню и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('menu', 'Добавить пункт меню и закрыть') : Yii::t('menu', 'Сохранить пункт меню и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>