<?php
/**
 * @var TbActiveForm $form
 * @var ShopOrder $model
 */
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
        <?php echo $form->numberFieldRow($model, 'id'); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model, 'recipient', array('size' => 60, 'maxlength' => 150)); ?>
    </div>
    <div class="span4">
        <?php echo $form->datepickerRow($model, 'create_time', array(
                'options' => array(
                    'format' => 'dd.mm.yyyy',
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
    <div class="span6">
        <?php echo $form->textAreaRow($model, 'address', array('class' => 'span12', 'rows' => 5)); ?>
    </div>
    <div class="span3">
        <?=$form->textFieldRow($model, 'phone');?>
        <?=$form->textFieldRow($model, 'price');?>
    </div>
</div>


<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'type' => 'primary',
        'encodeLabel' => false,
        'buttonType' => 'submit',
        'label' => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('ShopModule.shop', 'Find order'),
    )
); ?>

<?php $this->endWidget(); ?>
