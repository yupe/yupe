<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
     'action'                 => $this->controller->createUrl('/comment/comment/add'),
     'id'                     => 'comment-form',
     'enableClientValidation' => true,
)); ?>

    <p class="note">
        <?php echo Yii::t('CommentModule.comment', 'Поля, отмеченные'); ?>
        <span class="required">*</span> 
        <?php echo Yii::t('CommentModule.comment', 'обязательны для заполнения'); ?>
    </p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->hiddenField($model, 'model'); ?>
    <?php echo $form->hiddenField($model, 'model_id'); ?>
    <?php echo $form->hiddenField($model, 'parrent_id'); ?>
    <?php echo CHtml::hiddenField('redirectTo', $redirectTo); ?>
    <?php if (!Yii::app()->user->isAuthenticated()): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 128)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 128)); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'url'); ?>
            <?php echo $form->textField($model, 'url', array('size' => 60, 'maxlength' => 128)); ?>
            <?php echo $form->error($model, 'url'); ?>
        </div>
    <?php else: ?>
        <p><?php echo Yii::t('CommentModule.comment', 'От имени'); ?>: <?php echo Yii::app()->user->getState('nick_name'); ?></p>
    <?php endif; ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php echo $form->textArea($model, 'text', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>
    <?php if (!Yii::app()->user->isAuthenticated() && extension_loaded('gd')): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'verifyCode'); ?>
            <div>
                <?php $this->widget('CCaptcha', array(
                    'captchaAction'     => '/comment/comment/captcha',
                    'showRefreshButton' => false,
                    'clickableImage'    => true,
                )); ?>
                <?php echo $form->textField($model, 'verifyCode'); ?>
            </div>
            <div class="hint">
                <?php echo Yii::t('CommentModule.comment', 'Введите цифры указанные на картинке'); ?>
            </div>
        </div> 
    <?php endif; ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('CommentModule.comment', 'Добавить комментарий')); ?>
    </div>

<?php $this->endWidget(); ?>
</div><!-- form -->