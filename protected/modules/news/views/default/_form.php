<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'news-form',
                                                         'enableAjaxValidation' => false,
                                                    )); ?>

    <p class="note"><?php echo Yii::t('news', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                   'model' => $model,
                                                                   'attribute' => 'date',
                                                                   'options' => array(
                                                                       'dateFormat' => 'dd.mm.yy',
                                                                   ),
                                                              ));
        ?>
        <?php echo $form->error($model, 'date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'alias'); ?>
        <?php echo Yii::t('news', 'Оставьте пустым для автоматической генерации'); ?><br/>
        <?php echo $form->textField($model, 'alias', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'alias'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'short_text'); ?>
        <?php $this->widget($this->module->editor, array(
                                                      'model' => $model,
                                                      'attribute' => 'short_text',
                                                      'options'   => array(                                                           
                                                           'toolbar' => 'main',
                                                           'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'                                                           
                                                       ),
                                                      'htmlOptions' => array('rows' => 20,'cols' => 6)
                                                 ))?>
        <?php echo $form->error($model, 'short_text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'full_text'); ?>
        <?php $this->widget($this->module->editor, array(
                                                      'model' => $model,
                                                      'attribute' => 'full_text',
                                                      'options'   => array(                                                           
                                                           'toolbar' => 'main',
                                                           'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'                                                           
                                                       ),
                                                      'htmlOptions' => array('rows' => 20,'cols' => 6)
                                                 ))?>
        <?php echo $form->error($model, 'full_text'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model, 'keywords'); ?>
        <?php echo $form->textField($model, 'keywords', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'keywords'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 86)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'is_protected'); ?>
        <?php echo $form->checkBox($model, 'is_protected', $model->getProtectedStatusList()); ?>
        <?php echo $form->error($model, 'is_protected'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('news', 'Добавить новость')
                                           : Yii::t('news', 'Сохранить изменения')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
