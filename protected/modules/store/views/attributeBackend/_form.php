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
    array(
        'id' => 'attribute-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'well'),
    )
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
            array(
                'widgetOptions' => array(
                    'data' => AttributeGroup::model()->getFormattedList(),
                    'htmlOptions' => array(
                        'empty' => '---',
                    ),
                ),
            )
        ); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->dropDownListGroup(
            $model,
            'type',
            array(
                'widgetOptions' => array(
                    'data' => $model->getTypesList(),
                    'htmlOptions' => array(
                        'empty' => '---',
                        'id' => 'attribute-type',
                    ),
                ),
            )
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
                <?php echo Yii::t("StoreModule.store", "Опции, каждое значение с новой строки"); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo CHtml::activeTextArea($model, 'rawOptions', array('rows' => 10, 'class' => 'form-control')); ?>
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
    array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('StoreModule.store', 'Добавить и продолжить') : Yii::t('StoreModule.store', 'Сохранить и продолжить'),
    )
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label' => $model->isNewRecord ? Yii::t('StoreModule.store', 'Добавить и вернуться к списку') : Yii::t('StoreModule.store', 'Сохранить и вернуться к списку'),
    )
); ?>

<?php $this->endWidget(); ?>
