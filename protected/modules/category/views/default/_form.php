<div class="form">

<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'category-form',
        'enableAjaxValidation'=>false,
    ));
?>

    <p class="note"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения'); ?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'parent_id'); ?>
        <?php echo $form->dropDownList($model, 'parent_id', $categoryes); ?>
        <?php echo $form->error($model, 'parent_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size'=>60, 'maxlength'=>150)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'alias'); ?>
        <?php echo $form->textField($model, 'alias', array('size'=>50, 'maxlength'=>50)); ?>
        <?php echo $form->error($model, 'alias'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php
            $this->widget(Yii::app()->getModule('yupe')->editor, array(
                'model'=>$model,
                'attribute'=>'description',
                'options'=>array(
                    'toolbar'=>'main',
                    'imageUpload'=>Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/',
                ),
                'htmlOptions'=>array('rows'=>20, 'cols'=>6),
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
        <?php
            echo CHtml::submitButton(
                $model->isNewRecord
                    ? Yii::t('category', 'Добавить категорию')
                    : Yii::t('category', 'Сохранить измнения')
            );
        ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->