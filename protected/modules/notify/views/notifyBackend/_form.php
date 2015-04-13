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
    'bootstrap.widgets.TbActiveForm', [
        'id'                     => 'notify-settings-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => ['class' => 'well'],
    ]
);
?>

<div class="alert alert-info">
    <?php echo Yii::t('NotifyModule.notify', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('NotifyModule.notify', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->dropDownListGroup($model, 'user_id', ['widgetOptions' => ['data' => CHtml::listData(User::model()->findAll(), 'id', 'fullName')]]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->dropDownListGroup($model, 'my_post', ['widgetOptions' => ['data' => $this->module->getChoice(),'htmlOptions' => ['class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('my_post'), 'data-content' => $model->getAttributeDescription('my_post')]]]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->dropDownListGroup($model, 'my_comment', ['widgetOptions' => ['data' => $this->module->getChoice(),'htmlOptions' => ['class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('my_comment'), 'data-content' => $model->getAttributeDescription('my_comment')]]]); ?>
        </div>
    </div>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', [
            'buttonType' => 'submit',
            'context'    => 'primary',
            'label' => $model->getIsNewRecord() ? Yii::t('NotifyModule.notify', 'Create notification and continue') : Yii::t('NotifyModule.notify', 'Save notification and continue'),
        ]
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', [
            'buttonType' => 'submit',
            'htmlOptions'=> ['name' => 'submit-type', 'value' => 'index'],
            'label' => $model->getIsNewRecord() ? Yii::t('NotifyModule.notify', 'Create notification and close') : Yii::t('NotifyModule.notify', 'Save notification and close'),
        ]
    ); ?>

<?php $this->endWidget(); ?>
