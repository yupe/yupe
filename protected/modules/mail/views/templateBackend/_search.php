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
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'name'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'code'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'event_id',
                [
                    'widgetOptions' => [
                        'data'        => CHtml::listData(MailEvent::model()->findAll(), 'id', 'name'),
                        'htmlOptions' => ['empty' => '---'],
                    ],
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'description'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'from'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'to'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'theme'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'body'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'status',
                [
                    'widgetOptions' => [
                        'data'        => $model->getStatusList(),
                        'htmlOptions' => ['empty' => '---'],
                    ],
                ]
            ); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType'  => 'submit',
                'context'     => 'primary',
                'encodeLabel' => false,
                'label'       => '<i class="fa fa-search"></i> ' . Yii::t('MailModule.mail', 'Find')
            ]
        );
        ?>
    </div>
</fieldset>

<?php $this->endWidget(); ?>
