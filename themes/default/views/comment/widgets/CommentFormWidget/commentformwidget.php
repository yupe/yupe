<?php
/**
 * Отображение для CommentFormWidget/commentformwidget:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
?>
<script type='text/javascript'>
    var errorMessage = '<?php echo Yii::t("CommentModule.comment", "При добавлении комментария возникла ошибка, повторите попытку позже.")?>';
</script>

<a href='#' id='wcml'>НАПИСАТЬ КОММЕНТАРИЙ</a>

<br/><br/>
<div id='comment-form-wrap' class='comment-form-wrap'>
<div class="form">
<?php
$form = $this->beginWidget(
    'CActiveForm', array(
         'action'                 => $this->controller->createUrl('/comment/comment/add'),
         'id'                     => 'comment-form',
         'enableClientValidation' => true     
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
    <?php echo $form->hiddenField($model, 'level'); ?>
    <?php echo CHtml::hiddenField('redirectTo', $redirectTo); ?>
    <?php if (!Yii::app()->user->isAuthenticated()) : ?>
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
    <?php if ($module->showCaptcha && !Yii::app()->user->isAuthenticated()): ?>
        <?php if(CCaptcha::checkRequirements()) : ?>
            <div class="row">
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

                <?php echo $form->textField($model, 'verifyCode'); ?>
                <div class="hint">
                    <?php echo Yii::t('CommentModule.comment', 'Введите цифры указанные на картинке'); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('CommentModule.comment', 'Добавить комментарий')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->
</div>