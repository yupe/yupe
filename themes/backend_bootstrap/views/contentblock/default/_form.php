<?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id' => 'content-block-form',
    'enableAjaxValidation' => false,
    'htmlOptions'=> array( 'class' => 'well' ),
)); ?>

    <fieldset class="inline">
        <div class="alert alert-info"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></div>
        <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model-> hasErrors('type')?'error':'' ?>">
        <div class="span7">
            <?php echo $form->dropDownListRow($model, 'type', $model->getTypes()); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'type'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model-> hasErrors('name')?'error':'' ?>">
        <div class="span7">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 50)); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'name'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model-> hasErrors('code')?'error':'' ?>">
        <div class="span7">
            <?php echo $form->labelEx($model, 'code'); ?>
            <?php echo $form->textField($model, 'code', array('size' => 50, 'maxlength' => 50)); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'code'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model-> hasErrors('content')?'error':'' ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'content'); ?>
            <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
            'model' => $model,
            'attribute' => 'content',
            'options' => array(
                'toolbar' => 'main',
                'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxFileUpload/'
            ),
            'htmlOptions' => array('rows' => 20, 'cols' => 6)
        ))?>
            <?php echo $form->error($model, 'content'); ?>
        </div>
    </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('description')?'error':'' ?>">
            <div class="span12">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                    'model' => $model,
                    'attribute' => 'description',
                    'options' => array(
                        'toolbar' => 'main',
                        'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxFileUpload/'
                    ),
                    'htmlOptions' => array('rows' => 20, 'cols' => 6)
                ))?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
    </div>

        <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('contentblock', 'Добавить блок') : Yii::t('contentblock', 'Сохранить изменения'),
    )); ?>
    </fieldset>
<?php $this->endWidget(); ?>