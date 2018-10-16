<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'htmlOptions' => ['class' => 'well search-form'],
    ]
);
?>
<fieldset>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->dropDownListGroup(
                $model,
                'type',
                ['widgetOptions' => ['data' => $model->getTypes()]]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->textFieldGroup($model, 'name'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->textFieldGroup($model, 'code'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->textAreaGroup($model, 'content'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?php echo $form->textAreaGroup($model, 'description'); ?>
        </div>
    </div>
</fieldset>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'context'     => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t(
                'ContentBlockModule.contentblock',
                'Find block'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
