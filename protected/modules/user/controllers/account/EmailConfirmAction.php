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
                Yii::t('user', 'Ошибка активации! Возможно данный e-mail уже проверен или указан неверный ключ активации! Попробуйте другой e-mail.')
            );
            $this->controller->redirect(array('/user/account/login'));
        }

        // процедура активации

        // проверить параметры пользователя по "черным спискам"
        if (!Yii::app()->getModule('user')->isAllowedIp(Yii::app()->request->userHostAddress))
            // перенаправить на экшн для фиксации невалидных ip адресов
            $this->controller->redirect(array(Yii::app()->getModule('user')->invalidIpAction));
        // проверить на email
        if (!Yii::app()->getModule('user')->isAllowedEmail($user->email))
            // перенаправить на экшн для фиксации невалидных ip адресов
            $this->controller->redirect(array(Yii::app()->getModule('user')->invalidEmailAction));

        if ($user->confirmEmail())
        {
            Yii::log(
                Yii::t('user', "Активирован e-mail с activate_key = {activate_key}, id = {id}!", array(
                    '{activate_key}' => $key,
                    '{id}'           => $user->id,
                )),
                CLogger::LEVEL_INFO, UserModule::$logCategory
            );

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('user', 'Вы успешно подтвердили новый e-mail!')
            );

            $this->controller->redirect(array('/user/account/profile'));
        }
        else
        {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('user', 'При подтверждении e-mail произошла ошибка! Попробуйте позже!')
            );

            Yii::log(
                Yii::t('user', "При подтверждении e-mail c activate_key => {activate_key} произошла ошибка {error}!", array(
                    '{activate_key}' => $key,
                    '{error}'        => $e->getMessage(),
                )),
                CLogger::LEVEL_ERROR, UserModule::$logCategory
            );

            $this->controller->redirect(array('/user/account/profile'));
        }
    }
}