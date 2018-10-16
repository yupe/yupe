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
        <div class="col-sm-5">
            <?=  $form->dropDownListGroup(
                $model,
                'category_id',
                [
                    'widgetOptions' => [
                        'data'        => Yii::app()->getComponent('categoriesRepository')->getFormattedList(),
                        'htmlOptions' => [
                            'empty'  => '---',
                            'encode' => false,
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?=  $form->textFieldGroup($model, 'name'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <?=  $form->textAreaGroup(
                $model,
                'description',
                ['widgetOptions' => ['htmlOptions' => ['rows' => 6]]]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?=  $form->textFieldGroup($model, 'alt'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?=  $form->dropDownListGroup(
                $model,
                'type',
                [
                    'widgetOptions' => [
                        'data'        => $model->getTypeList(),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?=  $form->dropDownListGroup(
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
                'ImageModule.image',
                'Find image'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
