<?php
/**
 * Отображение для gallery/edit-image:
 *
 * @category YupeView
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<div class="form well">
    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        array(
            'id' => 'add-image-form',
            'enableClientValidation' => true,
            'htmlOptions' => array('enctype' => 'multipart/form-data')
        )
    ); ?>

    <legend>
        <?php echo $model->getIsNewRecord()
            ? Yii::t('GalleryModule.gallery', 'Image creation')
            : Yii::t('GalleryModule.gallery', 'Image edition'); ?>
    </legend>

    <?php echo $form->errorSummary($model); ?>

    <?php if ($model->file !== null) : ?>
        <div class="row-fluid">
            <?php echo CHtml::image($model->getUrl(190), $model->alt); ?>
        </div>
    <?php endif; ?>

    <div class='row-fluid control-group <?php echo $model->hasErrors('file') ? 'error' : ''; ?>'>
        <?php echo $form->fileFieldRow($model, 'file', array('class' => 'span6', 'required' => false)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span6', 'required' => true)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>'>
        <?php echo $form->textAreaRow(
            $model,
            'description',
            array('class' => 'span12', 'required' => true, 'rows' => 7, 'cols' => 30)
        ); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('alt') ? 'error' : ''; ?>'>
        <?php echo $form->textFieldRow($model, 'alt', array('class' => 'span6', 'required' => true)); ?>
    </div>

    <div class="row-fluid  control-group">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'icon' => 'picture',
                'label' => $model->getIsNewRecord()
                    ? Yii::t('GalleryModule.gallery', 'Add image')
                    : Yii::t('GalleryModule.gallery', 'Update image')
            )
        ); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>