<?php
/**
 * @var TbActiveForm $form
 * @var ShopOrder $model
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'shoporder-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well', 'enctype' => 'multipart/form-data'),
        'inlineErrors' => true,
    )
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('ShopModule.shop', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('ShopModule.shop', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid control-group">
    <div class="span4"><?=$form->textFieldRow($model, 'recipient');?></div>
    <div class="span4"><?=$form->textFieldRow($model, 'phone');?></div>
    <div class="span4"><?=$form->textFieldRow($model, 'formattedPrice', array('disabled' => true));?></div>
</div>

<div class="row-fluid control-group">
    <div class="span8">
        <?=$form->textAreaRow($model, 'address', array('class'=> 'span12', 'rows'=>5))?>
    </div>
</div>

<div>
    <h3>Товары:</h3>
    <ul>
        <?php
        foreach($model->goods as $good){
            echo '<li>' . $good->name . ', ' . Yii::app()->numberFormatter->formatCurrency($good->price, 'RUR') . '</li>';
        }
        ?>
    </ul>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Сохранить',
    )
); ?>

<?php $this->endWidget(); ?>
