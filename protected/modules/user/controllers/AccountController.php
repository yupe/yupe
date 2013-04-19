<?php
class AccountController extends YFrontController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class'     => 'CCaptchaAction',
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
            'fblogin'          => array(
                'class' => 'application.modules.user.controllers.account.FbloginAction',
            ),
            'logout'           => array(
                'class' => 'application.modules.user.controllers.account.LogOutAction',
            ),
            'recovery'         => array(
                'class' => 'application.modules.user.controllers.account.RecoveryAction',
            ),
            'recoveryPassword' => array(
                'class' => 'application.modules.user.controllers.account.RecoveryPasswordAction',
            ),
            'emailConfirm'     => array(
                'class' => 'application.modules.user.controllers.account.EmailConfirmAction',
            ),
        );
    }
}