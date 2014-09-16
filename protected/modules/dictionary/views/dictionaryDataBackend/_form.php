<script type='text/javascript'>
    $(document).ready(function () {
        $('#dictionary-data-form').liTranslit({
            elName: '#DictionaryData_name',
            elAlias: '#DictionaryData_code'
        });
    })
</script>

<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'dictionary-data-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
    )
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('DictionaryModule.dictionary', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('DictionaryModule.dictionary', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'group_id',
            array(
                'widgetOptions' => array(
                    'data' => CHtml::listData(
                            DictionaryGroup::model()->findAll(),
                            'id',
                            'name'
                        )
                )
            )
        ); ?>

    </div>
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            array('widgetOptions' => array('data' => $model->getStatusList()))
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'code'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'value'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 form-group popover-help"
         data-original-title='<?php echo $model->getAttributeLabel('description'); ?>'
         data-content='<?php echo $model->getAttributeDescription('description'); ?>'>
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->yupe->getVisualEditor(),
            array(
                'model'     => $model,
                'attribute' => 'description',
            )
        ); ?>
    </div>
</div>


<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t(
                'DictionaryModule.dictionary',
                'Create item and continue'
            ) : Yii::t('DictionaryModule.dictionary', 'Save value and continue'),
    )
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('DictionaryModule.dictionary', 'Create item and close') : Yii::t(
                'DictionaryModule.dictionary',
                'Save value and close'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
