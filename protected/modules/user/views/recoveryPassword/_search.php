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
        <?php echo $form->label($model, 'userId'); ?>
        <?php echo $form->textField($model, 'userId'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'creationDate'); ?>
        <?php echo $form->textField($model, 'creationDate'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'code'); ?>
        <?php echo $form->textField($model, 'code', array('size' => 32, 'maxlength' => 32)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('user', 'Поиск')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->