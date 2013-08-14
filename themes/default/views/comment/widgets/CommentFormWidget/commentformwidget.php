<script type='text/javascript'>
    var errorMessage = '<?php echo Yii::t("CommentModule.comment", "При добавлении комментария возникла ошибка, повторите попытку позже.")?>';
</script>
<a href='#' id='wcml' style="display: none;">НАПИСАТЬ КОММЕНТАРИЙ</a>
<br/>
<div id='comment-form-wrap' class='comment-form-wrap'>
<div class="form">
<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => '/comment/comment/add/',
        'id' => 'comment-form',
        'type' => 'vertical',
        'inlineErrors' => true,
        'htmlOptions' => array(
            'class' => 'well',
        )
    )
); ?>

    <p class="note">
        <?php echo Yii::t('CommentModule.comment', 'Поля, отмеченные'); ?>
        <span class="required">*</span> 
        <?php echo Yii::t('CommentModule.comment', 'обязательны для заполнения'); ?>
    </p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->hiddenField($model, 'model'); ?>
    <?php echo $form->hiddenField($model, 'model_id'); ?>
    <?php echo $form->hiddenField($model, 'parent_id'); ?>
    <?php echo CHtml::hiddenField('redirectTo', $redirectTo); ?>

    <?php if (!Yii::app()->user->isAuthenticated()) : ?>
        <div class='row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>'>
            <?php echo $form->textFieldRow($model, 'name', array('class' => 'span6', 'required' => true)); ?>
        </div>

        <div class='row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>'>
            <?php echo $form->textFieldRow($model, 'email', array('class' => 'span6', 'required' => true)); ?>
        </div>

        <div class='row-fluid control-group <?php echo $model->hasErrors('url') ? 'error' : ''; ?>'>
            <?php echo $form->textFieldRow($model, 'url', array('class' => 'span6')); ?>
        </div>

    <?php else: ?>
        <p><?php echo Yii::t('CommentModule.comment', 'От имени'); ?>: <?php echo Yii::app()->user->getState('nick_name'); ?></p>
    <?php endif; ?>

    <div class='row-fluid control-group <?php echo $model->hasErrors('text') ? 'error' : ''; ?>'>
        <?php echo $form->textAreaRow($model, 'text', array('class' => 'span12', 'required' => true,'rows' => 7, 'cols' => 50)); ?>
    </div>

    <?php if ($module->showCaptcha && !Yii::app()->user->isAuthenticated()): ?>
        <?php if(CCaptcha::checkRequirements()) : ?>
                <?php echo $form->labelEx($model, 'verifyCode'); ?>

                <?php
                $this->widget(
                    'CCaptcha', array(
                        'showRefreshButton' => true,
                        'clickableImage' => true,
                        'buttonLabel' => 'обновить',
                        'buttonOptions' => array('class' => 'captcha-refresh-link'),
                        'captchaAction' => '/comment/comment/captcha'
                    )
                ); ?>

                <div class='row-fluid control-group <?php echo $model->hasErrors('verifyCode') ? 'error' : ''; ?>'>
                    <?php echo $form->textFieldRow($model, 'verifyCode', array('placeholder' => 'Введите цифры указанные на картинке','class' => 'span6', 'required' => true)); ?>
                </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="row-fluid  control-group">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'icon' => 'comment',
                'label' => Yii::t('comment', 'Добавить комментарий'),
            )
        ); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->
</div>