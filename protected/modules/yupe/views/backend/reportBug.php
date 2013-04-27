<?php
/**
 * Отображение для backend/reportBug:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs = array(
    Yii::t('YupeModule.yupe', 'Юпи!') => array('settings'),
    Yii::t('YupeModule.yupe', 'Сообщить об ошибке'),
); ?>

<div class='row-fluid'>
        <?php
        $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm', array(
                'id'                     => 'reportBug-form',
                'enableAjaxValidation'   => false,
                'enableClientValidation' => true,
                'htmlOptions'            => array('class' => 'well span8', 'enctype'=>'multipart/form-data'),
                'inlineErrors'           => true,
            )
        ); ?>
            <legend><?php echo Yii::t('YupeModule.yupe', 'Сообщить об ошибке'); ?></legend>
            
            <?php echo $form->errorSummary($model); ?>

            <div class='row-fluid controll-group <?php echo $model->hasErrors('module') ? 'error' : ''; ?>'>
                <?php echo $form->dropDownListRow($model, 'module', $model->moduleList, array('class' => 'span12'))?>
            </div>
            <div class='row-fluid controll-group <?php echo $model->hasErrors('sendTo') ? 'error' : ''; ?>'>
                <?php echo $form->dropDownListRow($model, 'sendTo', $model->sendToList, array('class' => 'span12'))?>
            </div>
            <div class='row-fluid control-group <?php echo $model->hasErrors('subject') ? 'error' : ''; ?>'>
                <?php echo $form->textFieldRow($model, 'subject', array('class' => 'span12'))?>
            </div>
            <div class='row-fluid control-group <?php echo $model->hasErrors('message') ? 'error' : ''; ?>'>
                <?php echo $form->textAreaRow($model, 'message', array('class' => 'span12', 'rows' => '12'))?>
            </div>
            <?php
            $this->widget(
                'bootstrap.widgets.TbButton', array(
                    'buttonType'  => 'submit',
                    'type'        => 'primary',
                    'htmlOptions' => array(
                        'class'   => 'btn-block',
                    ),
                    'label'       => Yii::t('YupeModule.yupe', 'Отправить'),
                )
            ); ?>

        <?php $this->endWidget(); ?>
</div>