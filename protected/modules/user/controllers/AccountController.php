<?php
/**
 * Контроллер, отвечающий за регистрацию, авторизацию и т.д. пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class AccountController extends yupe\components\controllers\FrontController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class'     => 'yupe\components\actions\YCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 1,
                'minLength' => Yii::app()->getModule('user')->minCaptchaLength,
            ),
            'registration'     => array(
                'class' => 'application.modules.user.controllers.account.RegistrationAction',
            ),
            'profile'          => array(
                'class' => 'application.modules.user.controllers.account.ProfileAction'
            ),
            'activate'         => array(
                'class' => 'application.modules.user.controllers.account.ActivateAction',
            ),
            'login'            => array(
                'class' => 'application.modules.user.controllers.account.LoginAction',
            ),
            'backendlogin'            => array(
                'class' => 'application.modules.user.controllers.account.LoginAction',
            ),
            'logout'           => array(
                'class' => 'application.modules.user.controllers.account.LogOutAction',
            ),
            'recovery'         => array(
                'class' => 'application.modules.user.controllers.account.RecoveryAction',
            ),
            'restore' => array(
                'class' => 'application.modules.user.controllers.account.RecoveryPasswordAction',
            ),
            'confirm'     => array(
                'class' => 'application.modules.user.controllers.account.EmailConfirmAction',
            ),
        );
    }
}