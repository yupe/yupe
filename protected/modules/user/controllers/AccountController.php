<?php
class AccountController extends yupe\components\controllers\FrontController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class'     => 'application.modules.yupe.components.actions.YCaptchaAction',
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