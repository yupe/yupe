<div class="wide form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'action' => Yii::app()->createUrl($this->route),
                                                         'method' => 'get',
                                                    )); ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'creation_date'); ?>
        <?php echo $form->textField($model, 'creation_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'nickName'); ?>
        <?php echo $form->textField($model, 'nickName', array('size' => 60, 'maxlength' => 100)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'salt'); ?>
        <?php echo $form->textField($model, 'salt', array('size' => 32, 'maxlength' => 32)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'code'); ?>
        <?php echo $form->textField($model, 'code', array('size' => 32, 'maxlength' => 32)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('user', 'Искать')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->