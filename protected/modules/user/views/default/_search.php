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
        <?php echo $form->label($model, 'change_date'); ?>
        <?php echo $form->textField($model, 'change_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'first_name'); ?>
        <?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'last_name'); ?>
        <?php echo $form->textField($model, 'last_name', array('size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'nick_name'); ?>
        <?php echo $form->textField($model, 'nick_name', array('size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'gender'); ?>
        <?php echo $form->dropDownList($model, 'gender', $model->getGendersList()); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'access_level'); ?>
        <?php echo $form->dropDownList($model, 'access_level', $model->getAccessLevelsList()); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'last_visit'); ?>
        <?php echo $form->textField($model, 'last_visit'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'registration_date'); ?>
        <?php echo $form->textField($model, 'registration_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'registration_ip'); ?>
        <?php echo $form->textField($model, 'registration_ip', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'activation_ip'); ?>
        <?php echo $form->textField($model, 'activation_ip', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('user', 'Искать')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->