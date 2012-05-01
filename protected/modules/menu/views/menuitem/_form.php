<div class="form">

<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'menuitem-form',
        'enableAjaxValidation'=>false,
    ));
?>
    <p class="note"><?=Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?=$form->errorSummary($model)?>

    <div class="row">
        <?=$form->labelEx($model, 'title')?>
        <?=$form->textField($model, 'title', array('size'=>60, 'maxlength'=>300))?>
        <?=$form->error($model, 'title')?>
    </div>

    <div class="row">
        <?=$form->labelEx($model, 'href')?>
        <?=$form->textField($model, 'href', array('size'=>60, 'maxlength'=>300))?>
        <?=$form->error($model, 'href')?>
    </div>

    <div class="row">
        <?=$form->labelEx($model, 'menu_id')?>
        <?=$form->dropDownList($model, 'menu_id',
            CHtml::listData(Menu::model()->findAll(), 'id', 'name'),
            array('empty'=>Yii::t('menu', 'выберите меню'))
        )?>
        <?=$form->error($model, 'menu_id')?>
    </div>

    <div class="row">
        <?=$form->labelEx($model, 'parent_id')?>
        <?=$form->dropDownList($model, 'parent_id',
            // :KLUDGE: Обратить внимание, возможно сделать иначе определение корня
            array(0=>'корень меню') + CHtml::listData(MenuItem::model()->findAll(), 'id', 'title')
        )?>
        <?=$form->error($model, 'parent_id')?>
    </div>

    <div class="row">
        <?=$form->labelEx($model, 'type')?>
        <?=$form->textField($model, 'type', array('size'=>60, 'maxlength'=>300))?>
        <?=$form->error($model, 'type')?>
    </div>

    <div class="row">
        <?=$form->labelEx($model, 'sort')?>
        <?=$form->textField($model, 'sort', array('size'=>60, 'maxlength'=>300))?>
        <?=$form->error($model, 'sort')?>
    </div>

    <div class="row">
        <?=$form->labelEx($model, 'status')?>
        <?=$form->dropDownList($model, 'status', $model->getStatusList())?>
        <?=$form->error($model, 'status')?>
    </div>

    <div class="row buttons">
        <?=CHtml::submitButton(
            $model->isNewRecord 
                ? Yii::t('menu', 'Добавить пункт меню') 
                : Yii::t('menu', 'Сохранить пункт меню')
        )?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->