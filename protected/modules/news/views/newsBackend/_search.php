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

<div class="row">
    <div class="col-sm-4">
        <?php echo $form->textFieldGroup($model, 'title'); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textFieldGroup($model, 'alias'); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->datePickerGroup(
            $model,
            'date',
            array(
                'widgetOptions' => array(
                    'options' => array(
                        'format'    => 'dd-mm-yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ),
                ),
                'prepend'       => '<i class="fa fa-calendar"></i>',
            )
        );
        ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <?php echo $form->dropDownListGroup(
            $model,
            'category_id',
            array(
                'widgetOptions' => array(
                    'data'        => CHtml::listData($this->module->categoryList, 'id', 'name'),
                    'htmlOptions' => array(
                        'empty' => Yii::t('NewsModule.news', '-no matter-'),
                    ),
                ),
            )
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
            array(
                'widgetOptions' => array(
                    'data'        => $model->getStatusList(),
                    'htmlOptions' => array(
                        'empty' => Yii::t('NewsModule.news', '-no matter-'),
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'is_protected',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getProtectedStatusList(),
                    'htmlOptions' => array(
                        'empty' => '---',
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'context'     => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t(
                'NewsModule.news',
                'Find article'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
