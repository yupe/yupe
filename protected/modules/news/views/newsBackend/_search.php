<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well form-vertical'),
    )
); ?>

<div class="row-fluid">
    <div class="span4">
        <?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 150)); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model, 'alias', array('size' => 60, 'maxlength' => 150)); ?>
    </div>
    <div class="span4">
        <?php echo $form->datepickerRow($model, 'date', array(
                'options' => array(
                    'format' => 'dd-mm-yyyy',
                    'weekStart' => 1,
                    'autoclose' => true,
                ),
                'htmlOptions' => array(
                    'class' => 'span11'
                ),
            ),
            array(
                'prepend' => '<i class="icon-calendar"></i>',
            ));
        ?>
    </div>
</div>

<div class="row-fluid">
    <div class="span4">
        <?php echo $form->dropDownListRow(
            $model,
            'category_id',
            CHtml::listData($this->module->categoryList, 'id', 'name'),
            array('empty' => Yii::t('NewsModule.news', '-no matter-'))
        ); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model, 'short_text', array('size' => 60, 'maxlength' => 400)); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model, 'full_text'); ?>
    </div>
</div>


<div class="row-fluid">
    <div class="span3">
        <?php echo $form->dropDownListRow(
            $model,
            'status',
            $model->getStatusList(),
            array('empty' => Yii::t('NewsModule.news', '- no matter -'))
        ); ?>
    </div>
</div>


<div class="row-fluid">
    <div class="span6">
        <?php echo $form->dropDownListRow($model, 'is_protected', $model->getProtectedStatusList(), array('empty' => '----')); ?>
    </div>
</div>




<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'type' => 'primary',
        'encodeLabel' => false,
        'buttonType' => 'submit',
        'label' => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('NewsModule.news', 'Find article'),
    )
); ?>

<?php $this->endWidget(); ?>
