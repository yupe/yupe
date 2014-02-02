<?php
/**
 * Экшн, отвечающий за подтверждение email пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.7
 * @link     http://yupe.ru
 *
 **/
class EmailConfirmAction extends CAction
{
    public function run($token)
    {
        $module = Yii::app()->getModule('user');

        // пытаемся подтвердить почту
        if (Yii::app()->userManager->verifyEmail($token)) {

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t(
                    'UserModule.user',
                    'You confirmed new e-mail successfully!'
                )
            );

            $module->onSuccessEmailConfirm(
                new CModelEvent($this->controller, array('token' => $token))
            );

        }else{

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                Yii::t(
                    'UserModule.user',
                    'Activation error! Maybe e-mail already confirmed or incorrect activation code was used. Try to use another e-mail'
                )
            );

            $module->onErrorEmailConfirm(
                new CModelEvent($this->controller, array('token' => $token))
            );
        }

        $this->controller->redirect(
                Yii::app()->user->isGuest
                ? array('/user/account/login')
                : array('/user/account/profile')
        );
    }
}