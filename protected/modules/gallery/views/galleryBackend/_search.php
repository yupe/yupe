<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'vertical',
        'htmlOptions' => ['class' => 'well'],
    ]
); ?>
<fieldset>
    <div class="row">
        <div class="col-sm-5">
            <?= $form->textFieldGroup($model, 'name'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?= $form->textAreaGroup($model, 'description'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?= $form->dropDownListGroup(
                $model,
                'status',
                [
                    'widgetOptions' => [
                        'data' => $model->getStatusList(),
                    ],
                ]
            ); ?>
        </div>
    </div>
</fieldset>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'context' => 'primary',
        'encodeLabel' => false,
        'buttonType' => 'submit',
        'label' => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t(
                'GalleryModule.gallery',
                'Find gallery'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
