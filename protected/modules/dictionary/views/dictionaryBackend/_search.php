<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => ['class' => 'well'],
    ]
); ?>

<fieldset>
    <div class="row">
        <div class="col-sm-4">
            <?php echo $form->textFieldGroup($model, 'name'); ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->textFieldGroup($model, 'code'); ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->textFieldGroup($model, 'description'); ?>
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
                'DictionaryModule.dictionary',
                'Find dictionary'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
