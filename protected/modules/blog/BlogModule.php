<?php
/**
 * BlogModule основной класс модуля blog
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog
 * @since 0.1
 *
 */
use yupe\components\WebModule;

/**
 * Class BlogModule
 */
class BlogModule extends yupe\components\WebModule
{
    /**
     *
     */
    const VERSION = '1.2';

    /**
     * @var
     */
    public $mainPostCategory;
    /**
     * @var int
     */
    public $minSize = 0;
    /**
     * @var int
     */
    public $maxSize = 5368709120;
    /**
     * @var int
     */
    public $maxFiles = 1;
    /**
     * @var string
     */
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    /**
     * @var string
     */
    public $mimeTypes = 'image/gif, image/jpeg, image/png';
    /**
     * @var string
     */
    public $uploadPath = 'blogs';
    /**
     * @var int
     */
    public $rssCount = 10;

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            'user',
            'category',
            'comment',
            'image',
            'notify',
        ];
    }

    /**
     * @return array|bool
     */
    public function checkSelf()
    {
        $messages = [];
        // count moderated users
        $membersCnt = UserToBlog::model()->count(
            'status = :status',
            [':status' => UserToBlog::STATUS_CONFIRMATION]
        );

        if ($membersCnt) {
            $messages[WebModule::CHECK_NOTICE][] = [
                'type' => WebModule::CHECK_NOTICE,
                'message' => Yii::t(
                    'BlogModule.blog',
                    '{count} new members of blog wait for confirmation!',
                    [
                        '{count}' => CHtml::link(
                            $membersCnt,
                            [
                                '/blog/userToBlogBackend/index',
                                'UserToBlog[status]' => UserToBlog::STATUS_CONFIRMATION,
                                'order' => 'id.desc',
                            ]
                        ),
                    ]
                ),
            ];
        }

        $postsCount = Post::model()->count('status = :status', [':status' => Post::STATUS_MODERATED]);

        if ($postsCount) {
            $messages[WebModule::CHECK_NOTICE][] = [
                'type' => WebModule::CHECK_NOTICE,
                'message' => Yii::t(
                    'BlogModule.blog',
                    '{count} new posts wait for moderation!',
                    [
                        '{count}' => CHtml::link(
                            $postsCount,
                            [
                                '/blog/postBackend/index',
                                'Post[status]' => Post::STATUS_MODERATED,
                                'order' => 'id.desc',
                            ]
                        ),
                    ]
                ),
            ];
        }

        return (isset($messages[WebModule::CHECK_ERROR]) || isset($messages[WebModule::CHECK_NOTICE])) ? $messages : true;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('BlogModule.blog', 'Content');
    }

    /**
     * @return string
     */
    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule(
                "yupe"
            )->uploadPath . DIRECTORY_SEPARATOR . $this->uploadPath;
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'mainCategory' => Yii::t('BlogModule.blog', 'Main blog category'),
            'mainPostCategory' => Yii::t('BlogModule.blog', 'Main posts category'),
            'editor' => Yii::t('BlogModule.blog', 'Visual editor'),
            'uploadPath' => Yii::t(
                'BlogModule.blog',
                'File directory (relatively {path})',
                [
                    '{path}' => Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule(
                            "yupe"
                        )->uploadPath,
                ]
            ),
            'allowedExtensions' => Yii::t('BlogModule.blog', 'Allowed extensions (separated by comma)'),
            'minSize' => Yii::t('BlogModule.blog', 'Minimum size (in bytes)'),
            'maxSize' => Yii::t('BlogModule.blog', 'Maximum size (in bytes)'),
            'rssCount' => Yii::t('BlogModule.blog', 'RSS records count'),
        ];
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'editor' => Yii::app()->getModule('yupe')->getEditors(),
            'mainCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'mainPostCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'uploadPath',
            'allowedExtensions',
            'minSize',
            'maxSize',
            'rssCount',
        ];
    }


    /**
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return [
            '0.category' => [
                'label' => Yii::t('BlogModule.blog', 'Categories'),
                'items' => [
                    'mainPostCategory',
                    'mainCategory',
                ],
            ],
            '1.images' => [
                'label' => Yii::t('BlogModule.blog', 'Images'),
                'items' => [
                    'uploadPath',
                    'allowedExtensions',
                    'minSize',
                    'maxSize',
                ],
            ],
            '2.editor' => [
                'label' => Yii::t('BlogModule.blog', 'Visual editor settings'),
                'items' => [
                    'editor',
                ],
            ],
        ];
    }

    /**
     * @return static[]
     */
    public function getCategoryListForPost()
    {
        return $this->getCategoryList();
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            ['label' => Yii::t('BlogModule.blog', 'Blogs')],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Blog list'),
                'url' => ['/blog/blogBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'New blog'),
                'url' => ['/blog/blogBackend/create'],
            ],
            [
                'icon' => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('BlogModule.blog', 'Blogs categories'),
                'url' => [
                    '/category/categoryBackend/index',
                    'module' => $this->getId(),
                    'parent' => $this->mainCategory ?: null
                ],
            ],
            ['label' => Yii::t('BlogModule.blog', 'Posts')],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Post list'),
                'url' => ['/blog/postBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'New post'),
                'url' => ['/blog/postBackend/create'],
            ],
            [
                'icon' => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('BlogModule.blog', 'Posts categories'),
                'url' => [
                    '/category/categoryBackend/index',
                    'module' => $this->getId(),
                    'parent' => $this->mainPostCategory ?: null
                ],
            ],
            ['label' => Yii::t('BlogModule.blog', 'Members')],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Member list'),
                'url' => ['/blog/userToBlogBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'New member'),
                'url' => ['/blog/userToBlogBackend/create'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('BlogModule.blog', self::VERSION);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('BlogModule.blog', 'Blogs');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('BlogModule.blog', 'This module allows building a personal blog or a blogging community');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('BlogModule.blog', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('BlogModule.blog', 'team@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('BlogModule.blog', 'http://yupe.ru');
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/blog/blogBackend/index';
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return "fa fa-fw fa-pencil";
    }

    /**
     * Возвращаем статус, устанавливать ли галку для установки модуля в инсталяторе по умолчанию:
     *
     * @return bool
     **/
    public function getIsInstallDefault()
    {
        return true;
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'blog.listeners.*',
                'blog.events.*',
                'blog.models.*',
                'blog.components.*',
                'vendor.yiiext.taggable-behavior.*',
            ]
        );
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'Blog.BlogManager',
                'description' => Yii::t('BlogModule.blog', 'Manage blogs'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    //blogs
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.BlogBackend.Create',
                        'description' => Yii::t('BlogModule.blog', 'Creating blog'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.BlogBackend.Delete',
                        'description' => Yii::t('BlogModule.blog', 'Removing blog'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.BlogBackend.Index',
                        'description' => Yii::t('BlogModule.blog', 'List of blogs'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.BlogBackend.Update',
                        'description' => Yii::t('BlogModule.blog', 'Editing blog'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.BlogBackend.View',
                        'description' => Yii::t('BlogModule.blog', 'Viewing blogs'),
                    ],
                    //posts
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.PostBackend.Create',
                        'description' => Yii::t('BlogModule.blog', 'Creating post'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.PostBackend.Delete',
                        'description' => Yii::t('BlogModule.blog', 'Removing post'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.PostBackend.Index',
                        'description' => Yii::t('BlogModule.blog', 'List of posts'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.PostBackend.Update',
                        'description' => Yii::t('BlogModule.blog', 'Editing post'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.PostBackend.View',
                        'description' => Yii::t('BlogModule.blog', 'Viewing post'),
                    ],
                    //members
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.UserToBlogBackend.Create',
                        'description' => Yii::t('BlogModule.blog', 'Creating member'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.UserToBlogBackend.Delete',
                        'description' => Yii::t('BlogModule.blog', 'Removing member'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.UserToBlogBackend.Index',
                        'description' => Yii::t('BlogModule.blog', 'List of members'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.UserToBlogBackend.Update',
                        'description' => Yii::t('BlogModule.blog', 'Editing member'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Blog.UserToBlogBackend.View',
                        'description' => Yii::t('BlogModule.blog', 'Viewing member'),
                    ],
                ],
            ],
        ];
    }
}
