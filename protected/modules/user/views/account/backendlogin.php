<?php
/**
 * Файл отображения для account/backendlogin:
 *
 * @category YupeView
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/

$this->layout = 'login';
$this->yupe->getComponent('bootstrap');
$this->pageTitle = Yii::t('UserModule.user', 'Авторизация');
/**
 * Добавляем нужный CSS:
 */
Yii::app()->clientScript->registerCssFile(
    Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.user.views.assets') . '/css/backendlogin.css'
    )
); ?>
<div class="wrapper">
    <div class="login-form">
            <?php
            $form = $this->beginWidget(
                'bootstrap.widgets.TbActiveForm', array(
                    'id'          => 'horizontalForm',
                    'htmlOptions' => array('class' => 'well')
                )
            ); ?>
            <fieldset>
                <legend><?php echo Yii::t('UserModule.user', 'Пожалуйста, авторизуйтесь'); ?></legend>
                <?php echo $form->errorSummary($model); ?>
                <div class='row-fluid'>
                    <?php echo $form->textFieldRow($model, 'email', array('class' => 'span12')); ?>
                    <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span12')); ?>
                    <?php if($this->getModule()->sessionLifeTime > 0):  ?>
                        <?php echo $form->checkBoxRow($model, 'remember_me'); ?>
                    <?php endif; ?>
                </div>
                <?php if (Yii::app()->user->getState('badLoginCount', 0) >= 3): ?>
                    <div class='row-fluid'>
                        <?php if (CCaptcha::checkRequirements('gd')): ?>
                            <?php echo $form->labelEx($model, 'verifyCode'); ?>
                            <div>
                                <?php $this->widget('CCaptcha', array('showRefreshButton' => true)); ?>
                                <?php echo $form->textField($model, 'verifyCode'); ?>
                                <?php echo $form->error($model, 'verifyCode'); ?>
                            </div>
                            <div class="hint">
                                <?php echo Yii::t('UserModule.user', 'Введите текст указанный на картинке'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </fieldset>
            <div class="form-actions">
                <?php
                $this->widget(
                    'bootstrap.widgets.TbButton', array(
                        'buttonType'  => 'submit',
                        'type'        => 'primary',
                        'label'       => Yii::t('UserModule.user', 'Войти'),
                        'htmlOptions' => array(
                            'class' => 'btn-block'
                        ),
                    )
                );
                $this->widget(
                    'bootstrap.widgets.TbButton', array(
                        'buttonType'  => 'reset',
                        'label'       => Yii::t('UserModule.user', 'Очистить'),
                        'htmlOptions' => array(
                            'class' => 'btn-block'
                        ),
                    )
                ); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>