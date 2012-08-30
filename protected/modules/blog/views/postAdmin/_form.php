<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'post-form',
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

    <div class="row-fluid control-group <?php echo $model->hasErrors('blog_id') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'blog_id', CHtml::listData(Blog::model()->findAll(), 'id', 'name'), array('empty'=>Yii::t('blog', 'выберите блог'), 'class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('blog_id'), 'data-content' => $model->getAttributeDescription('blog_id'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('title') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'title', array('class' => 'span3 popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('title'), 'data-content' => $model->getAttributeDescription('title'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('slug') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'slug', array('class' => 'span3 popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('publish_date') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('publish_date'); ?>' data-content='<?php echo $model->getAttributeDescription('publish_date'); ?>'>
            <?php echo $form->labelEx($model, 'publish_date'); ?>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'publish_date',
                'options' => array('dateFormat' => 'yy-mm-dd'),
            )); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('content') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('content'); ?>' data-content='<?php echo $model->getAttributeDescription('content'); ?>'>
            <?php echo $form->labelEx($model, 'content'); ?>
            <?php $this->widget($this->module->editor, array(
                'model' => $model,
                'attribute' => 'content',
                'options' => array(
                    'toolbar' => 'main',
                    'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/',
                ),
                'htmlOptions' => array('rows' => 20, 'cols' => 6),
             )); ?>
         </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('quote') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('quote'); ?>' data-content='<?php echo $model->getAttributeDescription('quote'); ?>'>
            <?php echo $form->labelEx($model, 'quote'); ?>
            <?php $this->widget($this->module->editor, array(
                    'model' => $model,
                    'attribute' => 'quote',
                    'options' => array(
                        'toolbar' => 'main',
                        'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/',
                    ),
                    'htmlOptions' => array('rows' => 20, 'cols' => 6),
            )); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('link') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('tags'); ?>' data-content='<?php echo $model->getAttributeDescription('tags'); ?>'>
            <?php echo $form->labelEx($model, Yii::t('blog', 'Теги')); ?>
            <?php $this->widget('application.modules.blog.extensions.ETagger.ETagger', array(
                'name' => 'tags',
                'keywords' => $model->getTags(),
                'options' => array('closeChar' => 'X'),
            )); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('link') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'link', array('class' => 'span3 popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('link'), 'data-content' => $model->getAttributeDescription('link'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('comment_status') ? 'error' : ''; ?>">
        <?php echo $form->checkBoxRow($model, 'comment_status', array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('comment_status'), 'data-content' => $model->getAttributeDescription('comment_status'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('access_type') ? 'error' : ''; ?>">
        <?php echo $form->dropDownList($model, 'access_type', $model->getAccessTypeList(), array('class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('access_type'), 'data-content' => $model->getAttributeDescription('access_type'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('keywords') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'keywords', array('class' => 'span3 popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('keywords'), 'data-content' => $model->getAttributeDescription('keywords'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($model, 'description', array('class' => 'span5 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('blog', 'Добавить запись') : Yii::t('blog', 'Сохранить запись'),
    )); ?>

<?php $this->endWidget(); ?>