<?php
/**
 * Отображение для default/_form:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'image-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    )
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('ImageModule.image', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('ImageModule.image', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class='col-sm-2'>
        <?php echo $form->dropDownListGroup(
            $model,
            'type',
            array(
                'widgetOptions' => array(
                    'data' => $model->getTypeList(),
                ),
            )
        ); ?>
    </div>
    <?php if (Yii::app()->hasModule('gallery')) : { ?>
        <div class='col-sm-2'>
            <?php echo $form->dropDownListGroup(
                $model,
                'galleryId',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->galleryList(),
                        'htmlOptions' => array('empty' => Yii::t('ImageModule.image', '--choose--')),
                    ),
                )
            ); ?>
        </div>
    <?php } endif; ?>
</div>

<div class='row'>
    <div class='col-sm-2'>
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            array(
                'widgetOptions' => array(
                    'data' => $model->getStatusList(),
                ),
            )
        ); ?>
    </div>
     <span class="col-sm-2">
        <?php echo $form->dropDownListGroup(
            $model,
            'category_id',
            array(
                'widgetOptions' => array(
                    'data'        => Category::model()->getFormattedList(),
                    'htmlOptions' => array('empty' => Yii::t('ImageModule.image', '--choose--'), 'encode' => false),
                ),
            )
        ); ?>
    </span>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'alt'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php if (!$model->isNewRecord) : { ?>
            <?php echo CHtml::image($model->getImageUrl(300, 200), $model->alt, array("width" => 300, "height" => 200)); ?>
        <?php } endif; ?>
        <?php echo $form->fileFieldGroup(
            $model,
            'file',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array('style' => 'background-color: inherit;'),
                ),
            )
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textAreaGroup($model, 'description'); ?>
    </div>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('ImageModule.image', 'Add image and close') : Yii::t(
                'ImageModule.image',
                'Save image and continue'
            ),
    )
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('ImageModule.image', 'Add image and save') : Yii::t(
                'ImageModule.image',
                'Save mage and close'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
