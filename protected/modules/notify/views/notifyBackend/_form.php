<?php
/**
 * Отображение для _form:
 *
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 *
 *   @var $model NotifySettings
 *   @var $form TbActiveForm
 *   @var $this NotifyBackendController
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'notify-settings-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => array('class' => 'well'),
    )
);
?>

<div class="alert alert-info">
    <?php echo Yii::t('notify', 'Поля, отмеченные'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('notify', 'обязательны.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->dropDownListGroup($model, 'user_id', array('widgetOptions' => array('data' => CHtml::listData(User::model()->findAll(), 'id', 'fullName')))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->dropDownListGroup($model, 'my_post', array('widgetOptions' => array('data' => $this->module->getChoice(),'htmlOptions' => array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('my_post'), 'data-content' => $model->getAttributeDescription('my_post'))))); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->dropDownListGroup($model, 'my_comment', array('widgetOptions' => array('data' => $this->module->getChoice(),'htmlOptions' => array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('my_comment'), 'data-content' => $model->getAttributeDescription('my_comment'))))); ?>
        </div>
    </div>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context'    => 'primary',
            'label'      => Yii::t('notify', 'Сохранить уведомление и продолжить'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
            'label'      => Yii::t('notify', 'Сохранить уведомление и закрыть'),
        )
    ); ?>

<?php $this->endWidget(); ?>
