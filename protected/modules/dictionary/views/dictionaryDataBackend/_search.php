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

<fieldset class="inline">
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'group_id',
                [
                    'widgetOptions' => [
                        'data' => CHtml::listData(
                                DictionaryGroup::model()->findAll(),
                                'id',
                                'name'
                            )
                    ]
                ]
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'name'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'code'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'description'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'status',
                [
                    'widgetOptions' => [
                        'data'        => $model->getStatusList(),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            ); ?>
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
                'Fund dictionary item'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
