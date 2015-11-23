<?php
use yupe\components\WebModule;

/**
 * Class SocialModule
 */
class SocialModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @var string
     */
    public $controllerNamespace = '\application\modules\social\controllers';

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            'user',
        ];
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('SocialModule.social', 'Users');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('SocialModule.social', 'Socialization');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('SocialModule.social', 'Module for login and registration via social networks');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return 'amylabs team';
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('SocialModule.social', 'hello@amylabs.ru');
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('SocialModule.social', self::VERSION);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('SocialModule.social', 'http://amylabs.ru');
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/social/socialBackend/index';
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return "fa fa-fw fa-globe";
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            ['label' => Yii::t('SocialModule.social', 'Users')],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('SocialModule.social', 'Accounts'),
                'url' => ['/social/socialBackend/index'],
            ],
        ];
    }

    /**
     *
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'Social.SocialManager',
                'description' => Yii::t('SocialModule.social', 'Manage social accounts'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Social.SocialBackend.Delete',
                        'description' => Yii::t('SocialModule.social', 'Removing social account'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Social.SocialBackend.Index',
                        'description' => Yii::t('SocialModule.social', 'List of social accounts'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Social.SocialBackend.View',
                        'description' => Yii::t('SocialModule.social', 'Viewing social account'),
                    ],
                ],
            ],
        ];
    }
}
