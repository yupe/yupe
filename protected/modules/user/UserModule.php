<?php

/**
 * UserModule основной класс модуля user
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2014 amyLabs && Yupe! team
 * @package yupe.modules.user
 * @since 0.1
 *
 */

use yupe\components\WebModule;

/**
 * Class UserModule
 */
class UserModule extends WebModule
{
    /**
     *
     */
    const VERSION = '1.1';

    /**
     * @var string
     */
    public $accountActivationSuccess = '/user/account/login';
    /**
     * @var string
     */
    public $accountActivationFailure = '/user/account/registration';
    /**
     * @var string
     */
    public $loginSuccess = '/';
    /**
     * @var string
     */
    public $registrationSuccess = '/user/account/login';
    /**
     * @var string
     */
    public $loginAdminSuccess = '/yupe/backend/index';
    /**
     * @var string
     */
    public $logoutSuccess = '/';
    /**
     * @var int
     */
    public $sessionLifeTime = 7;

    /**
     * @var
     */
    public $notifyEmailFrom;
    /**
     * @var int
     */
    public $autoRecoveryPassword = 0;
    /**
     * @var int
     */
    public $recoveryDisabled = 0;
    /**
     * @var int
     */
    public $registrationDisabled = 0;
    /**
     * @var int
     */
    public $minPasswordLength = 8;
    /**
     * @var int
     */
    public $emailAccountVerification = 1;
    /**
     * @var int
     */
    public $showCaptcha = 0;
    /**
     * @var int
     */
    public $minCaptchaLength = 3;
    /**
     * @var int
     */
    public $maxCaptchaLength = 6;
    /**
     * @var
     */
    public $documentRoot;
    /**
     * @var string
     */
    public $avatarsDir = 'avatars';
    /**
     * @var int
     */
    public $avatarMaxSize = 5242880; // 5 MB
    /**
     * @var string
     */
    public $defaultAvatarPath = 'images/avatar.png';
    /**
     * @var string
     */
    public $avatarExtensions = 'jpg,png,gif,jpeg';
    /**
     * @var int
     */
    public $usersPerPage = 20;
    /**
     * @var int
     */
    public $badLoginCount = 3;
    /**
     * @var string
     */
    public $phoneMask = '+7-999-999-9999';
    /**
     * @var string
     */
    public $phonePattern = '/^((\+?7)(-?\d{3})-?)?(\d{3})(-?\d{4})$/';
    /**
     * @var int
     */
    public $generateNickName = 0;

    /**
     * @var string
     */
    public static $logCategory = 'application.modules.user';
    /**
     * @var array
     */
    public $profiles = [];

    /**
     * @var
     */
    private $defaultAvatar;

