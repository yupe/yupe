<?php
/**
 * Экшн, отвечающий за подтверждение email пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class EmailConfirmAction extends CAction
{
    public function run($token)
    {
        // пытаемся сделать выборку из таблицы пользователей
        if (($user = User::model()->findVerifyEmail($token)) === null || $user->getIsVerifyEmail() === true) {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t(
                    'UserModule.user',
                    'Activation error! Maybe e-mail already confirmed or incorrect activation code was used. Try to use another e-mail'
                )
            );

            $this->controller->redirect(
                (array) Yii::app()->user->isGuest
                    ? '/user/account/login'
                    : '/user/account/profile'
            );
        }

        // процедура активации
        if (yupe\components\Token::confirmEmail($user)) {
            Yii::log(
                Yii::t(
                    'UserModule.user', 'Email with activate_key = {activate_key}, id = {id} was activated!', array(
                        '{activate_key}' => $token,
                        '{id}'           => $user->id,
                    )
                ),
                CLogger::LEVEL_INFO, UserModule::$logCategory
            );

            Yii::app()->user->setFlash(
                YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('UserModule.user', 'You confirmed new e-mail successfully!')
            );

            $this->controller->redirect(
                (array) Yii::app()->user->isGuest
                    ? '/user/account/login'
                    : '/user/account/profile'
            );
        }
        
        Yii::app()->user->setFlash(
            YFlashMessages::ERROR_MESSAGE,
            Yii::t('UserModule.user', 'E-mail confirmation error. Please try again later')
        );

        Yii::log(
            Yii::t(
                'UserModule.user', 'There is an error when confirm e-mail with activate_key => {activate_key}', array(
                    '{activate_key}' => $token
                )
            ),

            CLogger::LEVEL_ERROR, UserModule::$logCategory
        );

        $this->controller->redirect(
            (array) Yii::app()->user->isGuest
                ? '/user/account/login'
                : '/user/account/profile'
        );
    }
}