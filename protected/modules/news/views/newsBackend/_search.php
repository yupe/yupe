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

<div class="row">
    <div class="col-sm-4">
        <?php echo $form->textFieldGroup($model, 'title'); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldGroup($model, 'slug'); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->datePickerGroup(
            $model,
            'date',
            [
                'widgetOptions' => [
                    'options' => [
                        'format' => 'dd-mm-yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ],
                ],
                'prepend' => '<i class="fa fa-calendar"></i>',
            ]
        );
        ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <?php echo $form->dropDownListGroup(
            $model,
            'category_id',
            [
                'widgetOptions' => [
                    'data' => CHtml::listData($this->module->categoryList, 'id', 'name'),
                    'htmlOptions' => [
                        'empty' => Yii::t('NewsModule.news', '-no matter-'),
                    ],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldGroup($model, 'short_text'); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldGroup($model, 'full_text'); ?>
    </div>
</div>


<div class="row">
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data' => $model->getStatusList(),
                    'htmlOptions' => [
                        'empty' => Yii::t('NewsModule.news', '-no matter-'),
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'is_protected',
            [
                'widgetOptions' => [
                    'data' => $model->getProtectedStatusList(),
                    'htmlOptions' => [
                        'empty' => '---',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'context' => 'primary',
        'encodeLabel' => false,
        'buttonType' => 'submit',
        'label' => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t(
                'NewsModule.news',
                'Find article'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
