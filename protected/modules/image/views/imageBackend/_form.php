<?php
/**
 * Отображение для default/_form:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'image-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well', 'enctype'=>'multipart/form-data'),
        'inlineErrors'           => true,
    )
); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('ImageModule.image', 'Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('ImageModule.image', 'are required.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='row-fluid control-group'>

        <div class='span2'>
            <?php echo $form->dropDownListRow($model, 'type', $model->getTypeList()); ?>
    </div>

    <?php if (Yii::app()->hasModule('gallery')) : ?>
            <div class='span2'>
        <?php echo $form->dropDownListRow($model, 'galleryId', $model->galleryList(), array('empty' => Yii::t('ImageModule.image', '--choose--'))); ?>
    </div>
    <?php endif; ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 150, 'size' => 60)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("alt") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'alt', array('class' => 'span7', 'maxlength' => 150, 'size' => 60)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("file") ? "error" : ""; ?>'>
        <?php if (!$model->isNewRecord) : ?>
            <?php echo CHtml::image($model->getImageUrl(300), $model->alt, array("width" => 300, "height" => 300));?>
        <?php endif; ?>
        <?php echo $form->fileFieldRow($model, 'file', array('class' => 'span7', 'maxlength' => 500, 'size' => 60)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("description") ? "error" : ""; ?>'>
        <?php echo $form->textAreaRow($model, 'description', array('class' => 'span7')); ?>
    </div>

    <div class='row-fluid control-group'>

        <div class='span2'>
            <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList()); ?>
    </div>

             <span class="span2">
                <?php echo $form->dropDownListRow($model, 'category_id', Category::model()->getFormattedList(), array('empty' => Yii::t('ImageModule.image', '--choose--'), 'encode' => false)); ?>
            </span>

    </div>


    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => $model->isNewRecord ? Yii::t('ImageModule.image', 'Add image and close') : Yii::t('ImageModule.image', 'Save image and continue'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType'  => 'submit',
            'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
            'label'       => $model->isNewRecord ? Yii::t('ImageModule.image', 'Add image and save') : Yii::t('ImageModule.image', 'Save mage and close'),
        )
    ); ?>

<?php $this->endWidget(); ?>
