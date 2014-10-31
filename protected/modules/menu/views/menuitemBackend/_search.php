<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
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
                array(
                    'widgetOptions' => array(
                        'data'        => CHtml::listData(Menu::model()->findAll(), 'id', 'name'),
                        'htmlOptions' => array(
                            'empty' => '---',
                        ),
                    ),
                )
            );?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'status',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getStatusList(),
                        'htmlOptions' => array(
                            'empty' => '---',
                        ),
                    ),
                )
            );?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'parent_id',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getParentList(),
                        'htmlOptions' => array(
                            'empty' => '---',
                        ),
                    ),
                )
            );?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'condition_name',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getConditionList(),
                        'htmlOptions' => array(
                            'empty' => '---',
                        ),
                    ),
                )
            );?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'condition_denial',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getConditionDenialList(),
                        'htmlOptions' => array(
                            'empty' => '---',
                        ),
                    ),
                )
            );?>
        </div>
    </div>
</fieldset>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'context'     => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t(
                'MenuModule.menu',
                'Find menu item'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
