<?php
class EmailConfirmAction extends CAction
{
    public function run($key)
    {
        // пытаемся сделать выборку из таблицы пользователей
        $user = User::model()->active()->find('activate_key = :activate_key', array(':activate_key' => $key));

        if (!$user)
        {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'Ошибка активации! Возможно данный e-mail уже проверен или указан неверный ключ активации! Попробуйте другой e-mail.')
            );
            $this->controller->redirect(array('/user/account/login'));
        }

        // процедура активации

        if ($user->confirmEmail())
        {
            Yii::log(
                Yii::t('UserModule.user', "Активирован e-mail с activate_key = {activate_key}, id = {id}!", array(
                    '{activate_key}' => $key,
                    '{id}'           => $user->getId(),
                )),
                CLogger::LEVEL_INFO, UserModule::$logCategory
            );

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('UserModule.user', 'Вы успешно подтвердили новый e-mail!')
            );

            $this->controller->redirect(array('/user/account/profile'));
        }
        else
        {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'При подтверждении e-mail произошла ошибка! Попробуйте позже!')
            );

            Yii::log(
                Yii::t('UserModule.user', "При подтверждении e-mail c activate_key => {activate_key} произошла ошибка {error}!", array(
                    '{activate_key}' => $key,
                    '{error}'        => $e->getMessage(),
                )),
                CLogger::LEVEL_ERROR, UserModule::$logCategory
            );

            $this->controller->redirect(array('/user/account/profile'));
        }
    }
}