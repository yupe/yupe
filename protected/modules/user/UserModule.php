<?php
class UserModule extends YWebModule
{
    public $accountActivationSuccess       = '/user/account/login';
    public $accountActivationFailure       = '/user/account/registration';
    public $loginSuccess;
    public $registrationSucess             = '/user/account/login';
    public $loginAdminSuccess              = '';
    public $logoutSuccess;
    public $sessionLifeTime                = 7;

    public $notifyEmailFrom;
    public $autoRecoveryPassword           = true;
    public $recoveryDisabled               = false;
    public $registrationDisabled           = false;
    public $minPasswordLength              = 5;
    public $emailAccountVerification       = true;
    public $showCaptcha                    = true;
    public $minCaptchaLength               = 3;
    public $maxCaptchaLength               = 6;
    public $documentRoot;
    public $avatarsDir;
    public $avatarMaxSize                  = 10000;
    public $defaultAvatar                  = '/web/images/avatar.png';
    public $avatarExtensions               = array('jpg', 'png', 'gif');

    public $registrationActivateMailEvent  = 'USER_REGISTRATION_ACTIVATE';
    public $registrationMailEvent          = 'USER_REGISTRATION';
    public $passwordAutoRecoveryMailEvent  = 'USER_PASSWORD_AUTO_RECOVERY';
    public $passwordRecoveryMailEvent      = 'USER_PASSWORD_RECOVERY';
    public $passwordSuccessRecoveryMailEvent = 'USER_PASSWORD_SUCCESS_RECOVERY';
    public $userAccountActivationMailEvent   = 'USER_ACCOUNT_ACTIVATION';

    public static $logCategory             = 'application.modules.user';
    public $autoNick                       = false;
    public $profiles                       = array();
    public $attachedProfileEvents          = array();

    public function getParamsLabels()
    {
        return array(
            'userAccountActivationMailEvent'   => Yii::t('UserModule.user', 'Почтовое событие при успешной активации пользователя'),
            'passwordSuccessRecoveryMailEvent' => Yii::t('UserModule.user', 'Почтовое событие при успешном восстановлении пароля'),
            'passwordAutoRecoveryMailEvent'  => Yii::t('UserModule.user', 'Почтовое событие при автоматическом восстановлении пароля'),
            'passwordRecoveryMailEvent'      => Yii::t('UserModule.user', 'Почтовое событие при восстановлении пароля'),
            'registrationActivateMailEvent'  => Yii::t('UserModule.user', 'Почтовое событие при регистрации нового пользователя с активацией'),
            'registrationMailEvent'          => Yii::t('UserModule.user', 'Почтовое событие при регистрации нового пользователя без активации'),
            'adminMenuOrder'                 => Yii::t('UserModule.user', 'Порядок следования в меню'),
            'accountActivationSuccess'       => Yii::t('UserModule.user', 'Страница после активации аккаунта'),
            'accountActivationFailure'       => Yii::t('UserModule.user', 'Страница неудачной активации аккаунта'),
            'loginSuccess'                   => Yii::t('UserModule.user', 'Страница после авторизации'),
            'logoutSuccess'                  => Yii::t('UserModule.user', 'Страница после выхода с сайта'),
            'notifyEmailFrom'                => Yii::t('UserModule.user', 'Email от имени которого отправлять сообщение'),
            'autoRecoveryPassword'           => Yii::t('UserModule.user', 'Автоматическое восстановление пароля'),
            'recoveryDisabled'               => Yii::t('UserModule.user', 'Отключить восстановление пароля'),
            'registrationDisabled'           => Yii::t('UserModule.user', 'Отключить регистрацию'),
            'minPasswordLength'              => Yii::t('UserModule.user', 'Минимальная длина пароля'),
            'emailAccountVerification'       => Yii::t('UserModule.user', 'Подтверждать аккаунт по Email'),
            'showCaptcha'                    => Yii::t('UserModule.user', 'Показывать капчу при регистрации'),
            'minCaptchaLength'               => Yii::t('UserModule.user', 'Минимальная длинна капчи'),
            'maxCaptchaLength'               => Yii::t('UserModule.user', 'Максимальная длинна капчи'),
            'documentRoot'                   => Yii::t('UserModule.user', 'Корень сервера'),
            'avatarsDir'                     => Yii::t('UserModule.user', 'Каталог для загрузки аватарок'),
            'avatarMaxSize'                  => Yii::t('UserModule.user', 'Максимальный размер аватарки'),
            'defaultAvatar'                  => Yii::t('UserModule.user', 'Пустой аватар'),
            'loginAdminSuccess'              => Yii::t('UserModule.user', 'Страница после авторизации админстратора'),
            'registrationSucess'             => Yii::t('UserModule.user', 'Страница после успешной регистрации'),
            'autoNick'                       => Yii::t('UserModule.user', 'Автоматически генерировать уникальный ник и не требовать его указания'),
            'sessionLifeTime'                => Yii::t('UserModule.user', 'Время жизни сессии (в днях) при включенной опции "Запомнить меня"'),
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
            'emailAccountVerification' => $this->getChoice(),
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
            'registrationSucess',
            'autoNick'                 => $this->getChoice(),
            'sessionLifeTime'
        );
    }

