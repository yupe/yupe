<div class="form">

<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'menu-form',
        'enableAjaxValidation'=>false,
    ));
?>
    <p class="note"><?=Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?=$form->errorSummary($model)?>

    <div class="row">
        <?=$form->labelEx($model, 'name')?>
        <?=$form->textField($model, 'name', array('size'=>60, 'maxlength'=>300))?>
        <?=$form->error($model, 'name')?>
    </div>

    <div class="row">
        <?=$form->labelEx($model, 'code')?>
        <?=$form->textField($model, 'code', array('size'=>60, 'maxlength'=>100))?>
        <?=$form->error($model, 'code')?>
    </div>

    <div class="row">
        <?=$form->labelEx($model, 'description')?>
        <?=$form->textArea($model, 'description', array('rows'=>12, 'cols'=>60))?>
        <?=$form->error($model, 'description')?>
    </div>

    <div class="row">
        <?=$form->labelEx($model, 'status')?>
        <?=$form->dropDownList($model, 'status', $model->getStatusList())?>
        <?=$form->error($model, 'status')?>
    </div>

    <div class="row buttons">
        <?=CHtml::submitButton(
            $model->isNewRecord 
                ? Yii::t('menu', 'Добавить меню') 
                : Yii::t('menu', 'Сохранить меню')
        )?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->