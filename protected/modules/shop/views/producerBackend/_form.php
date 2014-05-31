<script type='text/javascript'>
    $(document).ready(function () {
        $('#producer-form').liTranslit({
            elName: '#Producer_name_short',
            elAlias: '#Producer_slug'
        });
    })
</script>

<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'producer-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well', 'enctype' => 'multipart/form-data'),
        'inlineErrors'           => true,
    )
);
?>

<div class="alert alert-info">
    <?php echo Yii::t('ShopModule.producer', 'Поля, отмеченные'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('ShopModule.producer', 'обязательны.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>
<div class="wide row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : ''; ?>">
    <div class="span4">
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => '', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
    </div>
</div>
<div class="row-fluid control-group <?php echo $model->hasErrors('name_short') ? 'error' : ''; ?>">
    <?php echo $form->textFieldRow($model, 'name_short', array('class' => 'span7', 'size' => 60, 'maxlength' => 250, 'data-original-title' => $model->getAttributeLabel('name_short'), 'data-content' => $model->getAttributeDescription('name_short'))); ?>
</div>
<div class="row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'size' => 60, 'maxlength' => 250, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
</div>
<div class="row-fluid control-group <?php echo $model->hasErrors('slug') ? 'error' : ''; ?>">
    <?php echo $form->textFieldRow($model, 'slug', array('class' => 'span7', 'size' => 60, 'maxlength' => 150, 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
</div>
<div class='row-fluid control-group <?php echo $model->hasErrors("image") ? "error" : ""; ?>'>
    <?php if (!$model->isNewRecord && $model->image): ?>
        <?php echo CHtml::image($model->getImageUrl(200, 200), $model->name, array('class' => 'preview-image img-polaroid')); ?>
    <?php endif; ?>
    <?php echo $form->fileFieldRow($model, 'image', array('class' => 'span5', 'maxlength' => 250, 'size' => 60, 'onchange' => 'readURL(this);')); ?>
</div>
<div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
    <div class="" data-original-title='<?php echo $model->getAttributeLabel('description'); ?>' data-content='<?php echo $model->getAttributeDescription('description'); ?>'>
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget($this->module->editor, array(
            'model'     => $model,
            'attribute' => 'description',
            'options'   => $this->module->editorOptions,
        )); ?>
    </div>
</div>
<div class="row-fluid control-group <?php echo $model->hasErrors('short_description') ? 'error' : ''; ?>">
    <div class="" data-original-title='<?php echo $model->getAttributeLabel('short_description'); ?>' data-content='<?php echo $model->getAttributeDescription('short_description'); ?>'>
        <?php echo $form->labelEx($model, 'short_description'); ?>
        <?php $this->widget($this->module->editor, array(
            'model'     => $model,
            'attribute' => 'short_description',
            'options'   => $this->module->editorOptions,
        )); ?>
    </div>
</div>
<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
<div class="accordion-group">
    <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
            <?php echo Yii::t('ShopModule.producer', 'Данные для SEO'); ?>
        </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse">
        <div class="accordion-inner">
            <div class="row-fluid control-group <?php echo $model->hasErrors('keywords') ? 'error' : ''; ?>">
                <?php echo $form->textFieldRow($model, 'meta_title', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('meta_title'), 'data-content' => $model->getAttributeDescription('meta_title'))); ?>
            </div>
            <div class="row-fluid control-group <?php echo $model->hasErrors('keywords') ? 'error' : ''; ?>">
                <?php echo $form->textFieldRow($model, 'meta_keywords', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('meta_keywords'), 'data-content' => $model->getAttributeDescription('meta_keywords'))); ?>
            </div>
            <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
                <?php echo $form->textAreaRow($model, 'meta_description', array('rows' => 3, 'cols' => 98, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('meta_description'), 'data-content' => $model->getAttributeDescription('meta_description'))); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<br/><br/>

<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type'       => 'primary',
    'label'      => Yii::t('ShopModule.producer', 'Сохранить и продолжить'),
));
?>

<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
    'buttonType'  => 'submit',
    'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
    'label'       => Yii::t('ShopModule.producer', 'Сохранить и вернуться к списку'),
));
?>

<?php $this->endWidget(); ?>