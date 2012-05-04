<?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
                                                         'id' => 'page-form',
                                                         'enableAjaxValidation' => false,
                                                         'htmlOptions'=> array( 'class' => 'well' ),
                                                    )); ?>
    <fieldset class="inline">
    <div class="alert alert-info"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></div>

    <?php
        if ( $model-> hasErrors() )
            echo $form->errorSummary($model);
     ?>

        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->labelEx($model, 'parent_Id' ); ?>
                <?php echo $form->dropDownList($model, 'parent_Id', $pages); ?>
            </div>
            <div class="span2">
                <?php echo $form->labelEx($model, 'status' ); ?>
                <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
            </div>
            <div class="span2">
                <?php echo $form->labelEx($model, 'menu_order' ); ?>
                <?php echo $form->textField($model, 'menu_order', array('size' => 10, 'maxlength' => 10)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'menu_order'); ?>
            </div>
        </div>
        <div class="row-fluid control-group  <?php echo $model-> hasErrors('name')?'error':'' ?>">
            <div class="span7">
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150,)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('title')?'error':'' ?>">
            <div class="span7">
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('slug')?'error':'' ?>">
            <div class="span7">
                <?php echo $form->labelEx($model, 'slug'); ?>
                <?php echo $form->textField($model, 'slug', array('size' => 60, 'maxlength' => 150,'placeholder'=>  Yii::t('page', 'Оставьте пустым для автоматической генерации') )); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'slug'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('body')?'error':'' ?>">
            <div class="span12">
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
                <br /><?php echo $form->error($model, 'body'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('keywords')?'error':'' ?>">
            <div class="span7">
                <?php echo $form->labelEx($model, 'keywords'); ?>
                <?php echo $form->textField($model, 'keywords', array('size' => 60, 'maxlength' => 150,'class'=>'span7')); ?>
             </div>
            <div class="span5">
                <?php echo $form->error($model, 'keywords'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('description')?'error':'' ?>">
            <div class="span7">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php echo $form->textArea($model, 'description', array('rows' => 3, 'cols' => 98)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('is_protected')?'error':'' ?>">
            <div class="span7">
                <label for="Page_is_protected" class="checkbox">
                    <?php echo $form->checkBox($model, 'is_protected'); ?>
                    <?php echo $model-> getAttributeLabel('is_protected'); ?>
                </label>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'is_protected'); ?>
            </div>
        </div>

<br />
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('page', 'Добавить страницу и продолжить редактирование')
                                           : Yii::t('page', 'Сохранить и продолжить редактирование'), array(
                                            'class' => 'btn btn-primary',
                                           )); ?>
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('page', 'Добавить и закрыть')
                                           : Yii::t('page', 'Сохранить и закрыть'), array('name' => 'saveAndClose', 'id' => 'saveAndClose', 'class' => 'btn btn-info')); ?>
    </fieldset>
    <?php $this->endWidget(); ?>
