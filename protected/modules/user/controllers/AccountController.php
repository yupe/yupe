<?php
class AccountController extends YFrontController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'registration' => array(
                'class' => 'application.modules.user.controllers.account.RegistrationAction'
            ),
            'activate' => array(
                'class' => 'application.modules.user.controllers.account.ActivateAction'
            ),
            'login' => array(
                'class' => 'application.modules.user.controllers.account.LoginAction'
            ),
            'fblogin' => array(
                'class' => 'application.modules.user.controllers.account.FbloginAction'
            ),
            'logout' => array(
                'class' => 'application.modules.user.controllers.account.LogOutAction'
            ),
            'recovery' => array(
                'class' => 'application.modules.user.controllers.account.RecoveryAction'
            ),
            'recoveryPassword' => array(
                'class' => 'application.modules.user.controllers.account.RecoveryPasswordAction'
            ),            
        );
    }
}