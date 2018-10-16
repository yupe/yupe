<script type='text/javascript'>
    $(document).ready(function () {
        $('#attribute-form').liTranslit({
            elName: '#Attribute_title',
            elAlias:'#Attribute_name'
        });
    })
</script>


<?php
  Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('store')->getAssetsUrl() . '/js/jquery-sortable.js');
?>

<?php
/**
 * @var $model Attribute
 */

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'attribute-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => ['class' => 'well'],
    ]
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('StoreModule.store', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('StoreModule.store', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'group_id',
            [
                'widgetOptions' => [
                    'data' => AttributeGroup::model()->getFormattedList(),
                    'htmlOptions' => [
                        'empty' => '---',
                    ],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->dropDownListGroup(
            $model,
            'type',
            [
                'widgetOptions' => [
                    'data' => $model->getTypesList(),
                    'htmlOptions' => [
                        'empty' => '---',
                        'id' => 'attribute-type',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>


<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'title'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'unit'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->checkBoxGroup($model, 'required'); ?>
    </div>
</div>


<div class="row">
    <div id="options" class="<?php echo !in_array($model->type, Attribute::getTypesWithOptions()) ? 'hidden' : ''; ?> col-sm-5">
        <div class="row form-group">
            <div class="col-sm-12">
                <?php echo Yii::t("StoreModule.attr", "Each option value must be on a new line."); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo CHtml::activeTextArea($model, 'rawOptions', ['rows' => 10, 'class' => 'form-control']); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#attribute-type').change(function () {
            if ($.inArray(parseInt($(this).val()), [<?php echo join(',', Attribute::getTypesWithOptions());?>]) >= 0) {
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
        'context' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('StoreModule.attr', 'Add attribute and continue') : Yii::t('StoreModule.attr', 'Save attribute and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->isNewRecord ? Yii::t('StoreModule.attr', 'Add attribute and close') : Yii::t('StoreModule.attr', 'Save attribute and close'),
    ]
); ?>

<?php $this->endWidget(); ?>
