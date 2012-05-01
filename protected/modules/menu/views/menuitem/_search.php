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
        <?=$form->label($model, 'title')?>
        <?=$form->textField($model, 'title', array('size'=>60, 'maxlength'=>300))?>
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
        <?=$form->label($model, 'status')?>
        <?=$form->dropDownList($model, 'status', $model->getStatusList())?>
    </div>

    <div class="row buttons">
        <?=CHtml::submitButton(Yii::t('menu', 'Поиск'))?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->