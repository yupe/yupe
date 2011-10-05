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
        <?php echo $form->label($model, 'firstName'); ?>
        <?php echo $form->textField($model, 'firstName', array('size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'lastName'); ?>
        <?php echo $form->textField($model, 'lastName', array('size' => 60, 'maxlength' => 150)); ?>
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
        <?php echo $form->label($model, 'accessLevel'); ?>
        <?php echo $form->dropDownList($model, 'accessLevel', $model->getAccessLevelsList()); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'lastVisit'); ?>
        <?php echo $form->textField($model, 'lastVisit'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'registrationDate'); ?>
        <?php echo $form->textField($model, 'registrationDate'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'registrationIp'); ?>
        <?php echo $form->textField($model, 'registrationIp', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'activationIp'); ?>
        <?php echo $form->textField($model, 'activationIp', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('user', 'Искать')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->