<?php
/**
 * Отображение для Default/_image_add:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'image-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('GalleryModule.gallery', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('GalleryModule.gallery', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-2">
        <?php echo $form->dropDownListGroup(
            $model,
            'category_id',
            [
                'widgetOptions' => [
                    'data'        => Category::model()->getFormattedList(
                            (int)Yii::app()->getModule('image')->mainCategory
                        ),
                    'htmlOptions' => [
                        'empty' => Yii::t('GalleryModule.gallery', '--choose--'),
                    ],
                ]
            ]
        ); ?>
    </div>
    <div class='col-sm-2'>
        <?php echo $form->dropDownListGroup(
            $model,
            'type',
            [
                'widgetOptions' => [
                    'data' => $model->getTypeList(),
                ],
            ]
        ); ?>
    </div>

    <div class='col-sm-2'>
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data' => $model->getStatusList(),
                ],
            ]
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-6">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-6">
        <?php echo $form->textFieldGroup($model, 'alt'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-6">
        <?php if (!$model->isNewRecord) : { ?>
            <?php echo CHtml::image($model->getImageUrl(), $model->alt); ?>
        <?php } endif; ?>
        <img id="preview" src="#" class='img-polaroid' alt="current preview of image"/>
        <?php echo $form->fileFieldGroup(
            $model,
            'file',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'onchange' => 'readURL(this);',
                        'style'    => 'background-color: inherit;',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php $form->textAreaGroup($model, 'description'); ?>
    </div>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('GalleryModule.gallery', 'Create image') : Yii::t(
                'GalleryModule.gallery',
                'Save image'
            ),
    ]
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
