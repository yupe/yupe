<?php
use yupe\components\WebModule;

class SocialModule extends WebModule
{
    const VERSION = '0.9.1';

    public $controllerNamespace = '\application\modules\social\controllers';

    public function getDependencies()
    {
        return [
            'user',
        ];
    }

    public function getEditableParams()
    {
        return [];
    }

    public function getParamsLabels()
    {
        return [];
    }

    public function getCategory()
    {
        return Yii::t('SocialModule.social', 'Users');
    }

    public function getName()
    {
        return Yii::t('SocialModule.social', 'Socialization');
    }

    public function getDescription()
    {
        return Yii::t('SocialModule.social', 'Module for login and registration via social networks');
    }

    public function getAuthor()
    {
        return 'amylabs team';
    }

    public function getAuthorEmail()
    {
        return Yii::t('SocialModule.social', 'hello@amylabs.ru');
    }

    public function getVersion()
    {
        return Yii::t('SocialModule.social', self::VERSION);
    }

    public function getUrl()
    {
        return Yii::t('SocialModule.social', 'http://amylabs.ru');
    }

    public function getAdminPageLink()
    {
        return '/social/socialBackend/index';
    }

    public function getIcon()
    {
        return "fa fa-fw fa-globe";
    }

    public function getNavigation()
    {
        return [
            ['label' => Yii::t('SocialModule.social', 'Users')],
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('SocialModule.social', 'Accounts'),
                'url'   => ['/social/socialBackend/index']
            ],
        ];
    }

    public function init()
    {
        parent::init();
    }

    public function getAuthItems()
    {
        return [
            [
                'name'        => 'Social.SocialManager',
                'description' => Yii::t('SocialModule.social', 'Manage social accounts'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Social.SocialBackend.Delete',
                        'description' => Yii::t('SocialModule.social', 'Removing social account')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Social.SocialBackend.Index',
                        'description' => Yii::t('SocialModule.social', 'List of social accounts')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Social.SocialBackend.View',
                        'description' => Yii::t('SocialModule.social', 'Viewing social account')
                    ],
                ]
            ]
        ];
    }
}
