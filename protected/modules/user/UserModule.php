<?php

/**
 * UserModule основной класс модуля user
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2014 amyLabs && Yupe! team
 * @package yupe.modules.user
 * @since 0.1
 *
 */


use yupe\components\WebModule;

class UserModule extends WebModule
{
    public $accountActivationSuccess       = '/user/account/login';
    public $accountActivationFailure       = '/user/account/registration';
    public $loginSuccess                   = '/';
    public $registrationSuccess            = '/user/account/login';
    public $loginAdminSuccess              = '';
    public $logoutSuccess                  = '/';
    public $sessionLifeTime                = 7;

    public $notifyEmailFrom;
    public $autoRecoveryPassword           = false;
    public $recoveryDisabled               = false;
    public $registrationDisabled           = false;
    public $minPasswordLength              = 8;
    public $emailAccountVerification       = true;
    public $showCaptcha                    = false;
    public $minCaptchaLength               = 3;
    public $maxCaptchaLength               = 6;
    public $documentRoot;
    public $avatarsDir                     = 'avatars';
    public $avatarMaxSize                  = 10000;
    public $defaultAvatar                  = '/web/images/avatar.png';
    public $avatarExtensions               = array('jpg', 'png', 'gif');
    public $usersPerPage                   = 20;

    public $registrationActivateMailEvent  = 'USER_REGISTRATION_ACTIVATE';
    public $registrationMailEvent          = 'USER_REGISTRATION';
    public $passwordAutoRecoveryMailEvent  = 'USER_PASSWORD_AUTO_RECOVERY';
    public $passwordRecoveryMailEvent      = 'USER_PASSWORD_RECOVERY';
    public $passwordSuccessRecoveryMailEvent = 'USER_PASSWORD_SUCCESS_RECOVERY';
    public $userAccountActivationMailEvent   = 'USER_ACCOUNT_ACTIVATION';

    public static $logCategory             = 'application.modules.user';    
    public $profiles                       = array();

    public function getUploadPath()
    {
        return  Yii::getPathOfAlias('webroot') . '/' .
            Yii::app()->getModule('yupe')->uploadPath . '/' .
            $this->avatarsDir . '/';
    }

    public function getInstall()
    {
        if(parent::getInstall()) {
            @mkdir($this->getUploadPath(),0755);
        }

        return false;
    }

    public function checkSelf()
    {
       $messages = array();

       if (!$this->avatarsDir) {
             $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t('UserModule.user', 'Please, choose avatars directory! {link}', array(
                    '{link}' => CHtml::link(Yii::t('UserModule.user', 'Edit module settings'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                     )),
                )),            
            );
        }

        if (!is_dir($this->getUploadPath()) || !is_writable($this->getUploadPath())) {
            $messages[WebModule::CHECK_ERROR][] = array(
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t('UserModule.user', 'Directory is not accessible "{dir}" for write or not exists! {link}', array(
                    '{dir}' => $this->getUploadPath(),
                    '{link}' => CHtml::link(Yii::t('UserModule.user', 'Edit module settings'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                    )),
                )),
            );
        }

