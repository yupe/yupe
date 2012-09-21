<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'feed-back-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array( 'class' => 'well form-vertical' ),
    ));
?>
<fieldset class="inline">

    <div class="alert alert-info">
        <?php echo Yii::t('blog', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('blog', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group  <?php echo $model->hasErrors('type') ? 'error' : ''; ?>">
        <div class="span7">
            <?php echo $form->labelEx($model, 'type'); ?>
            <?php echo $form->dropDownList($model, 'type', Yii::app()->getModule('feedback')->types, array( 'class' => 'span7' )); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'type'); ?>
        </div>
    </div>

    <div class="row-fluid control-group  <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
        <div class="span7">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array( 'size'      => 60, 'maxlength' => 100, 'class'     => 'span7' )); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'name'); ?>
        </div>
    </div>

    <div class="row-fluid control-group  <?php echo $model->hasErrors('email') ? 'error' : ''; ?>">
        <div class="span7">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email', array( 'size'      => 60, 'maxlength' => 100, 'class'     => 'span7' )); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'email'); ?>
        </div>
    </div>

    <div class="row-fluid control-group  <?php echo $model->hasErrors('phone') ? 'error' : ''; ?>">
        <div class="span7">
            <?php echo $form->labelEx($model, 'phone'); ?>
            <?php echo $form->textField($model, 'phone', array( 'size'      => 60, 'maxlength' => 100, 'class'     => 'span7' )); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'phone'); ?>
        </div>
    </div>

    <div class="row-fluid control-group  <?php echo $model->hasErrors('theme') ? 'error' : ''; ?>">
        <div class="span7">
            <?php echo $form->labelEx($model, 'theme'); ?>
            <?php echo $form->textField($model, 'theme', array( 'size'      => 60, 'maxlength' => 150, 'class'     => 'span7' )); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'theme'); ?>
        </div>
    </div>

    <div class="row-fluid control-group  <?php echo $model->hasErrors('text') ? 'error' : ''; ?>">
        <div class="span7">
            <?php echo $form->labelEx($model, 'text'); ?>
            <?php
            $this->widget(Yii::app()->getModule('yupe')->editor, array(
                'model'     => $model,
                'attribute' => 'text',
                'options'   => array(
                    'toolbar'     => 'main',
                    'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxFileUpload/'
                ),
                'htmlOptions' => array( 'rows' => 20, 'cols' => 6 ),
            ));
            ?>
        </div>
        <div class="span5">
<?php echo $form->error($model, 'text'); ?>
        </div>
    </div>

    <div class="row-fluid control-group  <?php echo $model->hasErrors('status') ? 'error' : '' ?>">
        <div class="span7">
            <?php echo $form->labelEx($model, 'status'); ?>
<?php echo $form->dropDownList($model, 'status', $model->getStatusList(), array( 'class' => 'span7' )); ?>
        </div>
        <div class="span5">
<?php echo $form->error($model, 'status'); ?>
        </div>
    </div>

<?php if ($model->status == FeedBack::STATUS_ANSWER_SENDED): ?>
        <div class="row-fluid control-group">
            <div class="span7">
                <label><?php echo Yii::t('feedback', 'Ответил'); ?> <?php echo CHtml::link($model->getAnsweredUser(), array( '/user/default/view/', 'id' => $model->answer_user )); ?> (<?php echo $model->answer_date; ?>)</label>
    <?php echo $model->answer; ?>
            </div>
        </div>
    <?php endif; ?>

   <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('feedback', 'Добавить сообщение и продолжить') : Yii::t('feedback', 'Сохранить сообщение и продолжить'),
    )); ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
        'label'      => $model->isNewRecord ? Yii::t('feedback', 'Добавить сообщение и закрыть') : Yii::t('feedback', 'Сохранить сообщение и закрыть'),
    )); ?>
</fieldset>
<?php $this->endWidget(); ?>