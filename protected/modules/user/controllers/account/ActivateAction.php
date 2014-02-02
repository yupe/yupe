<?php
/**
 * Экшн, отвечающий за активацию аккаунта пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.7
 * @link     http://yupe.ru
 *
 **/

class ActivateAction extends CAction
{
    public function run($token)
    {
        $module = Yii::app()->getModule('user');

        // Пытаемся найти пользователя по токену,
        // в противном случае - ошибка:
        if (Yii::app()->userManager->activateUser($token)) {

            // Сообщаем пользователю:
            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('UserModule.user', 'You activate account successfully. Now you can login!')
            );

            $module->onSuccessActivate(
                new CModelEvent($this->controller, array('token' => $token))
            );

            // Выполняем переадресацию на соответствующую страницу:
            $this->controller->redirect(
                array(
                    $module->accountActivationSuccess
                )
            );

        }

        // Сообщаем об ошибке:
        Yii::app()->user->setFlash(
            yupe\widgets\YFlashMessages::ERROR_MESSAGE,
            Yii::t('UserModule.user', 'There was a problem with the activation of the account. Please refer to the site\'s administration.')
        );

        $module->onErrorActivate(
            new CModelEvent($this->controller, array('token' => $token))
        );

        // Переадресовываем на соответствующую ошибку:
        $this->controller->redirect(
            array(
                $module->accountActivationFailure
            )
        );
    }
}