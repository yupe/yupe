<div class="wide form">

<?php
    $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    ));
?>

    <div class="row">
        <?=$form->label($model, 'id')?>
        <?=$form->textField($model, 'id', array('size'=>10, 'maxlength'=>10))?>
    </div>

    <div class="row">
        <?=$form->label($model, 'name')?>
        <?=$form->textField($model, 'name', array('size'=>60, 'maxlength'=>300))?>
    </div>

    <div class="row">
        <?=$form->label($model, 'code')?>
        <?=$form->textField($model, 'code', array('size'=>60, 'maxlength'=>100))?>
    </div>

    <div class="row">
        <?=$form->label($model,'description')?>
        <?=$form->textField($model, 'description', array('size'=>60, 'maxlength'=>300))?>
    </div>

    <div class="row">
        <?=$form->label($model, 'status')?>
        <?=$form->dropDownList($model, 'status', $model->getStatusList())?>
    </div>

    <div class="row buttons">
        <?=CHtml::submitButton(Yii::t('menu', 'Поиск'))?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->