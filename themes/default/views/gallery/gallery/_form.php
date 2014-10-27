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
        array(
            'id'                     => 'add-image-form',
            'enableClientValidation' => true,
            'htmlOptions'            => array('enctype' => 'multipart/form-data')
        )
    ); ?>

    <legend>
        <?php echo $model->getIsNewRecord()
            ? Yii::t('GalleryModule.gallery', 'Image creation')
            : Yii::t('GalleryModule.gallery', 'Image edition'); ?>
    </legend>

    <?php echo $form->errorSummary($model); ?>

    <?php if ($model->file !== null) : { ?>
        <div class="row">
            <?php echo CHtml::image($model->getImageUrl(190), $model->alt); ?>
        </div>
    <?php } endif; ?>

    <div class='row'>
        <div class="col-sm-7">
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
            <?php echo $form->textFieldGroup($model, 'name'); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-12">
            <?php echo $form->textAreaGroup(
                $model,
                'description',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'rows' => 7,
                        ),
                    ),
                )
            ); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'alt'); ?>
        </div>
    </div>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'context'    => 'primary',
            'icon'       => 'glyphicon glyphicon-picture',
            'label'      => $model->getIsNewRecord()
                    ? Yii::t('GalleryModule.gallery', 'Create image')
                    : Yii::t('GalleryModule.gallery', 'Refresh image')
        )
    ); ?>

    <?php $this->endWidget(); ?>
</div>