        return (isset($messages[WebModule::CHECK_ERROR])) ? $messages : true;
    }

    public function getParamsLabels()
    {
        return array(
            'userAccountActivationMailEvent'   => Yii::t('UserModule.user', 'Mail event when user was activated successfully'),
            'passwordSuccessRecoveryMailEvent' => Yii::t('UserModule.user', 'Mail event when password was recovered successfully'),
            'passwordAutoRecoveryMailEvent'  => Yii::t('UserModule.user', 'Mail event for automatic password recovery'),
            'passwordRecoveryMailEvent'      => Yii::t('UserModule.user', 'Mail event for password recovery'),
            'registrationActivateMailEvent'  => Yii::t('UserModule.user', 'Mail event when new user was registered'),
            'registrationMailEvent'          => Yii::t('UserModule.user', 'Mail event when new user was registered without activation'),
            'adminMenuOrder'                 => Yii::t('UserModule.user', 'Menu items order'),
            'accountActivationSuccess'       => Yii::t('UserModule.user', 'Page after account activation'),
            'accountActivationFailure'       => Yii::t('UserModule.user', 'Page after activation error'),
            'loginSuccess'                   => Yii::t('UserModule.user', 'Page after authorization'),
            'logoutSuccess'                  => Yii::t('UserModule.user', 'Page after login'),
            'notifyEmailFrom'                => Yii::t('UserModule.user', 'From which email send a message'),
            'autoRecoveryPassword'           => Yii::t('UserModule.user', 'Automatic password recovery'),
            'recoveryDisabled'               => Yii::t('UserModule.user', 'Disable password recovery'),
            'registrationDisabled'           => Yii::t('UserModule.user', 'Disable registration'),
            'minPasswordLength'              => Yii::t('UserModule.user', 'Minimum password length'),
            'emailAccountVerification'       => Yii::t('UserModule.user', 'Confirm account by Email'),
            'showCaptcha'                    => Yii::t('UserModule.user', 'Show captcha on registration'),
            'minCaptchaLength'               => Yii::t('UserModule.user', 'Minimum captcha length'),
            'maxCaptchaLength'               => Yii::t('UserModule.user', 'Maximum captcha length'),
            'documentRoot'                   => Yii::t('UserModule.user', 'Server root'),
            'avatarsDir'                     => Yii::t('UserModule.user', 'Directory for avatar uploading'),
            'avatarMaxSize'                  => Yii::t('UserModule.user', 'Maximum avatar size'),
            'defaultAvatar'                  => Yii::t('UserModule.user', 'Empty avatar'),
            'loginAdminSuccess'              => Yii::t('UserModule.user', 'Page after admin authorization'),
            'registrationSuccess'            => Yii::t('UserModule.user', 'Page after success register'),
            'sessionLifeTime'                => Yii::t('UserModule.user', 'Session lifetime (in days) when "Remember me" options enabled'),
            'usersPerPage'                   => Yii::t('UserModule.user', 'Users per page'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'userAccountActivationMailEvent',
            'passwordRecoveryMailEvent',
            'passwordSuccessRecoveryMailEvent',
            'passwordAutoRecoveryMailEvent',
            'registrationActivateMailEvent',
            'registrationMailEvent',
            'avatarMaxSize',
            'defaultAvatar',
            'avatarsDir',
            'showCaptcha'              => $this->getChoice(),
            'minCaptchaLength',
            'maxCaptchaLength',            
            'minPasswordLength',
            'autoRecoveryPassword'     => $this->getChoice(),
            'recoveryDisabled'         => $this->getChoice(),
            'registrationDisabled'     => $this->getChoice(),
            'notifyEmailFrom',
            'logoutSuccess',
            'loginSuccess',
            'adminMenuOrder',
            'accountActivationSuccess',
            'accountActivationFailure',
            'loginAdminSuccess',
            'registrationSuccess',
            'sessionLifeTime',
            'usersPerPage',
            'emailAccountVerification'  => $this->getChoice(),
        );
    }

    public function getEditableParamsGroups()
    {
        return array(
            'main' => array(
                'label' => Yii::t('UserModule.user', 'General module settings'),
                'items' => array(
                    'adminMenuOrder',
                    'sessionLifeTime'
                )
            ),
             'avatar' => array(
                'label' => Yii::t('UserModule.user', 'Avatar'),
                'items' => array(
                    'avatarsDir',
                    'avatarMaxSize',
                    'defaultAvatar'
                )
            ),
            'security' => array(
                'label' => Yii::t('UserModule.user', 'Security settings'),
                'items' => array(
                	'registrationDisabled',
                    'recoveryDisabled',
                    'emailAccountVerification',
                    'minPasswordLength',
                    'autoRecoveryPassword',
                    'recoveryDisabled',
                )
            ),
            'captcha' => array(
                'label' => Yii::t('UserModule.user', 'Captcha settings'),
                'items' => array(
                    'showCaptcha',
                    'minCaptchaLength',
                    'maxCaptchaLength'
                )
            ),
            'mail' => array(
                'label' => Yii::t('UserModule.user','Mail notices'),
                'items' => array(
                    'notifyEmailFrom',
                    'userAccountActivationMailEvent',
                    'passwordRecoveryMailEvent',
                    'passwordSuccessRecoveryMailEvent',
                    'passwordAutoRecoveryMailEvent',
                    'registrationActivateMailEvent',
                    'registrationMailEvent',
                )
            ),
            'redirects' => array(
                'label' => Yii::t('UserModule.user','Redirecting'),
                'items' => array(
                    'logoutSuccess',
                    'loginSuccess',
                    'accountActivationSuccess',
                    'accountActivationFailure',
                    'loginAdminSuccess',
                    'registrationSuccess'
                )
            ),
        );
    }

    public function getAdminPageLink()
    {
        return '/user/userBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('UserModule.user', 'Users')),
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Manage users'), 'url' => array('/user/userBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('UserModule.user', 'Create user'), 'url' => array('/user/userBackend/create')),
            array('label' => Yii::t('UserModule.user', 'Tokens')),
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Token list'), 'url' => array('/user/tokensBackend/index')),
        );
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getIsNoDisable()
    {
        return true;
    }

    public function getName()
    {
        return Yii::t('UserModule.user', 'Users');
    }

    public function getCategory()
    {
        return Yii::t('UserModule.user', 'Yupe!');
    }

    public function getDescription()
    {
        return Yii::t('UserModule.user', 'Module for user registration and authorization management');
    }

    public function getAuthor()
    {
        return Yii::t('UserModule.user', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return 'team@yupe.ru';
    }

    public function getUrl()
    {
        return 'http://yupe.ru';
    }

    public function getVersion()
    {
        return Yii::t('UserModule.user', '0.6');
    }

    public function getIcon()
    {
        return 'user';
    }

    public function getConditions()
    {
        return array(
            'isAuthenticated' => array(
                'name'      => Yii::t('UserModule.user','Authorized'),
                'condition' => Yii::app()->user->isAuthenticated(),
            ),
            'isSuperUser'     => array(
                'name'      => Yii::t('UserModule.user','Administrator'),
                'condition' => Yii::app()->user->isSuperUser(),
            ),
        );
    }

    public function init()
    {
        $this->setImport(array(
            'user.models.*',
            'user.components.*',
            'user.widgets.AvatarWidget'
        ));

        parent::init();
    }

    /**
     * Событие происходящее в момент входа пользователя на страницу регистрации.
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['registrationForm'] передается объект формы RegistrationForm.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onBeginRegistration($event)
    {
        $this->raiseEvent('onBeginRegistration', $event);
    }

    /**
     * Событие происходящее при успешной регистрации пользователя.
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['user'] передается объект класса User.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onSuccessRegistration($event)
    {
        $this->raiseEvent('onSuccessRegistration', $event);
    }

    /**
     * Событие происходящее при ошибке регистрации.
     * Возникает при неправильной валидации или при ошибке записи в базу нового пользователя
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['registrationForm'] передается объект формы RegistrationForm.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onErrorRegistration($event)
    {
        $this->raiseEvent('onErrorRegistration', $event);
    }

    /**
     * Событие происходящее при запросе на восстановление пароля.
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['token'] передается Token восстановления.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onBeginPasswordRecovery($event)
    {
        $this->raiseEvent('onBeginPasswordRecovery', $event);
    }

    /**
     * Событие возникающее при успшеном автоматическом восстановлении пароля
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['token'] передается Token восстановления.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onSuccessAutoPasswordRecovery($event)
    {
        $this->raiseEvent('onSuccessAutoPasswordRecovery', $event);
    }

    /**
     * Событие возникающее при ошибке автоматического восстановления пароля.
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['token'] передается Token восстановления.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onErrorAutoPasswordRecovery($event)
    {
        $this->raiseEvent('onErrorAutoPasswordRecovery', $event);
    }

    /**
     * Событие возникающее при успешной ручной смене пароля.
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['changePasswordForm'] передается объект ChangePasswordForm.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onSuccessPasswordRecovery($event)
    {
        $this->raiseEvent('onSuccessPasswordRecovery', $event);
    }

    /**
     * Событие возникающее при ошибке ручного восстановления пароля.
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['changePasswordForm'] передается объект ChangePasswordForm.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onErrorPasswordRecovery($event)
    {
        $this->raiseEvent('onErrorPasswordRecovery', $event);
    }

    /**
    * Событие возникающее при активации экшена запроса восстановления пароля.
    * В качестве отправителя выступает объект класса AccountController
    * Параметром $params['recoveryForm'] передается объект RecoveryForm.
    * @param CModelEvent $event
    * @since 0.7
    */
    public function onBeginRecovery($event)
    {
        $this->raiseEvent('onBeginRecovery', $event);
    }

    /**
     * Событие возникающее при успешном запросе восстановления пароля.
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['recoveryForm'] передается объект RecoveryForm.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onSuccessRecovery($event)
    {
        $this->raiseEvent('onSuccessRecovery', $event);
    }

    /**
     * Событие возникающее при ошибке запроса восстановления пароля.
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['recoveryForm'] передается объект RecoveryForm.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onErrorRecovery($event)
    {
        $this->raiseEvent('onErrorRecovery', $event);
    }

    /**
     * Событие возникающее при входе пользователя на страницу редактирования профиля.
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['profileForm'] передается объект ProfileForm.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onBeginProfile($event)
    {
        $this->raiseEvent('onBeginProfile', $event);
    }

    /**
     * Событие возникающее при успешном обновлении профиля пользователя.
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['profileForm'] передается объект ProfileForm.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onSuccessEditProfile($event)
    {
        $this->raiseEvent('onSuccessEditProfile', $event);
    }

    /**
     * Событие возникающее при ошибке обновления профиля пользователя.
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['profileForm'] передается объект ProfileForm.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onErrorEditProfile($event)
    {
        $this->raiseEvent('onErrorEditProfile', $event);
    }

    /**
     * Событие возникающее при выходе пользователя из Аккаунта
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['user'] передается объект пользователя который совершает выход.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onLogout($event)
    {
        $this->raiseEvent('onLogout', $event);
    }

    /**
     * Событие возникающее при успешном входе пользователя
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['loginForm'] передается объект формы авторизации.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onSuccessLogin($event)
    {
        $this->raiseEvent('onSuccessLogin', $event);
    }

    /**
     * Событие возникающее при ошибке входа пользователя
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['loginForm'] передается объект формы авторизации.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onErrorLogin($event)
    {
        $this->raiseEvent('onErrorLogin', $event);
    }

    /**
     * Событие возникающее при успешном подтверждании e-mail
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['token'] передается Token подтверждения e-mail.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onSuccessEmailConfirm($event)
    {
        $this->raiseEvent('onSuccessEmailConfirm', $event);
    }

    /**
     * Событие возникающее при ошибке подтверждания e-mail
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['token'] передается Token подтверждения e-mail.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onErrorEmailConfirm($event)
    {
        $this->raiseEvent('onErrorEmailConfirm', $event);
    }

    /**
     * Событие возникающее при успешной активации аккаунта
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['token'] передается Token активации.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onSuccessActivate($event)
    {
        $this->raiseEvent('onSuccessActivate', $event);
    }

    /**
     * Событие возникающее при ошибке активации аккаунта
     * В качестве отправителя выступает объект класса AccountController
     * Параметром $params['token'] передается Token активации.
     * @param CModelEvent $event
     * @since 0.7
     */
    public function onErrorActivate($event)
    {
        $this->raiseEvent('onErrorActivate', $event);
    }

}