<?php
/**
 * Отображение для default/_form:
 * 
 *   @category YupeView
 *   @package  YupeCMS
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
        <?php echo Yii::t('ImageModule.image', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('ImageModule.image', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='row-fluid control-group <?php echo $model->hasErrors("category_id") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array('empty' => Yii::t('ImageModule.image', '--выберите--'))); ?>
    </div>
    <?php if (Yii::app()->hasModule('gallery')) : ?>
    <div class='row-fluid control-group <?php echo $model->hasErrors("galleryId") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'galleryId', $model->galleryList(), array('empty' => Yii::t('ImageModule.image', '--выберите--'))); ?>
    </div>
    <?php endif; ?>
    <div class='row-fluid control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 150, 'size' => 60)); ?>
    </div>
    <div class='row-fluid control-group <?php echo $model->hasErrors("file") ? "error" : ""; ?>'>
        <?php if (!$model->isNewRecord) : ?>
            <?php echo CHtml::image($model->getUrl(300), $model->alt, array("width" => 300, "height" => 300));?>
        <?php endif; ?>
        <?php echo $form->fileFieldRow($model, 'file', array('class' => 'span7', 'maxlength' => 500, 'size' => 60)); ?>
    </div>
    <div class='row-fluid control-group <?php echo $model->hasErrors("alt") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'alt', array('class' => 'span7', 'maxlength' => 150, 'size' => 60)); ?>
    </div>
    <div class='row-fluid control-group <?php echo $model->hasErrors("type") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'type', $model->getTypeList()); ?>
    </div>
    <div class='row-fluid control-group <?php echo $model->hasErrors("description") ? "error" : ""; ?>'>
        <?php $form->textAreaRow($model, 'description', array('class' => 'span7')); ?>
    </div>
    <div class='row-fluid control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList); ?>
    </div>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => $model->isNewRecord ? Yii::t('ImageModule.image', 'Добавить изображение и продолжить') : Yii::t('ImageModule.image', 'Сохранить изображение и продолжить'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType'  => 'submit',
            'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
            'label'       => $model->isNewRecord ? Yii::t('ImageModule.image', 'Добавить изображение и закрыть') : Yii::t('ImageModule.image', 'Сохранить изображение и закрыть'),
        )
    ); ?>

<?php $this->endWidget(); ?>
