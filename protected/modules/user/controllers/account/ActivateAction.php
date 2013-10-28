<?php
/**
 * Экшн, отвечающий за активацию аккаунта пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 *
 **/

class ActivateAction extends CAction
{
    public function run($token)
    {
        // Пытаемся найти пользователя по токену,
        // в противном случае - ошибка:
        if (($user = User::model()->findActivation($token)) === null) {
            
            // Сообщаем об ошибке:
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'There was a problem with the activation of the account. Please refer to the site\'s administration.')
            );

            // Переадресовываем на соответствующую ошибку:
            $this->controller->redirect(
                array(
                    Yii::app()->getModule('user')->accountActivationFailure
                )
            );

        } elseif ((int) $user->reg->status === UserToken::STATUS_NULL && $user->activate()) {
            
            // Записываем информацию о событии в лог-файл:
            Yii::log(
                Yii::t(
                    'UserModule.user', 'Account with activate_key = {activate_key} was activated!', array(
                        '{activate_key}' => $token
                    )
                ),
                CLogger::LEVEL_INFO, UserModule::$logCategory
            );

            // Сообщаем пользователю:
            Yii::app()->user->setFlash(
                YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('UserModule.user', 'You activate account successfully. Now you can login!')
            );

            // Формируем сообщение:
            $emailBody = $this->controller->renderPartial(
                'accountActivatedEmail', array(
                    'model' => $user
                ), true
            );

            // Отправляем сообщение об активации аккаунта:
            Yii::app()->mail->send(
                Yii::app()->getModule('user')->notifyEmailFrom, $user->email,
                Yii::t('UserModule.user', 'Account was activated!'), $emailBody
            );

            // Выполняем переадресацию на соответствующую страницу:
            $this->controller->redirect(
                array(
                    Yii::app()->getModule('user')->accountActivationSuccess
                )
            );

        } else {
            
            // Сообщаяем о проблеме пользователю:
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'Account activation error! Try again later!')
            );

            // Записываем событие в лог-файл:
            Yii::log(
                Yii::t(
                    'UserModule.user',
                    'There is an error when activating account with activate_key => {activate_key}', array(
                        '{activate_key}' => $token
                    )
                ),
                CLogger::LEVEL_ERROR, UserModule::$logCategory
            );

            // Выполняем переадресацию на соответствующую страницу: 
            $this->controller->redirect(
                array(
                    Yii::app()->getModule('user')->accountActivationFailure
                )
            );
        }
    }
}