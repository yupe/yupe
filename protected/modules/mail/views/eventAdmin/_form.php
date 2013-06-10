<script type='text/javascript'>
    $(document).ready(function(){
        $('#mail-event-form').liTranslit({
            elName: '#MailEvent_name',
            elAlias: '#MailEvent_code'
        });
    })
</script>


<?php
/**
 * Отображение для _form:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'mail-event-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
        'inlineErrors'           => true,
    )
); ?>

    <div class="alert alert-info">
        <?php echo Yii::t('MailModule.mail', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('MailModule.mail', 'обязательны.'); ?>
    </div>

    <?php echo  $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>

    <div class='control-group <?php echo $model->hasErrors("code") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'span7', 'maxlength' => 100)); ?>
    </div>

    <div class='control-group <?php echo $model->hasErrors("description") ? "error" : ""; ?>'>
        <?php echo $form->textAreaRow($model, 'description', array('class' => 'span7')); ?>
    </div>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => $model->isNewRecord ? Yii::t('MailModule.mail', 'Добавить событие и продолжить') : Yii::t('MailModule.mail', 'Сохранить событие и продолжить'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType'  => 'submit',
            'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
            'label'       => $model->isNewRecord ? Yii::t('MailModule.mail', 'Добавить событие и закрыть') : Yii::t('MailModule.mail', 'Сохранить событие и закрыть'),
        )
    ); ?>

<?php $this->endWidget(); ?>