<div class="wide form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'action' => Yii::app()->createUrl($this->route),
                                                         'method' => 'get',
                                                    )); ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id', array('size' => 10, 'maxlength' => 10)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'user_id'); ?>
        <?php echo $form->textField($model, 'user_id', array('size' => 10, 'maxlength' => 10)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'identity_id'); ?>
        <?php echo $form->textField($model, 'identity_id', array('size' => 10, 'maxlength' => 10)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'type'); ?>
        <?php echo $form->textField($model, 'type', array('size' => 50, 'maxlength' => 50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'creation_date'); ?>
        <?php echo $form->textField($model, 'creation_date'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('user', 'Поиск')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->