<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'page-form',
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
        <?php echo Yii::t('page', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('page', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('category_id') || $model->hasErrors('parent_Id')) ? 'error' : ''; ?>">
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array('empty' => Yii::t('page', '--выберите--'), 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('category_id'), 'data-content' => $model->getAttributeDescription('category_id'))); ?>
        </div>
        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'parent_Id', $pages, array('empty' => Yii::t('page', '--выберите--'), 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('parent_Id'), 'data-content' => $model->getAttributeDescription('parent_Id'))); ?>
        </div>
    </div>
    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('status') || $model->hasErrors('menu_order')) ? 'error' : ''; ?>">
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow($model, 'menu_order', array('size' => 10, 'maxlength' => 10, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('title') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('title'), 'data-content' => $model->getAttributeDescription('title'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('slug') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'slug', array('size' => 60, 'maxlength' => 150, 'placeholder' => Yii::t('page', 'Оставьте пустым для автоматической генерации'), 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('is_protected') ? 'error' : ''; ?>">
        <?php echo $form->checkBoxRow($model, 'is_protected', array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('is_protected'), 'data-content' => $model->getAttributeDescription('is_protected'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('body') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('body'); ?>' data-content='<?php echo $model->getAttributeDescription('body'); ?>'>
            <?php echo $form->labelEx($model, 'body'); ?>
            <?php $this->widget($this->module->editor, array(
                'model'       => $model,
                'attribute'   => 'body',
                'options'     => $this->module->editorOptions,
            )); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('keywords') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'keywords', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('keywords'), 'data-content' => $model->getAttributeDescription('keywords'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($model, 'description', array('rows' => 3, 'cols' => 98, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('blog', 'Добавить страницу и продолжить') : Yii::t('blog', 'Сохранить страницу и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
        'label'      => $model->isNewRecord ? Yii::t('blog', 'Добавить страницу и закрыть') : Yii::t('blog', 'Сохранить страницу и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>