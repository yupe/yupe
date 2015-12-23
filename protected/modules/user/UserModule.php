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
    const VERSION = '0.9.9';

    public $accountActivationSuccess = '/user/account/login';
    public $accountActivationFailure = '/user/account/registration';
    public $loginSuccess = '/';
    public $registrationSuccess = '/user/account/login';
    public $loginAdminSuccess = '/yupe/backend/index';
    public $logoutSuccess = '/';
    public $sessionLifeTime = 7;

    public $notifyEmailFrom;
    public $autoRecoveryPassword = 0;
    public $recoveryDisabled = 0;
    public $registrationDisabled = 0;
    public $minPasswordLength = 8;
    public $emailAccountVerification = 1;
    public $showCaptcha = 0;
    public $minCaptchaLength = 3;
    public $maxCaptchaLength = 6;
    public $documentRoot;
    public $avatarsDir = 'avatars';
    public $avatarMaxSize = 5242880; // 5 MB
    public $defaultAvatarPath = 'images/avatar.png';
    public $avatarExtensions = 'jpg,png,gif,jpeg';
    public $usersPerPage = 20;
    public $badLoginCount = 3;
    public $phoneMask = '+7-999-999-9999';
    public $phonePattern = '/^((\+?7)(-?\d{3})-?)?(\d{3})(-?\d{4})$/';
    public $generateNickName = 0;

    public static $logCategory = 'application.modules.user';
    public $profiles = [];

    private $defaultAvatar;

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . '/' .
        Yii::app()->getModule('yupe')->uploadPath . '/' .
        $this->avatarsDir . '/';
    }

    public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir($this->getUploadPath(), 0755);
        }

        return false;
    }

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

    public function getEditableParamsGroups()
    {
        return [
            'main' => [
                'label' => Yii::t('UserModule.user', 'General module settings'),
                'items' => [
                    'sessionLifeTime',
                    'generateNickName',
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
            'security' => [
                'label' => Yii::t('UserModule.user', 'Security settings'),
                'items' => [
                    'registrationDisabled',
                    'recoveryDisabled',
                    'emailAccountVerification',
                    'minPasswordLength',
                    'autoRecoveryPassword',
                    'recoveryDisabled',
                    'badLoginCount'
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

    public function getAdminPageLink()
    {
        return '/user/userBackend/index';
    }

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
        return Yii::t('UserModule.user', 'Users');
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
        return self::VERSION;
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-user';
    }

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
