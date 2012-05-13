<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'menu-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <p class="note">
        <?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения'); ?>
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php
        echo $form->textField($model, 'name', array(
            'size' => 60,
            'maxlength' => 300,
        ));
        ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'code'); ?>
        <?php
        echo $form->textField($model, 'code', array(
            'size' => 60,
            'maxlength' => 100,
        ));
        ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php
        echo $form->textArea($model, 'description', array(
            'rows' => 12,
            'cols' => 60,
        ));
        ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('menu', 'Добавить меню') : Yii::t('menu', 'Сохранить меню')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->