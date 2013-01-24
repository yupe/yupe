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
        <?php echo $form->label($model, 'model'); ?>
        <?php echo $form->textField($model, 'model', array('size' => 50, 'maxlength' => 50)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'model_id'); ?>
        <?php echo $form->textField($model, 'model_id', array('size' => 10, 'maxlength' => 10)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'user_id'); ?>
        <?php echo $form->textField($model, 'user_id', array('size' => 10, 'maxlength' => 10)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'creation_date'); ?>
        <?php echo $form->textField($model, 'creation_date'); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'value'); ?>
        <?php echo $form->textField($model, 'value'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->