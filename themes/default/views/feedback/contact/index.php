<?php
$this->pageTitle = 'Юпи! | Обратная связь';
$this->breadcrumbs = array('Обратная связь');
?>

<h1>Обратная связь</h1>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

<p> Если у Вас есть вопросы, предложения или Вы хотите сообщите об ошибке</p>

<p> Или Вы заинтересованы в создании качественного интернет-проекта, легкого в
    поддержке и сопровождении !?</p>

<p><i>Пожалуйста напишите нам об этом!</i></p>
<p> Мы стараемся отвечать быстро... очень
    быстро !</p>

<p><?php echo Yii::t('install', 'Полезные ссылки:');?></p>

<?php echo CHtml::link(Yii::t('install', 'Форум поддержки Юпи!'), 'http://yupe.ru/talk/'); ?>  - <?php echo Yii::t('install', 'Можно просто поболтать =)'); ?>

<br/><br/>

<?php echo CHtml::link(Yii::t('install', 'Официальный твиттер Юпи!'), 'https://twitter.com/#!/YupeCms'); ?>  - <?php echo Yii::t('install', 'обязательно заффоловьте нас, мы не спамим =)'); ?>

<br/><br/>

<?php echo CHtml::link(Yii::t('install', 'Исходный код на Github'), 'http://github.com/yupe/yupe/'); ?> - <?php echo Yii::t('install', 'пришлите нам парочку пулл-реквестов, все только выиграют =)'); ?>

<br/><br/>

<p><b>Спасибо, за внимание!</b></p>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'feedback-form',
    'enableClientValidation' => true
)); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны
        для заполнения</p>

    <?php echo $form->errorSummary($model); ?>

    <?php if ($model->type): ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropDownList($model, 'type', $module->types); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>
    <?php endif;?>

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

    <?php if ($module->showCaptcha && !Yii::app()->user->isAuthenticated()): ?>
    <?php if (CCaptcha::checkRequirements()): ?>
        <div class="row">
                <?php echo $form->labelEx($model, 'verifyCode'); ?>

                <?php $this->widget('CCaptcha', array(
                        'showRefreshButton' => true,
                        'clickableImage' => true,
                        'buttonLabel' => 'обновить',
                        'buttonOptions' => array('class' => 'captcha-refresh-link')
                )); ?>

                <?php echo $form->textField($model, 'verifyCode'); ?>
                <?php echo $form->error($model, 'verifyCode'); ?>
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