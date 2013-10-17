<script type='text/javascript'>
    $(document).ready(function(){
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
        <?php echo Yii::t('CategoryModule.category', 'Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('CategoryModule.category', 'are required'); ?>
    </div>

    <?php echo  $form->errorSummary($model); ?>

    <?php if(count($languages) > 1):?>
        <?php echo $form->dropDownListRow($model, 'lang', $languages, array('class' => 'popover-help','empty' => Yii::t('CategoryModule.category', '--choose--'))); ?>
        <?php if(!$model->isNewRecord):?>
            <?php foreach($languages as $k => $v):?>
                <?php if($k !== $model->lang):?>
                    <?php if(empty($langModels[$k])):?>
                        <a href="<?php echo $this->createUrl('/category/categoryBackend/create',array('id' => $model->id,'lang'  => $k));?>"><i class="iconflags iconflags-<?php echo $k;?>" title="<?php echo Yii::t('CategoryModule.category','Add translate in to {lang}',array('{lang}' => $v))?>"></i></a>
                    <?php else:?>
                        <a href="<?php echo $this->createUrl('/category/categoryBackend/update',array('id' => $langModels[$k]));?>"><i class="iconflags iconflags-<?php echo $k;?>" title="<?php echo Yii::t('CategoryModule.category','Change translation in to {lang}',array('{lang}' => $v))?>"></i></a>
                    <?php endif;?>
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>
    <?php else:?>
        <?php echo $form->hiddenField($model,'lang');?>
    <?php endif;?>

    <div class='row-fluid control-group <?php echo $model->hasErrors("parent_id") ? "error" : ""; ?>'>
        <?php echo  $form->dropDownListRow($model, 'parent_id', Category::model()->getFormattedList(), array('empty' => Yii::t('CategoryModule.category', '--no--'),'class' => 'span7', 'encode' => false)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 250)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("alias") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'alias', array('class' => 'span7', 'maxlength' => 150)); ?>
    </div>
    <div class='row-fluid control-group <?php echo $model->hasErrors("image") ? "error" : ""; ?>'>
        <?php if (!$model->isNewRecord && $model->image): ?>
            <?php echo CHtml::image(Yii::app()->baseUrl . '/' . $this->yupe->uploadPath . '/' . $this->module->uploadPath . '/' . $model->image, $model->name, array('width' => 300, 'height' => 300)); ?>
        <?php endif; ?>
        <?php echo  $form->fileFieldRow($model, 'image', array('class' => 'span5', 'maxlength' => 250, 'size' => 60)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("description") ? "error" : ""; ?>'>
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget($this->module->editor, array(
        'model'       => $model,
        'attribute'   => 'description',
        'options'     => $this->module->editorOptions,
    )); ?>
        <br /><?php echo $form->error($model, 'description'); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("short_description") ? "error" : ""; ?>'>
        <?php echo $form->labelEx($model, 'short_description'); ?>
        <?php $this->widget($this->module->editor, array(
        'model'       => $model,
        'attribute'   => 'short_description',
        'options'     => $this->module->editorOptions,
    )); ?>
        <br /><?php echo $form->error($model, 'short_description'); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
        <?php echo  $form->dropDownListRow($model, 'status', $model->statusList,array('class' => 'span7')); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CategoryModule.category', 'Create category and continue') : Yii::t('CategoryModule.category', 'Save category and continue'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('CategoryModule.category', 'Create category and close') : Yii::t('CategoryModule.category', 'Save category and close'),
    )); ?>

<?php $this->endWidget(); ?>
