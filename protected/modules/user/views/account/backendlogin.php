<?php
/**
 * Файл отображения для account/backendlogin:
 *
 * @category YupeView
 * @package  yupe
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/

$this->layout = 'login';
$this->yupe->getComponent('bootstrap');
$this->pageTitle = Yii::t('UserModule.user', 'Authorization');
Yii::app()->getClientScript()->registerCssFile(
    Yii::app()->getAssetManager()->publish(
        Yii::getPathOfAlias('application.modules.user.views.assets') . '/css/backendlogin.css'
    )
); ?>
<div class="wrapper">
    <div class="login-form">
        <?php
        $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm',
            array(
                'id'          => 'horizontalForm',
                'htmlOptions' => array('class' => 'well')
            )
        ); ?>
        <fieldset>
            <legend><?php echo Yii::t('UserModule.user', 'Authorize please'); ?></legend>
            <?php echo $form->errorSummary($model); ?>
            <div class='row'>
                <div class="col-xs-12">
                    <?php echo $form->textFieldGroup($model, 'email'); ?>
                </div>
                <div class="col-xs-12">
                    <?php echo $form->passwordFieldGroup($model, 'password'); ?>
                </div>
                <?php if ($this->getModule()->sessionLifeTime > 0): { ?>
                    <div class="col-xs-12">
                        <?php echo $form->checkBoxGroup($model, 'remember_me'); ?>
                    </div>
                <?php } endif; ?>

            </div>
            <?php if (Yii::app()->user->getState('badLoginCount', 0) >= $this->getModule()->badLoginCount): { ?>
                <div class='row'>
                    <div class="col-xs-12">
                        <?php if (CCaptcha::checkRequirements('gd')): { ?>
                            <div>
                                <?php $this->widget('CCaptcha', array('showRefreshButton' => true)); ?>
                                <?php echo $form->textFieldGroup(
                                    $model,
                                    'verifyCode',
                                    array('hint' => Yii::t('UserModule.user', 'Please enter the text from the image'))
                                ); ?>

                            </div>
                        <?php } endif; ?>
                    </div>
                </div>
            <?php } endif; ?>

            <?php if (!$this->getModule()->recoveryDisabled): { ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo CHtml::link(
                            Yii::t('UserModule.user', 'Forgot password?'),
                            array('/user/account/recovery')
                        ); ?>
                    </div>
                </div>
            <?php } endif; ?>
        </fieldset>
        <div class="form-actions">
            <?php
            $this->widget(
                'bootstrap.widgets.TbButton',
                array(
                    'buttonType'  => 'submit',
                    'context'     => 'primary',
                    'label'       => Yii::t('UserModule.user', 'Login'),
                    'htmlOptions' => array(
                        'class' => 'btn-block'
                    ),
                )
            );
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
