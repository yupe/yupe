<?php
/**
 * @var $this CatalogBackendController
 * @var $model Category
 * @var $form \yupe\widgets\ActiveForm
 */
$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id'                     => 'category-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
); ?>

<div class="alert alert-info">
    <?= Yii::t('StoreModule.store', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('StoreModule.store', 'are required'); ?>
</div>

<?= $form->errorSummary($model); ?>


<div class='row'>
    <div class="col-sm-3">
        <?= $form->dropDownListGroup(
            $model,
            'parent_id',
            [
                'widgetOptions' => [
                    'data' => StoreCategoryHelper::formattedList(),
                    'htmlOptions' => [
                        'empty' => Yii::t('StoreModule.store', '--no--'),
                        'encode' => false,
                    ],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-4">
        <?= $form->dropDownListGroup(
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
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?= $form->slugFieldGroup($model, 'slug', ['sourceAttribute' => 'name']); ?>
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
        <?= $form->fileFieldGroup(
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
    <div class="col-sm-12 <?= $model->hasErrors('description') ? 'has-error' : ''; ?>">
        <?= $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'description',
            ]
        ); ?>
        <p class="help-block"></p>
        <?= $form->error($model, 'description'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-12 <?= $model->hasErrors('short_description') ? 'has-error' : ''; ?>">
        <?= $form->labelEx($model, 'short_description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'short_description',
            ]
        ); ?>
        <p class="help-block"></p>
        <?= $form->error($model, 'short_description'); ?>
    </div>
</div>

<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
<div class="panel-group" id="extended-options">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <a data-toggle="collapse" data-parent="#extended-options" href="#collapseOne">
                    <?= Yii::t('StoreModule.store', 'Data for SEO'); ?>
                </a>
            </div>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-7">
                        <?= $form->textFieldGroup($model, 'meta_title'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <?= $form->textFieldGroup($model, 'meta_keywords'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <?= $form->textAreaGroup($model, 'meta_description'); ?>
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
        'label'      => $model->isNewRecord ? Yii::t('StoreModule.store', 'Create category and continue') : Yii::t('StoreModule.store', 'Save category and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('StoreModule.store', 'Create category and close') : Yii::t('StoreModule.store', 'Save category and close'),
    ]
); ?>

<?php $this->endWidget(); ?>
