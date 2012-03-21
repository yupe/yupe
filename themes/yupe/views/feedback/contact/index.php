<?php $this->pageTitle = 'Юпи! | Обратная связь'; ?>

<h1>Обратная связь</h1>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

<p> Напишите нам если: </p>

<p> У Вас есть вопросы, предложения или Вы хотите сообщите об ошибке.</p>

<p> У Вас есть сайт, написанный на фреймворке <b>Yii</b> и Вы хотите его
    улучшить или исправить ошибки.</p>

<p> Вы заинтересованы в создании качественного интернет-проекта, легкого в
    поддержке и сопровождении.</p>

<p> Просто хотите поболтать =)</p> <p> Мы стараемся отвечать быстро... очень
    быстро !</p>

<p> Спасибо, за внимание! </p>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'feedback-form',
                                                         'enableClientValidation' => true
                                                    )); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны
        для заполнения</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name'); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email'); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'theme'); ?>
        <?php echo $form->textField($model, 'theme'); ?>
        <?php echo $form->error($model, 'theme'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php echo $form->textArea($model, 'text', array('cols' => 60, 'rows' => 5)); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <?php if (Yii::app()->getModule('feedback')->showCaptcha): ?>
    <?php if (extension_loaded('gd')): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'verifyCode'); ?>
            <div>
                <?php $this->widget('CCaptcha', array('showRefreshButton' => false)); ?>
                <?php echo $form->textField($model, 'verifyCode'); ?>
                <?php echo $form->error($model, 'verifyCode'); ?>
            </div>
            <div class="hint">
                Введите цифры указанные на картинке
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="row submit">
        <?php echo CHtml::submitButton('Отправить сообщение'); ?>
    </div>


    <?php $this->endWidget(); ?>

</div>

<div style='float:left;'>
    <div style='float:left;padding-right:5px'>
        <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
                                                                                                  'type' => 'button',
                                                                                                  'services' => 'all'
                                                                                             ));?>
    </div>
</div>
