<?php

/**
 * NewsModule основной класс модуля news
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.news
 * @since 0.1
 *
 */

use yupe\components\WebModule;

class NewsModule extends WebModule
{
    const VERSION = '0.9.2';

    public $uploadPath = 'news';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize = 0;
    public $maxSize = 5368709120;
    public $maxFiles = 1;
    public $rssCount = 10;
    public $perPage = 10;

    public function getDependencies()
    {
        return [
            'user',
            'category',
        ];
    }

    public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir(Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->uploadPath, 0755);
        }

        return false;
    }

    public function checkSelf()
    {
        $messages = [];

        $uploadPath = Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->uploadPath;

        if (!is_writable($uploadPath)) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        'NewsModule.news',
                        'Directory "{dir}" is not accessible for write! {link}',
                        [
                            '{dir}'  => $uploadPath,
                            '{link}' => CHtml::link(
                                    Yii::t('NewsModule.news', 'Change settings'),
                                    [
                                        '/yupe/backend/modulesettings/',
                                        'module' => 'news',
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
            'mainCategory'      => Yii::t('NewsModule.news', 'Main news category'),
            'adminMenuOrder'    => Yii::t('NewsModule.news', 'Menu items order'),
            'editor'            => Yii::t('NewsModule.news', 'Visual Editor'),
            'uploadPath'        => Yii::t(
                    'NewsModule.news',
                    'Uploading files catalog (relatively {path})',
                    [
                        '{path}' => Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule(
                                "yupe"
                            )->uploadPath
                    ]
                ),
            'allowedExtensions' => Yii::t('NewsModule.news', 'Accepted extensions (separated by comma)'),
            'minSize'           => Yii::t('NewsModule.news', 'Minimum size (in bytes)'),
            'maxSize'           => Yii::t('NewsModule.news', 'Maximum size (in bytes)'),
            'rssCount'          => Yii::t('NewsModule.news', 'RSS records'),
            'perPage'           => Yii::t('NewsModule.news', 'News per page')
        ];
    }

    public function getEditableParams()
    {
        return [
            'adminMenuOrder',
            'editor'       => Yii::app()->getModule('yupe')->getEditors(),
            'mainCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'uploadPath',
            'allowedExtensions',
            'minSize',
            'maxSize',
            'rssCount',
            'perPage'
        ];
    }

    public function getEditableParamsGroups()
    {
        return [
            'main'   => [
                'label' => Yii::t('NewsModule.news', 'General module settings'),
                'items' => [
                    'adminMenuOrder',
                    'editor',
                    'mainCategory'
                ]
            ],
            'images' => [
                'label' => Yii::t('NewsModule.news', 'Images settings'),
                'items' => [
                    'uploadPath',
                    'allowedExtensions',
                    'minSize',
                    'maxSize'
                ]
            ],
            'list'   => [
                'label' => Yii::t('NewsModule.news', 'News lists'),
                'items' => [
                    'rssCount',
                    'perPage'
                ]
            ],
        ];
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getCategory()
    {
        return Yii::t('NewsModule.news', 'Content');
    }

    public function getName()
    {
        return Yii::t('NewsModule.news', 'News');
    }

    public function getDescription()
    {
        return Yii::t('NewsModule.news', 'Module for creating and management news');
    }

    public function getAuthor()
    {
        return Yii::t('NewsModule.news', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('NewsModule.news', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('NewsModule.news', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "fa fa-fw fa-bullhorn";
    }

    public function getAdminPageLink()
    {
        return '/news/newsBackend/index';
    }

    public function getNavigation()
    {
        return [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('NewsModule.news', 'News list'),
                'url'   => ['/news/newsBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('NewsModule.news', 'Create article'),
                'url'   => ['/news/newsBackend/create']
            ],
            [
                'icon'  => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('NewsModule.news', 'News categories'),
                'url'   => ['/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory]
            ],
        ];
    }

    public function isMultiLang()
    {
        return true;
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'news.models.*'
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'name'        => 'News.NewsManager',
                'description' => Yii::t('NewsModule.news', 'Manage news'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'News.NewsBackend.Create',
                        'description' => Yii::t('NewsModule.news', 'Creating news')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'News.NewsBackend.Delete',
                        'description' => Yii::t('NewsModule.news', 'Removing news')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'News.NewsBackend.Index',
                        'description' => Yii::t('NewsModule.news', 'List of news')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'News.NewsBackend.Update',
                        'description' => Yii::t('NewsModule.news', 'Editing news')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'News.NewsBackend.Inline',
                        'description' => Yii::t('NewsModule.news', 'Editing news')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'News.NewsBackend.View',
                        'description' => Yii::t('NewsModule.news', 'Viewing news')
                    ],
                ]
            ]
        ];
    }
}
