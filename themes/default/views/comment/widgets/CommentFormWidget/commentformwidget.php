<?php Yii::import('application.modules.comment.CommentModule'); ?>
<script type='text/javascript'>
    var errorMessage = '<?php echo Yii::t("CommentModule.comment", 'There is an error when create comments, try again later.'); ?>';
</script>
<a href='#' id='wcml' style="display: none;"><?php echo Yii::t("CommentModule.comment", 'WRITE COMMENT'); ?></a>
<br/>
<div id='comment-form-wrap' class='comment-form-wrap'>
<div class="form">
<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl('/comment/add/'),
        'id' => 'comment-form',
        'type' => 'vertical',
        'inlineErrors' => true,
        'htmlOptions' => array(
            'class' => 'well',
        )
    )
); ?>

    <p class="note">
        <?php echo Yii::t('CommentModule.comment', 'Fields with'); ?>
        <span class="required">*</span> 
        <?php echo Yii::t('CommentModule.comment', 'are require.'); ?>
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
        <p><?php echo Yii::t('CommentModule.comment', 'From user'); ?>: <?php echo Yii::app()->user->getState('nick_name'); ?></p>
    <?php endif; ?>

    <div class='row-fluid control-group <?php echo $model->hasErrors('text') ? 'error' : ''; ?>'>
        <?php echo $form->textAreaRow($model, 'text', array('class' => 'span12', 'required' => true,'rows' => 7, 'cols' => 50)); ?>
    </div>

    <?php if ($module->showCaptcha && !Yii::app()->user->isAuthenticated()): ?>
        <?php if(CCaptcha::checkRequirements()) : ?>
                <?php echo $form->labelEx($model, 'verifyCode'); ?>

                <?php $this->widget(
                    'CCaptcha',
                    array(
                        'showRefreshButton' => true,
                        'imageOptions' => array(
                            'width' => '150',
                        ),
                        'buttonOptions' => array(
                            'class' => 'btn',
                        ),
                        'buttonLabel' => '<i class="icon-repeat"></i>',
                        'captchaAction' => '/comment/comment/captcha'
                    )
                );
                ?>

                <div class='row-fluid control-group <?php echo $model->hasErrors('verifyCode') ? 'error' : ''; ?>'>
                    <?php echo $form->textFieldRow($model, 'verifyCode', array('placeholder' => Yii::t('CommentModule.comment', 'Insert symbols you see on picture'),'class' => 'span6', 'required' => true)); ?>
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
                'label' => Yii::t('CommentModule.comment', 'Create comment'),
            )
        ); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->
</div>