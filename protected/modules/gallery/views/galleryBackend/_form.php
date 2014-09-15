<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'gallery-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
    )
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
            'owner',
            array(
                'widgetOptions' => array(
                    'data' => $model->getUsersList(),
                ),
            )
        ); ?>
    </div>
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
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 form-group">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            array(
                'model'     => $model,
                'attribute' => 'description',
            )
        ); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>


<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('GalleryModule.gallery', 'Create gallery and continue') : Yii::t(
                'GalleryModule.gallery',
                'Save gallery and continue'
            ),
    )
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('GalleryModule.gallery', 'Create gallery and close') : Yii::t(
                'GalleryModule.gallery',
                'Save gallery and close'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
