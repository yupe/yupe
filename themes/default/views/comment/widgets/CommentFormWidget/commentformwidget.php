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
    $(document).ready(function(){
        $(document).on("click", '#wcml', function(event){
            event.preventDefault();
            $("div.comment-form").remove();
            $("#comment-form-wrap").show();
        });

        $(document).on('keyup', '#comment-form textarea, #comment-form input[type=text]', function(event){
            if (event.ctrlKey && event.keyCode == 13) {
                $(this).parents('#comment-form').submit();
            }
        });

        $(document).on('submit', '#comment-form', function(){
            $(this).addClass('loading');
            $(this).find('.backdrop').remove();
            $(this).append('<div class="backdrop"></div>')
            $(this).find('input[type=submit]').attr('disabled', 'disabled');
            var curForm = this;
            $.ajax({
                type: 'post',
                url: $(curForm).attr('action'),
                data: $(curForm).serialize(),
                success: function(data) {
                    $(curForm).removeClass('loading');
                    $(curForm).find('.backdrop').remove();
                    $(curForm).find('input[type=submit]').removeAttr('disabled');
                    if (typeof data.result != 'undefined' && data.result) {
                        if (typeof data.data.commentContent !== 'undefined' && data.data.commentContent.length > 0) {
                            if (data.data.comment.parent_id > 0) {
                                container = $('div[id*="comment_' + data.data.comment.parent_id + '"]').parent('div');
                            } else {
                                container = $('#comments');
                            }

                            container.append(data.data.commentContent);
                        }
                        curForm.reset();
                        var messageBox = '<div id="messageBox" class="flash"><div class="flash-success"><b>' + data.data.message + '</b></div></div>';
                    } else {
                        var messageBox = '<div id="messageBox" class="flash"><div class="flash-error"><b>' + data.data.message + '</b></div></div>';
                    }
                    $(curForm).before(messageBox);
                    if ($('.captcha-refresh-link').length > 0)
                        $('.captcha-refresh-link').click();
                    setTimeout(function() {
                        $("#messageBox").fadeOut('slow').remove();
                        if (typeof data.result != 'undefined' && data.result) {
                            $('#wcml').click();
                        }
                    }, 3000);
                },
                error: function(data) {
                    $(curForm).removeClass('loading');
                    $(curForm).find('.backdrop').remove();
                    $(curForm).find('input[type=submit]').removeAttr('disabled');
                    if (typeof data.data != 'undefined' && typeof data.data.message != 'undefined')
                        message = data.data.message;
                    else
                        message = errorMessage;
                    var messageBox = '<div id="messageBox" class="flash"><div class="flash-error"><b>' + message + '</b></div></div>';
                    $(curForm).before(messageBox);
                    setTimeout(function() {
                        $("#messageBox").fadeOut('slow').remove();
                    }, 3000);
                },
                dataType: 'json'
            });
            return false;
        });
    });
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
    <?php if (!Yii::app()->user->isAuthenticated() && CCaptcha::checkRequirements()) : ?>
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
    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('CommentModule.comment', 'Добавить комментарий')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->
</div>