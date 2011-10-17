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
        <?php echo $form->textField($model, 'model', array('size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'model_id'); ?>
        <?php echo $form->textField($model, 'model_id', array('size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'creation_date'); ?>
        <?php echo $form->textField($model, 'creation_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'url'); ?>
        <?php echo $form->textField($model, 'url', array('size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'text'); ?>
        <?php echo $form->textArea($model, 'text', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'ip'); ?>
        <?php echo $form->textField($model, 'ip', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('comment', 'Поиск')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->