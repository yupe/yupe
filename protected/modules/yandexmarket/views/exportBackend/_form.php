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
    <?php echo Yii::t('YandexMarketModule.default', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('YandexMarketModule.default', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-3">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-12">
                <?php echo $form->textFieldGroup($model, 'shop_name'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo $form->textFieldGroup($model, 'shop_company'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo $form->textFieldGroup($model, 'shop_url'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo $form->textFieldGroup($model, 'shop_platform'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo $form->textFieldGroup($model, 'shop_version'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo $form->textFieldGroup($model, 'shop_agency'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo $form->textFieldGroup($model, 'shop_email'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo $form->checkboxGroup($model, 'shop_cpa'); ?>
            </div>
        </div>
    </div>
</div>

<div class='row'>
    <div class="col-sm-3">
        <?php echo CHtml::hiddenField('Export[brands]'); ?>
        <?php echo $form->dropDownListGroup(
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
        <?php echo CHtml::activeLabel($model, Yii::t('YandexMarketModule.default', 'Categories')); ?>
        <?php $this->widget('store.widgets.CategoryTreeWidget', ['selectedCategories' => $model->categories, 'id' => 'category-tree']); ?>
        <?php echo CHtml::hiddenField('Export[categories]'); ?>
    </div>
</div>


<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('YandexMarketModule.default', 'Add list and close') : Yii::t('YandexMarketModule.default', 'Save list and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('YandexMarketModule.default', 'Add list and close') : Yii::t('YandexMarketModule.default', 'Save list and close'),
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
