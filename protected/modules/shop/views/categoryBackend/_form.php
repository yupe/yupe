<script type='text/javascript'>
    $(document).ready(function () {
        $('#category-form').liTranslit({
            elName: '#Category_name',
            elAlias: '#Category_alias'
        });
    })
</script>


<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'category-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    'inlineErrors'           => true,
)); ?>
<div class="alert alert-info">
    <?php echo Yii::t('ShopModule.category', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('ShopModule.category', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>


<div class='row-fluid control-group <?php echo $model->hasErrors("parent_id") ? "error" : ""; ?>'>
    <?php echo $form->dropDownListRow($model, 'parent_id', Category::model()->getFormattedList(), array('empty' => Yii::t('ShopModule.category', '--no--'), 'class' => 'span7', 'encode' => false)); ?>
</div>
<div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 250)); ?>
</div>
<div class='control-group <?php echo $model->hasErrors("alias") ? "error" : ""; ?>'>
    <?php echo $form->textFieldRow($model, 'alias', array('class' => 'span7', 'maxlength' => 150)); ?>
</div>
<div class='row-fluid control-group <?php echo $model->hasErrors("image") ? "error" : ""; ?>'>
    <?php if (!$model->isNewRecord && $model->image): ?>
        <?php echo CHtml::image($model->getImageUrl(200, 200), $model->name, array('class' => 'preview-image img-polaroid')); ?>
    <?php endif; ?>
    <?php echo $form->fileFieldRow($model, 'image', array('class' => 'span5', 'maxlength' => 250, 'size' => 60, 'onchange' => 'readURL(this);')); ?>
</div>

<div class='row-fluid control-group <?php echo $model->hasErrors("description") ? "error" : ""; ?>'>
    <?php echo $form->labelEx($model, 'description'); ?>
    <?php $this->widget($this->module->editor, array(
        'model'     => $model,
        'attribute' => 'description',
        'options'   => $this->module->editorOptions,
    )); ?>
    <br/><?php echo $form->error($model, 'description'); ?>
</div>

<div class='row-fluid control-group <?php echo $model->hasErrors("short_description") ? "error" : ""; ?>'>
    <?php echo $form->labelEx($model, 'short_description'); ?>
    <?php $this->widget($this->module->editor, array(
        'model'     => $model,
        'attribute' => 'short_description',
        'options'   => $this->module->editorOptions,
    )); ?>
    <br/><?php echo $form->error($model, 'short_description'); ?>
</div>

<div class='row-fluid control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
    <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('class' => 'span7')); ?>
</div>

<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
<div class="accordion-group">
    <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
            <?php echo Yii::t('ShopModule.category', 'Data for SEO'); ?>
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
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type'       => 'primary',
    'label'      => $model->isNewRecord ? Yii::t('ShopModule.category', 'Create category and continue') : Yii::t('ShopModule.category', 'Save category and continue'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'  => 'submit',
    'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
    'label'       => $model->isNewRecord ? Yii::t('ShopModule.category', 'Create category and close') : Yii::t('ShopModule.category', 'Save category and close'),
)); ?>

<?php $this->endWidget(); ?>
