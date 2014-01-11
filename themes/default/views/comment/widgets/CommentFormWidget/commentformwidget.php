<a href='#' id='wcml' style="display: none;"><?php echo Yii::t("CommentModule.comment", 'WRITE COMMENT'); ?></a>

<div id='comment-form-wrap' class='comment-form-wrap'>

<div id='comment-result' class='alert' style='display:none'></div>

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
    <?php endif; ?>

    <div class='row-fluid control-group <?php echo $model->hasErrors('text') ? 'error' : ''; ?>'>
        <?php echo $form->textAreaRow($model, 'text', array('class' => 'span12', 'required' => true,'rows' => 3, 'cols' => 50)); ?>
    </div>

    <?php if ($module->showCaptcha && !Yii::app()->user->isAuthenticated()): ?>
        <?php if(CCaptcha::checkRequirements()) : ?>
                <?php echo $form->labelEx($model, 'verifyCode'); ?>

                <?php 
                   $this->widget(
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
        <button class="btn btn-primary" id="yw0" type="submit" name="yt0"><i class="icon-comment"></i> <?php echo Yii::t('CommentModule.comment', 'Create comment');?></button>        
    </div>
<?php $this->endWidget(); ?>
</div>