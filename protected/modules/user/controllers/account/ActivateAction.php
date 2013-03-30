<?php
class ActivateAction extends CAction
{
    public function run($key)
    {
        // пытаемся сделать выборку из таблицы пользователей
        $user = User::model()->notActivated()->find('activate_key = :activate_key', array(':activate_key' => $key));
        // процедура активации
        $module = Yii::app()->getModule('user');

        if (!$user)
        {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'Ошибка активации! Возможно данный аккаунт уже активирован! Попробуете зарегистрироваться вновь?')
            );

            $this->controller->redirect(array($module->accountActivationFailure));
        }

        if ($user->activate())
        {
            Yii::log(
                Yii::t('UserModule.user', "Активирован аккаунт с activate_key = {activate_key}!", array('{activate_key}' => $key)),
                CLogger::LEVEL_INFO, UserModule::$logCategory
            );

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('UserModule.user', 'Вы успешно активировали аккаунт! Теперь Вы можете войти!')
            );

            // отправить сообщение о активации аккаунта
            $emailBody = $this->controller->renderPartial('accountActivatedEmail', array('model' => $user), true);

            Yii::app()->mail->send($module->notifyEmailFrom, $user->email, Yii::t('UserModule.user', 'Аккаунт активирован!'), $emailBody);

            $this->controller->redirect(array($module->accountActivationSuccess));
        }
        else
        {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'При активации аккаунта произошла ошибка! Попробуйте позже!')
            );

            Yii::log(
                Yii::t('UserModule.user', "При активации аккаунта c activate_key => {activate_key} произошла ошибка!", array('{activate_key}' => $key)),
                CLogger::LEVEL_ERROR, UserModule::$logCategory
            );

            $this->controller->redirect(array($module->accountActivationFailure));
        }
    }
}