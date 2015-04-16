<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => [
            'class' => 'well',
        ],
    ]
); ?>

<div class="row">
    <div class="col-sm-3">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
    <div class="col-sm-3">
        <?php echo $form->textFieldGroup($model, 'email'); ?>
    </div>
    <div class="col-sm-3">
        <?php echo $form->textFieldGroup($model, 'phone'); ?>
    </div>
    <div class="col-sm-3">
        <?php echo $form->textFieldGroup($model, 'theme'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
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
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'category_id',
            [
                'widgetOptions' => [
                    'data'        => Category::model()->getFormattedList(
                            (int)Yii::app()->getModule('feedback')->mainCategory
                        ),
                    'htmlOptions' => [
                        'empty' => '---',
                    ],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-3">
        <?php echo $form->datePickerGroup(
            $model,
            'create_time',
            [
                'widgetOptions' => [
                    'options' => [
                        'format'    => 'yyyy-mm-dd',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ],
                ],
                'prepend'       => '<i class="fa fa-calendar"></i>',
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->checkBoxGroup($model, 'is_faq', $model->isFaqList); ?>
    </div>
</div>
<div class='row hidden'>
    <div class="col-sm-12">
        <?php $this->widget(
            'application.modules.yupe.widgets.editors.imperaviRedactor.ImperaviRedactorWidget',
            [
                'model'     => $model,
                'attribute' => 'answer',
            ]
        ); ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'context'     => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="fa fa-search">&nbsp;</i>' . Yii::t(
                'FeedbackModule.feedback',
                'Find messages '
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
