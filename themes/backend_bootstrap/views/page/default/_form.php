<?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'page-form',
                                                         'enableAjaxValidation' => false,
                                                         'htmlOptions'=> array( 'class' => 'well' ),
                                                    )); ?>

    <div class="alert alert-info"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></div>

    <?php
        if ( $model-> hasErrors() )
            echo "<div class='alert alert-error'>".$form->errorSummary($model)."</div>";
     ?>

        <div class="control-gorup row">
        <?php echo $form->labelEx($model, 'parent_Id', array( 'class' => 'span3', ) ); ?>
        <?php echo $form->labelEx($model, 'status', array( 'class' => 'span2', ) ); ?>
        <?php echo $form->labelEx($model, 'menu_order', array( 'class' => 'span2',) ); ?>
        </div>

        <div class="row">
            <div class="span3"><?php echo $form->dropDownList($model, 'parent_Id', $pages); ?></div>
            <div class="span2"><?php echo $form->dropDownList($model, 'status', $model->getStatusList(), array('class' => 'span2')); ?></div>
            <div class="span2"><?php echo $form->textField($model, 'menu_order', array('size' => 10, 'maxlength' => 10, 'class' => 'span2')); ?></div>
            <span class="help-inline"><?php echo $form->error($model, 'menu_order'); ?></span>
        </div>
        <br />
        <div class="control-group <?php echo $model-> hasErrors('name')?'error':'' ?>">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150, 'class'=> 'input-xxlarge ')); ?>
            <span class="help-inline"><?php echo $form->error($model, 'name'); ?></span>
        </div>

        <div class="control-group <?php echo $model-> hasErrors('title')?'error':'' ?>">
            <?php echo $form->labelEx($model, 'title'); ?>
            <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 150, 'class'=> 'input-xxlarge')); ?>
            <span class="help-inline"><?php echo $form->error($model, 'title'); ?></span>
        </div>

        <div class="control-group <?php echo $model-> hasErrors('slug')?'error':'' ?>">
            <?php echo $form->labelEx($model, 'slug'); ?>
            <?php echo $form->textField($model, 'slug', array('size' => 60, 'maxlength' => 150,'placeholder'=>  Yii::t('page', 'Оставьте пустым для автоматической генерации'),'class'=>'input-xxlarge' )); ?>
            <span class="help-inline"><?php echo $form->error($model, 'slug'); ?></span>
        </div>

        <div class="control-group <?php echo $model-> hasErrors('body')?'error':'' ?>">
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

            <span class="help-inline"><?php echo $form->error($model, 'body'); ?></span>
        </div>

        <div class="control-group <?php echo $model-> hasErrors('keywords')?'error':'' ?>">
            <?php echo $form->labelEx($model, 'keywords'); ?>
            <?php echo $form->textField($model, 'keywords', array('size' => 60, 'maxlength' => 150,'class'=>'input-xxlarge')); ?>
            <span class="help-inline"><?php echo $form->error($model, 'keywords'); ?></span>
        </div>

        <div class="control-group <?php echo $model-> hasErrors('description')?'error':'' ?>">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->textArea($model, 'description', array('rows' => 3, 'cols' => 98,'class'=>'input-xxlarge')); ?>
            <span class="help-inline"><?php echo $form->error($model, 'description'); ?></span>
        </div>

        <br />
        <label for="Page_is_protected" class="checkbox">
            <?php echo $form->checkBox($model, 'is_protected'); ?>
            <?php echo $model-> getAttributeLabel('is_protected'); ?>
        </label>

        <?php echo $form->error($model, 'is_protected'); ?>

<br />
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('page', 'Добавить страницу и продолжить редактирование')
                                           : Yii::t('page', 'Сохранить и продолжить редактирование'), array(
                                            'class' => 'btn btn-primary',
                                           )); ?>
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('page', 'Добавить и закрыть')
                                           : Yii::t('page', 'Сохранить и закрыть'), array('name' => 'saveAndClose', 'id' => 'saveAndClose', 'class' => 'btn btn-info')); ?>

    <?php $this->endWidget(); ?>
