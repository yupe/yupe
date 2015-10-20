<?php
/**
 * Отображение для gallery/edit-image:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<div class="grid-module-6">
    <?php $form = $this->beginWidget(
        'CActiveForm',
        [
            'id' => 'add-image-form',
            'enableClientValidation' => true,
            'htmlOptions' => ['enctype' => 'multipart/form-data']
        ]
    ); ?>

    <legend>
        <?= $model->getIsNewRecord()
            ? Yii::t('GalleryModule.gallery', 'Image creation')
            : Yii::t('GalleryModule.gallery', 'Image edition'); ?>
    </legend>

    <?= $form->errorSummary($model); ?>

    <?php if ($model->file !== null): ?>
        <div class="fast-order__inputs">
            <?= CHtml::image($model->getImageUrl(190, 190), $model->alt); ?>
        </div>
    <?php endif; ?>
    <div class="fast-order__inputs">
        <?= $form->labelEx($model, 'file'); ?>
        <?= $form->fileField($model, 'file', ['class' => 'input input_big']); ?>
        <?= $form->error($model, 'file') ?>
    </div>

    <div class="fast-order__inputs">
        <?= $form->labelEx($model, 'name'); ?>
        <?= $form->textField($model, 'name', ['class' => 'input input_big']); ?>
        <?= $form->error($model, 'name') ?>
    </div>

    <div class="fast-order__inputs">
        <?= $form->labelEx($model, 'description'); ?>
        <?= $form->textArea($model, 'description', ['class' => 'input input_big', 'rows' => 7]); ?>
        <?= $form->error($model, 'description') ?>
    </div>

    <div class="fast-order__inputs">
        <?= $form->labelEx($model, 'alt'); ?>
        <?= $form->textField($model, 'alt', ['class' => 'input input_big']); ?>
        <?= $form->error($model, 'alt') ?>
    </div>

    <div class="fast-order__inputs">
        <div class="column grid-module-3">
            <?= CHtml::submitButton(
                $model->getIsNewRecord() ? Yii::t('GalleryModule.gallery', 'Create image') : Yii::t('GalleryModule.gallery', 'Refresh image'),
                [ 'id' => 'login-btn', 'class' => 'btn btn_big btn_wide btn_primary']
            ) ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>
