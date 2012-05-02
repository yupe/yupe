<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'page-form',
                                                         'enableAjaxValidation' => false,
                                                    )); ?>

    <p class="note"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>


    <div class="row">
        <?php echo $form->labelEx($model, 'parent_Id'); ?>
        <?php echo $form->dropDownList($model, 'parent_Id', $pages,array('empty' => Yii::t('page','--нет--'))); ?>
        <?php echo $form->error($model, 'parent_Id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'menu_order'); ?>
        <?php echo $form->textField($model, 'menu_order', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'menu_order'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'slug'); ?>
        <?php echo Yii::t('page', 'Оставьте пустым для автоматической генерации'); ?>
        <?php echo $form->textField($model, 'slug', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'slug'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'body'); ?>
        <?php $this->widget($this->module->editor, array(
                                                      'model' => $model,
                                                      'attribute' => 'body',
                                                      'options'   => array(                                                           
                                                           'toolbar' => 'main',
                                                           'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'                                                           
                                                       ),
                                                      'htmlOptions' => array('rows' => 20,'cols' => 6)
                                                 ))?>
        <?php echo $form->error($model, 'body'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'keywords'); ?>
        <?php echo $form->textField($model, 'keywords', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'keywords'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 3, 'cols' => 86)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'is_protected'); ?>
        <?php echo $form->checkBox($model, 'is_protected'); ?>
        <?php echo $form->error($model, 'is_protected'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('page', 'Добавить страницу и продолжить редактирование')
                                           : Yii::t('page', 'Сохранить и продолжить редактирование')); ?>
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('page', 'Добавить и закрыть')
                                           : Yii::t('page', 'Сохранить и закрыть'), array('name' => 'saveAndClose', 'id' => 'saveAndClose')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
