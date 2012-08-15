<?php
class UserModule extends YWebModule
{
    public $accountActivationSuccess = '/user/account/login';

    public $accountActivationFailure = '/user/account/registration';

    public $loginSuccess;

    public $registrationSucess = '/user/account/login';

    public $loginAdminSuccess = '';

    public $logoutSuccess;

    public $notifyEmailFrom;

    public $autoRecoveryPassword = true;

    public $minPasswordLength = 3;

    public $emailAccountVerification = true;

    public $showCaptcha = true;

    public $minCaptchaLength = 3;

    public $maxCaptchaLength = 6;

    public $documentRoot;

    public $avatarsDir;

    public $avatarMaxSize = 10000;

    public $defaultAvatar = '/web/images/avatar.png';

    public $avatarExtensions = array('jpg', 'png', 'gif');

    public $invalidIpAction = '/user/account/notAllowedIp';

    public $invalidEmailAction = '/user/account/notallowedemail';

    public $ipBlackList;

    public $emailBlackList;

    public $registrationMailEventActivate = 'USER_REGISTRATION_ACTIVATE';

    public $registrationMailEvent = 'USER_REGISTRATION';

    public $passwordAutoRecoveryMailEvent = 'USER_PASSWORD_AUTO_RECOVERY';

    public $passwordRecoveryMailEvent = 'USER_PASSWORD_RECOVERY';

    public $passwordSuccessRecovery = 'USER_PASSWORD_SUCCESS_RECOVERY';

    public $userAccountActivationMailEvent = 'USER_ACCOUNT_ACTIVATION';

    public static $logCategory = 'application.modules.user';

    public function checkSelf()
    {
        $superAdmin = User::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->admin()->find();
        if ($superAdmin->password == User::hashPassword('123456', $superAdmin->salt) || $superAdmin->email == 'admin@admind.ru')
            return array(
                'type' => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'У Вас не изменен пароли или email, указанный, при установке, по умолчанию! {link}', array(
                    '{link}' => CHtml::link(Yii::t('yupe', 'Изменить настройки'), array( '/user/default/admin/', 'module' => 'user' )),
                )),
            );

        return true;
    }

    public function getParamsLabels()
    {
        return array(
            'userAccountActivationMailEvent'    => Yii::t('user', 'Почтовое событие при успешной активации пользователя'),
            'passwordSuccessRecovery'           => Yii::t('user', 'Почтовое событие при успешном восстановлении пароля'),
            'passwordAutoRecoveryMailEvent'     => Yii::t('user', 'Почтовое событие при автоматическом восстановлении пароля'),
            'passwordRecoveryMailEvent'         => Yii::t('user', 'Почтовое событие при восстановлении пароля'),
            'registrationMailEventActivate'     => Yii::t('user', 'Почтовое событие при регистрации нового пользователя с активацией'),
            'registrationMailEvent'             => Yii::t('user', 'Почтовое событие при регистрации нового пользователя без активации'),
            'adminMenuOrder'                    => Yii::t('user', 'Порядок следования в меню'),
            'accountActivationSuccess'          => Yii::t('user', 'Страница после активации аккаунта'),
            'accountActivationFailure'          => Yii::t('user', 'Страница неудачной активации аккаунта'),
            'loginSuccess'                      => Yii::t('user', 'Страница после авторизации'),
            'logoutSuccess'                     => Yii::t('user', 'Страница после выхода с сайта'),
            'notifyEmailFrom'                   => Yii::t('user', 'Email от имени которого отправлять сообщение'),
            'autoRecoveryPassword'              => Yii::t('user', 'Автоматическое восстановление пароля'),
            'minPasswordLength'                 => Yii::t('user', 'Минимальная длина пароля'),
            'emailAccountVerification'          => Yii::t('user', 'Подтверждать аккаунт по Email'),
            'showCaptcha'                       => Yii::t('user', 'Показывать капчу при регистрации'),
            'minCaptchaLength'                  => Yii::t('user', 'Минимальная длина капчи'),
            'maxCaptchaLength'                  => Yii::t('user', 'Максимальная длина капчи'),
            'documentRoot'                      => Yii::t('user', 'Корень сервера'),
            'avatarsDir'                        => Yii::t('user', 'Каталог для загрузки аватарок'),
            'avatarMaxSize'                     => Yii::t('user', 'Максимальный размер аватарки'),
            'defaultAvatar'                     => Yii::t('user', 'Пустой аватар'),
            'invalidIpAction'                   => Yii::t('user', 'Страница для заблокированных IP'),
            'invalidEmailAction'                => Yii::t('user', 'Страница для заблокированных Email'),
            'loginAdminSuccess'                 => Yii::t('user', 'Страница после авторизации админстратора'),
            'registrationSucess'                => Yii::t('user', 'Страница после успешной регистрации'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'userAccountActivationMailEvent',
            'passwordRecoveryMailEvent',
            'passwordSuccessRecovery',
            'passwordAutoRecoveryMailEvent',
            'registrationMailEventActivate',
            'registrationMailEvent',
            'avatarMaxSize',
            'defaultAvatar',
            'avatarsDir',
            'minCaptchaLength',
            'maxCaptchaLength',
            'showCaptcha' => $this->getChoice(),
            'emailAccountVerification' => $this->getChoice(),
            'minPasswordLength',
            'autoRecoveryPassword' => $this->getChoice(),
            'notifyEmailFrom',
            'logoutSuccess',
            'loginSuccess',
            'adminMenuOrder',
            'accountActivationSuccess',
            'accountActivationFailure',
            'loginAdminSuccess',
            'registrationSucess',
        );
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('user', 'Пользователи')),
            array('icon' => 'th-large', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/admin')),
            array('icon' => 'th-list', 'label' => Yii::t('user', 'Список пользователей'), 'url' => array('/user/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
            array('label' => Yii::t('user', 'Восстановления паролей')),
            array('icon' => 'th-large', 'label' => Yii::t('user', 'Управление восстановлением паролей'), 'url' => array('/user/recoveryPassword/admin')),
            array('icon' => 'th-list', 'label' => Yii::t('user', 'Список восстановлений'), 'url' => array('/user/recoveryPassword/index')),
        );
    }

    public function getName()
    {
        return Yii::t('user', 'Пользователи');
    }

    public function getCategory()
    {
        return Yii::t('user', 'Пользователи');
    }

    public function getDescription()
    {
        return Yii::t('user', 'Модуль для управления пользователями, регистрацией и авторизацией');
    }

    public function getAuthor()
    {
        return Yii::t('user', 'yupe team');
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
        return '0.3';
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
            'isSuperUser' => array(
                'name'      => 'Администратор',
                'condition' => Yii::app()->user->isSuperUser(),
            ),
        );
    }

    public function init()
    {
        parent::init();

        if (!$this->loginSuccess)
            $this->loginSuccess = '/' . Yii::app()->defaultController;

        if (!$this->logoutSuccess)
            $this->logoutSuccess = '/' . Yii::app()->defaultController;

        $this->setImport(array(
            'user.models.*',
            'user.components.*',
        ));
    }

    public function isAllowedEmail($email)
    {
        if (is_array($this->emailBlackList) && count($this->emailBlackList))
        {
            if (in_array(trim($email), $this->emailBlackList))
                return false;
        }

        return true;
    }

    public function isAllowedIp($ip)
    {
        if (is_array($this->ipBlackList) && count($this->ipBlackList))
        {
            if (in_array($ip, $this->ipBlackList))
                return false;
        }

        return true;
    }
}