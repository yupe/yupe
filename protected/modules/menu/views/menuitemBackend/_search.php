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
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'title'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'menu_id',
                [
                    'widgetOptions' => [
                        'data'        => CHtml::listData(Menu::model()->findAll(), 'id', 'name'),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            );?>
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
            );?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'parent_id',
                [
                    'widgetOptions' => [
                        'data'        => $model->getParentList(),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            );?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'condition_name',
                [
                    'widgetOptions' => [
                        'data'        => $model->getConditionList(),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            );?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'condition_denial',
                [
                    'widgetOptions' => [
                        'data'        => $model->getConditionDenialList(),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            );?>
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
                'MenuModule.menu',
                'Find menu item'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
