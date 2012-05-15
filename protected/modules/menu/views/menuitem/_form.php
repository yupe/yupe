<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'menuitem-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <p class="note">
        <?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения'); ?>
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php
        echo $form->textField($model, 'title', array(
            'size' => 60,
            'maxlength' => 300,
        ));
        ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'href'); ?>
        <?php
        echo $form->textField($model, 'href', array(
            'size' => 60,
            'maxlength' => 300,
        ));
        ?>
        <?php echo $form->error($model, 'href'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'menu_id'); ?>
        <?php echo $form->dropDownList($model, 'menu_id', CHtml::listData(Menu::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('menu', 'выберите меню'))); ?>
        <?php echo $form->error($model, 'menu_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'parent_id'); ?>
        <?php echo $form->dropDownList($model, 'parent_id', $model->parentList); ?>
        <?php echo $form->error($model, 'parent_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'condition_name'); ?>
        <?php echo $form->dropDownList($model, 'condition_name', $model->conditionList); ?>
        <?php echo $form->error($model, 'condition_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'condition_denial'); ?>
        <?php echo $form->dropDownList($model, 'condition_denial', $model->conditionDenialList); ?>
        <?php echo $form->error($model, 'condition_denial'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'sort'); ?>
        <?php
        echo $form->textField($model, 'sort', array(
            'size' => 60,
            'maxlength' => 300,
        ));
        ?>
        <?php echo $form->error($model, 'sort'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('menu', 'Добавить пункт меню') : Yii::t('menu', 'Сохранить пункт меню')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->