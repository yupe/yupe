<?php
/**
 * Отображение для Default/_image_add:
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
        <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData(Yii::app()->getModule('image')->getCategoryList(), 'id', 'name'), array('empty' => Yii::t('news', '--выберите--'))); ?>
    </div>
    <div class='row-fluid control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300, 'size' => 60)); ?>
    </div>
    <div class='row-fluid control-group <?php echo $model->hasErrors("file") ? "error" : ""; ?>'>
        <?php if (!$model->isNewRecord) : ?>
            <?php echo CHtml::image($model->getUrl(), $model->alt);?>
        <?php endif; ?>
        <img id="preview" src="#" class='img-polaroid' alt="current preview of image" />
        <?php echo $form->fileFieldRow($model, 'file', array('class' => 'span7', 'maxlength' => 500, 'size' => 60, 'onchange' => 'readURL(this);')); ?>
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
            'label'      => $model->isNewRecord ? Yii::t('ImageModule.image', 'Добавить изображение') : Yii::t('ImageModule.image', 'Сохранить изображение'),
        )
    ); ?>

<?php $this->endWidget(); ?>
<style>
#preview {
    display: none;
    max-width: 250px;
    max-height: 250px;
}
</style>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result).show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>