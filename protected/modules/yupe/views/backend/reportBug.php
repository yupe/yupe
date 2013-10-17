<?php
/**
 * Отображение для backend/reportBug:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs = array(
    Yii::t('YupeModule.yupe', 'System') => array('settings'),
    Yii::t('YupeModule.yupe', 'Report bug'),
); ?>

<div class='row-fluid'>
        <?php
        $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm', array(
                'id'                     => 'reportBug-form',
                'enableAjaxValidation'   => false,
                'enableClientValidation' => true,
                'htmlOptions'            => array('class' => 'well span8'),
                'inlineErrors'           => true,
            )
        ); ?>
            <div class="alert alert-block alert-info">
                <p><?php echo Yii::t('YupeModule.yupe','If you found a bug, first please look next sources:');?></p>
                <p><?php echo CHtml::link(Yii::t('YupeModule.yupe','Official forum'),'http://yupe.ru/talk?from=bug_report',array('target' => '_blank'));?></p>
                <p><?php echo CHtml::link(Yii::t('YupeModule.yupe','Official documentation'),'http://yupe.ru/docs/index.html?from=bug_report',array('target' => '_blank'));?></p>
                <p><?php echo CHtml::link(Yii::t('YupeModule.yupe','Issues on Github'),'https://github.com/yupe/yupe/issues?labels=&milestone=&page=1&state=open',array('target' => '_blank'));?></p>
            </div>
            <legend><?php echo Yii::t('YupeModule.yupe', 'Send error report'); ?></legend>
            
            <?php echo $form->errorSummary($model); ?>

            <div class='row-fluid controll-group <?php echo $model->hasErrors('module') ? 'error' : ''; ?>'>
                <?php
                echo $form->dropDownListRow(
                    $model, 'module', $model->moduleList, array(
                        'class'               => 'span12 popover-help',
                        'data-original-title' => $model->getAttributeLabel('module'),
                        'data-content'        => $model->getAttributeDescription('module'),
                    )
                )?>
            </div>
            <div class='row-fluid controll-group <?php echo $model->hasErrors('sendTo') ? 'error' : ''; ?>'>
                <?php
                echo $form->dropDownListRow(
                    $model, 'sendTo', $model->sendToList, array(
                        'class'               => 'span12 popover-help',
                        'data-original-title' => $model->getAttributeLabel('sendTo'),
                        'data-content'        => $model->getAttributeDescription('sendTo'),
                    )
                )?>
            </div>
            <div class='row-fluid control-group <?php echo $model->hasErrors('subject') ? 'error' : ''; ?>'>
                <?php
                echo $form->textFieldRow(
                    $model, 'subject', array(
                        'class'               => 'span12 popover-help',
                        'data-original-title' => $model->getAttributeLabel('subject'),
                        'data-content'        => $model->getAttributeDescription('subject'),
                    )
                )?>
            </div>
            <div class='row-fluid control-group <?php echo $model->hasErrors('message') ? 'error' : ''; ?>'>
                <?php
                echo $form->textAreaRow(
                    $model, 'message', array(
                        'class'               => 'span12 popover-help',
                        'data-original-title' => $model->getAttributeLabel('message'),
                        'data-content'        => $model->getAttributeDescription('message'),
                        'rows'                => '12',
                    )
                )?>
            </div>
            <?php
            $this->widget(
                'bootstrap.widgets.TbButton', array(
                    'buttonType'  => 'submit',
                    'type'        => 'primary',
                    'htmlOptions' => array(
                        'class'   => 'btn-block',
                    ),
                    'label'       => Yii::t('YupeModule.yupe', 'Send message for developers'),
                )
            ); ?>

        <?php $this->endWidget(); ?>
</div>