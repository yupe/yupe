<?php
/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'htmlOptions' => array('class' => 'well search-form'),
    )
); ?>

<fieldset>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'status'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'to'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textAreaGroup($model, 'text'); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType'  => 'submit',
                'context'     => 'primary',
                'encodeLabel' => false,
                'label'       => '<i class="fa fa-search"></i> ' . Yii::t('SmsModule.sms', 'Find')
            )
        ); ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
