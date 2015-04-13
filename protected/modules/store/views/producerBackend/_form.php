<?php
/**
 * @var $this ProducerBackendController
 * @var $model Producer
 * @var $form \yupe\widgets\ActiveForm
 */
$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id'                     => 'producer-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
);
?>

<div class="alert alert-info">
    <?= Yii::t('StoreModule.store', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('StoreModule.store', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-2">
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

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name_short'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->slugFieldGroup($model, 'slug', ['sourceAttribute' => 'name_short']); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php
        echo CHtml::image(
            !$model->isNewRecord && $model->image ? $model->getImageUrl() : '#',
            $model->name,
            [
                'class' => 'preview-image img-thumbnail',
                'style' => !$model->isNewRecord && $model->image ? '' : 'display:none'
            ]
        ); ?>
        <?php echo $form->fileFieldGroup(
            $model,
            'image',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'onchange' => 'readURL(this);',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-12 <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'description',
            ]
        ); ?>
        <p class="help-block"></p>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-12 <?php echo $model->hasErrors('short_description') ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($model, 'short_description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'short_description',
            ]
        ); ?>
        <p class="help-block"></p>
        <?php echo $form->error($model, 'short_description'); ?>
    </div>
</div>

<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
<div class="panel-group" id="extended-options">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <a data-toggle="collapse" data-parent="#extended-options" href="#collapseOne">
                    <?php echo Yii::t('StoreModule.store', 'Data for SEO'); ?>
                </a>
            </div>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-7">
                        <?php echo $form->textFieldGroup($model, 'meta_title'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <?php echo $form->textFieldGroup($model, 'meta_keywords'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <?php echo $form->textAreaGroup($model, 'meta_description'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->getIsNewRecord() ? Yii::t('StoreModule.producer', 'Add producer and continue') : Yii::t('StoreModule.producer', 'Save producer and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->getIsNewRecord() ? Yii::t('StoreModule.producer', 'Add producer and close') : Yii::t('StoreModule.producer', 'Save producer and close'),
    ]
); ?>

<?php $this->endWidget(); ?>
