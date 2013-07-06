<?php
$this->pageTitle = 'Юпи! | Контакты';
$this->breadcrumbs = array('Контакты связь');
?>

<h1>Контакты</h1>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

<div class="alert alert-notice">

    <p> Если у Вас есть вопросы, предложения или Вы хотите сообщите об ошибке.</p>

    <p> Если Вы заинтересованы в создании качественного легкого в
        поддержке проекта.</p>

    <p><b>Срочно <a href="http://yupe.ru/feedback/index?from=contact" target="_blank">напишите нам</a> об этом!</b></p>
    <p> Мы стараемся отвечать очень быстро :)</p>

    <p><b>Спасибо, за внимание!</b></p>

</div>

<div class="form">
    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        array(
            'id' => 'feedback-form',
            'type' => 'vertical',
            'inlineErrors' => true,
            'htmlOptions' => array(
                'class' => 'well',
            )
        )
    ); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения</p>

    <?php echo $form->errorSummary($model); ?>

    <?php if ($model->type): ?>
        <div class='row-fluid control-group <?php echo $model->hasErrors('type') ? 'error' : ''; ?>'>
            <?php echo $form->dropDownListRow($model, 'type', $module->types, array('class' => 'span6', 'required' => true)); ?>
        </div>
    <?php endif; ?>

    <div class='row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span6', 'required' => true)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>'>
        <?php echo $form->textFieldRow($model, 'email', array('class' => 'span6', 'required' => true)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('theme') ? 'error' : ''; ?>'>
        <?php echo $form->textFieldRow($model, 'theme', array('class' => 'span6', 'required' => true)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('text') ? 'error' : ''; ?>'>
        <?php $this->widget($this->module->editor, array(
            'model' => $model,
            'attribute' => 'text',
            'options' => $this->module->editorOptions,
        )); ?>
    </div>

    <?php if ($module->showCaptcha && !Yii::app()->user->isAuthenticated()): ?>
        <?php if (CCaptcha::checkRequirements()): ?>

                <?php echo $form->labelEx($model, 'verifyCode'); ?>

                <?php $this->widget('CCaptcha', array(
                    'showRefreshButton' => true,
                    'clickableImage' => true,
                    'buttonLabel' => 'обновить',
                    'buttonOptions' => array('class' => 'captcha-refresh-link')
                )); ?>

                <div class='row-fluid control-group <?php echo $model->hasErrors('verifyCode') ? 'error' : ''; ?>'>
                    <?php echo $form->textFieldRow($model, 'verifyCode', array('placeholder' => 'Введите цифры указанные на картинке','class' => 'span6', 'required' => true)); ?>
                </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => Yii::t('UserModule.user', 'Отправить сообщение'),
        )
    ); ?>


    <?php $this->endWidget(); ?>
</div>


<div class="alert alert-success">

    <p><?php echo Yii::t('install', 'Полезные ссылки:'); ?></p>

    <?php echo CHtml::link(Yii::t('install', 'Официальная документация Юпи'), 'http://yupe.ru/docs/index.html?from=contact'); ?>  - <?php echo Yii::t('install', 'Очень активно ее пишем, помоги нам =)'); ?>

    <br/><br/>

    <?php echo CHtml::link(Yii::t('install', 'Форум поддержки Юпи'), 'http://yupe.ru/talk/'); ?>  - <?php echo Yii::t('install', 'Обсуждения, страсти, tip and trics - всё тут =)'); ?>

    <br/><br/>

    <?php echo CHtml::link(Yii::t('install', 'Официальный твиттер Юпи'), 'https://twitter.com/#!/YupeCms'); ?>  - <?php echo Yii::t('install', 'Обязательно заффоловьте нас, мы не спамим =)'); ?>

    <br/><br/>

    <?php echo CHtml::link(Yii::t('install', 'Исходный код на Github'), 'http://github.com/yupe/yupe/'); ?> - <?php echo Yii::t('install', 'Пришлите нам парочку пулл-реквестов, все только выиграют =)'); ?>

    <br/><br/>

    <?php echo CHtml::link(Yii::t('install', 'Генеральный спонсор'), 'http://amylabs.ru?from=yupe-contact'); ?> - <?php echo Yii::t('install', 'Просто отличные парни =)'); ?>

</div>