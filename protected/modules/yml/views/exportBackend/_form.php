<?php
/**
 * @var $model Export
 * @var $form TbActiveForm
 */

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'export-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => ['class' => 'well'],
    ]
); ?>
<div class="alert alert-info">
    <?= Yii::t('YmlModule.default', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('YmlModule.default', 'are required'); ?>
</div>

<?= $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-6">
                <?= $form->textFieldGroup($model, 'shop_name'); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->textFieldGroup($model, 'shop_url'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->textFieldGroup($model, 'shop_company'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->textFieldGroup($model, 'shop_platform'); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->textFieldGroup($model, 'shop_version'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->textFieldGroup($model, 'shop_agency'); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->textFieldGroup($model, 'shop_email'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->checkboxGroup($model, 'shop_cpa'); ?>
            </div>
        </div>
    </div>
</div>

<div class='row'>
    <div class="col-sm-3">
        <?= CHtml::hiddenField('Export[brands]'); ?>
        <?= $form->dropDownListGroup(
            $model,
            'brands',
            [
                'widgetOptions' => [
                    'data' => Producer::model()->getFormattedList(),
                    'htmlOptions' => ['multiple' => true, 'size' => 10],
                ]
            ]
        ); ?>
    </div>
    <div class="col-sm-4">
        <?= CHtml::activeLabel($model, Yii::t('YmlModule.default', 'Categories')); ?>
        <?php $this->widget('store.widgets.CategoryTreeWidget', ['selectedCategories' => $model->categories, 'id' => 'category-tree']); ?>
        <?= CHtml::hiddenField('Export[categories]'); ?>
    </div>
</div>


<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('YmlModule.default', 'Add list and continue') : Yii::t('YmlModule.default', 'Save list and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('YmlModule.default', 'Add list and close') : Yii::t('YmlModule.default', 'Save list and close'),
    ]
); ?>

<?php $this->endWidget(); ?>

<?php Yii::app()->getClientScript()->registerScript(
    __FILE__,
    <<<JS
        $('#export-form').submit(function () {
        var form = $(this);
        $('#category-tree').find('a.jstree-clicked').each(function (index, element) {
            form.append('<input type="hidden" name="Export[categories][]" value="' + $(element).data('category-id') + '" />');
        });
    });
JS
);?>
