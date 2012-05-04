<div class="wide form">

    <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
        ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id', array('size'=>10, 'maxlength'=>10)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'parent_id'); ?>
        <?php echo $form->textField($model, 'parent_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size'=>60, 'maxlength'=>150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows'=>6, 'cols'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'alias'); ?>
        <?php echo $form->textField($model, 'alias', array('size'=>50, 'maxlength'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'status'); ?>
        <?php echo $form->textField($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('category', 'Поиск')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->