    public function getEditableParamsGroups()
    {
        return array(
            'main' => array(
                'label' => Yii::t('YupeModule.yupe', 'Основные настройки модуля'),
                'items' => array(
                    'adminMenuOrder',
                    'sessionLifeTime'
                )
            ),
            'security' => array(
                'label' => Yii::t('UserModule.user', 'Настройки безопасности'),
                'items' => array(
                	'registrationDisabled',
                    'emailAccountVerification',
                    'minPasswordLength',
                    'autoRecoveryPassword',
                    'recoveryDisabled',
                )
            ),
            'captcha' => array(
                'label' => Yii::t('UserModule.user', 'Настройки капчи'),
                'items' => array(
                    'showCaptcha',
                    'minCaptchaLength',
                    'maxCaptchaLength'
                )
            ),
            'mail' => array(
                'label' => Yii::t('UserModule.user','Почтовые уведомления'),
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
                'label' => Yii::t('UserModule.user','Перенаправления'),
                'items' => array(
                    'logoutSuccess',
                    'loginSuccess',
                    'accountActivationSuccess',
                    'accountActivationFailure',
                    'loginAdminSuccess',
                    'registrationSucess'
                )
            ),
        );
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('UserModule.user', 'Пользователи')),
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Управление пользователями'), 'url' => array('/user/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('UserModule.user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
            array('label' => Yii::t('UserModule.user', 'Восстановления паролей')),
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Восстановления паролей'), 'url' => array('/user/recoveryPassword/index')),
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
        return Yii::t('UserModule.user', 'Пользователи');
    }

    public function getCategory()
    {
        return Yii::t('UserModule.user', 'Юпи!');
    }

    public function getDescription()
    {
        return Yii::t('UserModule.user', 'Модуль для управления пользователями, регистрацией и авторизацией');
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
        return Yii::t('UserModule.user', '0.4');
    }

    public function getIcon()
    {
        return 'user';
    }

    public function getConditions()
    {
        return array(
            'isAuthenticated' => array(
                'name'      => 'Авторизован',
                'condition' => Yii::app()->user->isAuthenticated(),
            ),
            'isSuperUser'     => array(
                'name'      => 'Администратор',
                'condition' => Yii::app()->user->isSuperUser(),
            ),
        );
    }

    public function init()
    {
        parent::init();

        $homeUrl = '/' . Yii::app()->defaultController . '/index';

        if (!$this->loginSuccess)
            $this->loginSuccess = $homeUrl;

        if (!$this->logoutSuccess)
            $this->logoutSuccess = $homeUrl;

        $this->setImport(array(
            'user.models.*',
            'user.components.*',
        ));

        if (is_array($this->attachedProfileEvents))
        {
            foreach ($this->attachedProfileEvents as $e)
            {
                $this->attachEventHandler("onBeginRegistration", array($e, "onBeginRegistration"));
                $this->attachEventHandler("onBeginProfile", array($e, "onBeginProfile"));
            }
        }
    }

    public function onBeginRegistration($event)
    {
        $this->raiseEvent('onBeginRegistration', $event);
    }

    public function onBeginProfile($event)
    {
        $this->raiseEvent('onBeginProfile', $event);
    }

}