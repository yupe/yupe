<?php
/**
 * @var $this AttributeBackendController
 * @var $model Attribute
 * @var $form \yupe\widgets\ActiveForm
 */
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('store')->getAssetsUrl() . '/js/jquery-sortable.js');
?>

<?php
/**
 * @var $model Attribute
 */

$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id'                     => 'attribute-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => ['class' => 'well'],
    ]
); ?>
<div class="alert alert-info">
    <?= Yii::t('StoreModule.store', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('StoreModule.store', 'are required'); ?>
</div>

<?= $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-4">
        <?= $form->dropDownListGroup(
            $model,
            'type',
            [
                'widgetOptions' => [
                    'data'        => $model->getTypesList(),
                    'htmlOptions' => [
                        'empty' => '---',
                        'id'    => 'attribute-type',
                    ],
                ],
            ]
        ); ?>
    </div>

    <div class="col-sm-3">
        <?= $form->dropDownListGroup(
            $model,
            'group_id',
            [
                'widgetOptions' => [
                    'data'        => AttributeGroup::model()->getFormattedList(),
                    'htmlOptions' => [
                        'empty' => '---',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>


<div class='row'>
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'title'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?= $form->slugFieldGroup($model, 'name', ['sourceAttribute' => 'title']); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'unit'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?= $form->checkBoxGroup($model, 'required'); ?>
    </div>
</div>


<div class="row">
    <div id="options" class="<?= !in_array($model->type, Attribute::getTypesWithOptions()) ? 'hidden' : ''; ?> col-sm-5">
        <div class="row form-group">
            <div class="col-sm-12">
                <?= Yii::t("StoreModule.store", "Each option value must be on a new line."); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= CHtml::activeTextArea($model, 'rawOptions', ['rows' => 10, 'class' => 'form-control', 'value' => $model->getRawOptions()]); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#attribute-type').change(function () {
            if ($.inArray(parseInt($(this).val()), [<?= join(',', Attribute::getTypesWithOptions());?>]) >= 0) {
                $('#options').removeClass('hidden');
            }
            else {
                $('#options').addClass('hidden');
            }
        });
    });
</script>

<br/><br/>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('StoreModule.store', 'Add attribute and continue') : Yii::t('StoreModule.store', 'Save attribute and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('StoreModule.store', 'Add attribute and close') : Yii::t('StoreModule.store', 'Save attribute and close'),
    ]
); ?>

<?php $this->endWidget(); ?>
