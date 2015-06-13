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
<div class="form well">
    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        [
            'id'                     => 'add-image-form',
            'enableClientValidation' => true,
            'htmlOptions'            => ['enctype' => 'multipart/form-data']
        ]
    ); ?>

    <legend>
        <?= $model->getIsNewRecord()
            ? Yii::t('GalleryModule.gallery', 'Image creation')
            : Yii::t('GalleryModule.gallery', 'Image edition'); ?>
    </legend>

    <?= $form->errorSummary($model); ?>

    <?php if ($model->file !== null): ?>
        <div class="row">
            <?= CHtml::image($model->getImageUrl(190, 190), $model->alt); ?>
        </div>
    <?php endif; ?>

    <div class='row'>
        <div class="col-sm-7">
            <?= $form->fileFieldGroup(
                $model,
                'file',
                [
                    'widgetOptions' => [
                        'htmlOptions' => ['style' => 'background-color: inherit;'],
                    ],
                ]
            ); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-7">
            <?= $form->textFieldGroup($model, 'name'); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-12">
            <?= $form->textAreaGroup(
                $model,
                'description',
                [
                    'widgetOptions' => [
                        'htmlOptions' => [
                            'rows' => 7,
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-7">
            <?= $form->textFieldGroup($model, 'alt'); ?>
        </div>
    </div>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'buttonType' => 'submit',
            'context'    => 'primary',
            'icon'       => 'glyphicon glyphicon-picture',
            'label'      => $model->getIsNewRecord()
                    ? Yii::t('GalleryModule.gallery', 'Create image')
                    : Yii::t('GalleryModule.gallery', 'Refresh image')
        ]
    ); ?>

    <?php $this->endWidget(); ?>
</div>
