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
                Yii::t('UserModule.user', 'Activation error! Maybe e-mail already chacked or incorrect activation code was used. Try to use another e-mail')
            );
            $this->controller->redirect(array('/user/account/login'));
        }

        // процедура активации

        if ($user->confirmEmail())
        {
            Yii::log(
                Yii::t('UserModule.user', 'Email with activate_key = {activate_key}, id = {id} was activated!', array(
                    '{activate_key}' => $key,
                    '{id}'           => $user->id,
                )),
                CLogger::LEVEL_INFO, UserModule::$logCategory
            );

            Yii::app()->user->setFlash(
                YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('UserModule.user', 'You confirmed new e-mail successfully!')
            );

            $this->controller->redirect(array('/user/account/profile'));
        }
        else
        {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'E-mail confirmation error. Please try again later')
            );

            Yii::log(
                Yii::t('UserModule.user', 'There is an error {error} when confirm e-mail with activate_key => {activate_key}', array(
                    '{activate_key}' => $key,
                    '{error}'        => $e->getMessage(),
                )),
                CLogger::LEVEL_ERROR, UserModule::$logCategory
            );

            $this->controller->redirect(array('/user/account/profile'));
        }
    }
}