    /**
     * @return string
     */
    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . '/' .
        Yii::app()->getModule('yupe')->uploadPath . '/' .
        $this->avatarsDir . '/';
    }

    /**
     * @return bool
     */
    public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir($this->getUploadPath(), 0755);
        }

        return false;
    }

    /**
     * @return array|bool
     */
    public function checkSelf()
    {
        $messages = [];

        if (!$this->avatarsDir) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type' => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                    'UserModule.user',
                    'Please, choose avatars directory! {link}',
                    [
                        '{link}' => CHtml::link(
                            Yii::t('UserModule.user', 'Edit module settings'),
                            [
                                '/yupe/backend/modulesettings/',
                                'module' => $this->id,
                            ]
                        ),
                    ]
                ),
            ];
        }

        if (!is_dir($this->getUploadPath()) || !is_writable($this->getUploadPath())) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type' => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                    'UserModule.user',
                    'Directory is not accessible "{dir}" for write or not exists! {link}',
                    [
                        '{dir}' => $this->getUploadPath(),
                        '{link}' => CHtml::link(
                            Yii::t('UserModule.user', 'Edit module settings'),
                            [
                                '/yupe/backend/modulesettings/',
                                'module' => $this->id,
                            ]
                        ),
                    ]
                ),
            ];
        }

        return (isset($messages[WebModule::CHECK_ERROR])) ? $messages : true;
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'accountActivationSuccess' => Yii::t('UserModule.user', 'Page after account activation'),
            'accountActivationFailure' => Yii::t('UserModule.user', 'Page after activation error'),
            'loginSuccess' => Yii::t('UserModule.user', 'Page after authorization'),
            'logoutSuccess' => Yii::t('UserModule.user', 'Page after logout'),
            'notifyEmailFrom' => Yii::t('UserModule.user', 'From which email send a message'),
            'autoRecoveryPassword' => Yii::t('UserModule.user', 'Automatic password recovery'),
            'recoveryDisabled' => Yii::t('UserModule.user', 'Disable password recovery'),
            'registrationDisabled' => Yii::t('UserModule.user', 'Disable registration'),
            'minPasswordLength' => Yii::t('UserModule.user', 'Minimum password length'),
            'emailAccountVerification' => Yii::t('UserModule.user', 'Confirm account by Email'),
            'showCaptcha' => Yii::t('UserModule.user', 'Show captcha on registration'),
            'minCaptchaLength' => Yii::t('UserModule.user', 'Minimum captcha length'),
            'maxCaptchaLength' => Yii::t('UserModule.user', 'Maximum captcha length'),
            'documentRoot' => Yii::t('UserModule.user', 'Server root'),
            'avatarExtensions' => Yii::t('UserModule.user', 'Avatar extensions'),
            'avatarsDir' => Yii::t('UserModule.user', 'Directory for avatar uploading'),
            'avatarMaxSize' => Yii::t('UserModule.user', 'Maximum avatar size'),
            'defaultAvatarPath' => Yii::t('UserModule.user', 'Empty avatar'),
            'loginAdminSuccess' => Yii::t('UserModule.user', 'Page after admin authorization'),
            'registrationSuccess' => Yii::t('UserModule.user', 'Page after success register'),
            'sessionLifeTime' => Yii::t(
                'UserModule.user',
                'Session lifetime (in days) when "Remember me" options enabled'
            ),
            'usersPerPage' => Yii::t('UserModule.user', 'Users per page'),
            'badLoginCount' => Yii::t('UserModule.user', 'Number of login attempts'),
            'phoneMask' => Yii::t('UserModule.user', 'Phone - mask'),
            'phonePattern' => Yii::t('UserModule.user', 'Phone - pattern'),
            'generateNickName' => Yii::t('UserModule.user', 'Generate user name automatically')
        ];
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'avatarMaxSize',
            'avatarExtensions',
            'defaultAvatarPath',
            'avatarsDir',
            'showCaptcha' => $this->getChoice(),
            'minCaptchaLength',
            'maxCaptchaLength',
            'minPasswordLength',
            'autoRecoveryPassword' => $this->getChoice(),
            'recoveryDisabled' => $this->getChoice(),
            'registrationDisabled' => $this->getChoice(),
            'notifyEmailFrom',
            'logoutSuccess',
            'loginSuccess',
            'accountActivationSuccess',
            'accountActivationFailure',
            'loginAdminSuccess',
            'registrationSuccess',
            'sessionLifeTime',
            'usersPerPage',
            'emailAccountVerification' => $this->getChoice(),
            'badLoginCount',
            'phoneMask',
            'phonePattern',
            'generateNickName' => $this->getChoice(),
        ];
    }

    /**
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return [
            'security' => [
                'label' => Yii::t('UserModule.user', 'Security settings'),
                'items' => [
                    'sessionLifeTime',
                    'generateNickName',
                    'registrationDisabled',
                    'recoveryDisabled',
                    'emailAccountVerification',
                    'minPasswordLength',
                    'autoRecoveryPassword',
                    'badLoginCount'
                ]
            ],
            'avatar' => [
                'label' => Yii::t('UserModule.user', 'Avatar'),
                'items' => [
                    'avatarExtensions',
                    'avatarsDir',
                    'avatarMaxSize',
                    'defaultAvatarPath'
                ]
            ],
            'captcha' => [
                'label' => Yii::t('UserModule.user', 'Captcha settings'),
                'items' => [
                    'showCaptcha',
                    'minCaptchaLength',
                    'maxCaptchaLength'
                ]
            ],
            'redirects' => [
                'label' => Yii::t('UserModule.user', 'Redirecting'),
                'items' => [
                    'logoutSuccess',
                    'loginSuccess',
                    'accountActivationSuccess',
                    'accountActivationFailure',
                    'loginAdminSuccess',
                    'registrationSuccess'
                ]
            ],
            'phone' => [
                'label' => Yii::t('UserModule.user', 'Phone'),
                'items' => [
                    'phoneMask',
                    'phonePattern'
                ]
            ],
        ];
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/user/userBackend/index';
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            ['label' => Yii::t('UserModule.user', 'Users')],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('UserModule.user', 'Manage users'),
                'url' => ['/user/userBackend/index']
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('UserModule.user', 'Create user'),
                'url' => ['/user/userBackend/create']
            ],
            ['label' => Yii::t('UserModule.user', 'Tokens')],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('UserModule.user', 'Token list'),
                'url' => ['/user/tokensBackend/index']
            ],
        ];
    }

    /**
     * @return bool
     */
    public function getIsInstallDefault()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function getIsNoDisable()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('UserModule.user', 'Users');
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('UserModule.user', 'Users');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('UserModule.user', 'Module for user registration and authorization management');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('UserModule.user', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return 'team@yupe.ru';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'https://yupe.ru';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-fw fa-user';
    }

    /**
     * @return array
     */
    public function getConditions()
    {
        return [
            'isAuthenticated' => [
                'name' => Yii::t('UserModule.user', 'Authorized'),
                'condition' => Yii::app()->getUser()->isAuthenticated(),
            ],
            'isSuperUser' => [
                'name' => Yii::t('UserModule.user', 'Administrator'),
                'condition' => Yii::app()->getUser()->isSuperUser(),
            ],
        ];
    }

    /**
     *
     */
    public function init()
    {
        $this->setImport(
            [
                'user.models.*',
                'user.events.*',
                'user.listeners.*',
                'user.components.*',
                'user.widgets.AvatarWidget',
                'yupe.YupeModule'
            ]
        );

        parent::init();
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'User.UserManager',
                'description' => Yii::t('UserModule.user', 'Manage users'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'User.UserBackend.Create',
                        'description' => Yii::t('UserModule.user', 'Creating user')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'User.UserBackend.Delete',
                        'description' => Yii::t('UserModule.user', 'Removing user')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'User.UserBackend.Index',
                        'description' => Yii::t('UserModule.user', 'List of users')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'User.UserBackend.Update',
                        'description' => Yii::t('UserModule.user', 'Editing users')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'User.UserBackend.View',
                        'description' => Yii::t('UserModule.user', 'Viewing users')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'User.UserBackend.Changepassword',
                        'description' => Yii::t('UserModule.user', 'Change password')
                    ],
                    //tokens
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'User.TokensBackend.Delete',
                        'description' => Yii::t('UserModule.user', 'Removing user token')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'User.TokensBackend.Index',
                        'description' => Yii::t('UserModule.user', 'List of user tokens')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'User.TokensBackend.Update',
                        'description' => Yii::t('UserModule.user', 'Editing user tokens')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'User.TokensBackend.View',
                        'description' => Yii::t('UserModule.user', 'Viewing user tokens')
                    ],
                ]
            ]
        ];
    }

    /**
     * Возвращает аватар по умолчанию из текущей темы (<theme_name>/web/images/avatar.png)
     * @since 0.8
     * @return string
     */
    public function getDefaultAvatar()
    {
        if (null === $this->defaultAvatar) {
            $this->defaultAvatar = Yii::app()->getTheme()->getAssetsUrl() . '/' . $this->defaultAvatarPath;
        }

        return $this->defaultAvatar;
    }
}
