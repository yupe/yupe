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

class BlogModule extends yupe\components\WebModule
{
    const VERSION = '0.9';

    public $mainPostCategory;
    public $minSize = 0;
    public $maxSize = 5368709120;
    public $maxFiles = 1;
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $uploadPath = 'blogs';
    public $rssCount = 10;

    public function getDependencies()
    {
        return array(
            'user',
            'category',
            'comment',
            'image'
        );
    }

    public function checkSelf()
    {
        $messages = array();
        // count moderated users
        $membersCnt = UserToBlog::model()->count(
            'status = :status',
            array(':status' => UserToBlog::STATUS_CONFIRMATION)
        );

        if ($membersCnt) {
            $messages[WebModule::CHECK_NOTICE][] = array(
                'type'    => WebModule::CHECK_NOTICE,
                'message' => Yii::t(
                        'BlogModule.blog',
                        '{count} new members of blog wait for confirmation!',
                        array(
                            '{count}' => CHtml::link(
                                    $membersCnt,
                                    array(
                                        '/blog/userToBlogBackend/index',
                                        'UserToBlog[status]' => UserToBlog::STATUS_CONFIRMATION,
                                        'order'              => 'id.desc'
                                    )
                                )
                        )
                    )
            );
        }

        $postsCount = Post::model()->count('status = :status', array(':status' => Post::STATUS_MODERATED));

        if ($postsCount) {
            $messages[WebModule::CHECK_NOTICE][] = array(
                'type'    => WebModule::CHECK_NOTICE,
                'message' => Yii::t(
                        'BlogModule.blog',
                        '{count} new posts wait for moderation!',
                        array(
                            '{count}' => CHtml::link(
                                    $postsCount,
                                    array(
                                        '/blog/postBackend/index',
                                        'Post[status]' => Post::STATUS_MODERATED,
                                        'order'        => 'id.desc'
                                    )
                                )
                        )
                    )
            );
        }

        return (isset($messages[WebModule::CHECK_ERROR]) || isset($messages[WebModule::CHECK_NOTICE])) ? $messages : true;
    }

    public function getCategory()
    {
        return Yii::t('BlogModule.blog', 'Content');
    }

    public function getParamsLabels()
    {
        return array(
            'mainCategory'      => Yii::t('BlogModule.blog', 'Main blog category'),
            'mainPostCategory'  => Yii::t('BlogModule.blog', 'Main posts category'),
            'adminMenuOrder'    => Yii::t('BlogModule.blog', 'Menu items order'),
            'editor'            => Yii::t('BlogModule.blog', 'Visual editor'),
            'uploadPath'        => Yii::t(
                    'BlogModule.blog',
                    'File directory (relatively {path})',
                    array(
                        '{path}' => Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule(
                                "yupe"
                            )->uploadPath
                    )
                ),
            'allowedExtensions' => Yii::t('BlogModule.blog', 'Allowed extensions (separated by comma)'),
            'minSize'           => Yii::t('BlogModule.blog', 'Minimum size (in bytes)'),
            'maxSize'           => Yii::t('BlogModule.blog', 'Maximum size (in bytes)'),
            'rssCount'          => Yii::t('BlogModule.blog', 'RSS records count')
        );
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor'           => Yii::app()->getModule('yupe')->getEditors(),
            'mainCategory'     => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'mainPostCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'uploadPath',
            'allowedExtensions',
            'minSize',
            'maxSize',
            'rssCount'
        );
    }

    public function getCategoryListForPost()
    {
        return $this->getCategoryList();
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('BlogModule.blog', 'Blogs')),
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Blog list'),
                'url'   => array('/blog/blogBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'New blog'),
                'url'   => array('/blog/blogBackend/create')
            ),
            array(
                'icon'  => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('BlogModule.blog', 'Blogs categories'),
                'url'   => array('/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory)
            ),
            array('label' => Yii::t('BlogModule.blog', 'Posts')),
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Post list'),
                'url'   => array('/blog/postBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'New post'),
                'url'   => array('/blog/postBackend/create')
            ),
            array(
                'icon'  => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('BlogModule.blog', 'Posts categories'),
                'url'   => array('/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory)
            ),
            array('label' => Yii::t('BlogModule.blog', 'Members')),
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Member list'),
                'url'   => array('/blog/userToBlogBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'New member'),
                'url'   => array('/blog/userToBlogBackend/create')
            ),
        );
    }

    public function getVersion()
    {
        return Yii::t('BlogModule.blog', self::VERSION);
    }

    public function getName()
    {
        return Yii::t('BlogModule.blog', 'Blogs');
    }

    public function getDescription()
    {
        return Yii::t('BlogModule.blog', 'This module allows building a personal blog or a blogging community');
    }

    public function getAuthor()
    {
        return Yii::t('BlogModule.blog', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('BlogModule.blog', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('BlogModule.blog', 'http://yupe.ru');
    }

    public function getAdminPageLink()
    {
        return '/blog/blogBackend/index';
    }

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

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'blog.listeners.*',
                'blog.events.*',
                'blog.models.*',
                'blog.components.*',
                'vendor.yiiext.taggable-behavior.*',
            )
        );
    }

    public function getAuthItems()
    {
        return array(
            array(
                'name'        => 'Blog.BlogManager',
                'description' => Yii::t('BlogModule.blog', 'Manage blogs'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => array(

                    //blogs

                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.BlogBackend.Create',
                        'description' => Yii::t('BlogModule.blog', 'Creating blog')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.BlogBackend.Delete',
                        'description' => Yii::t('BlogModule.blog', 'Removing blog')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.BlogBackend.Index',
                        'description' => Yii::t('BlogModule.blog', 'List of blogs')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.BlogBackend.Update',
                        'description' => Yii::t('BlogModule.blog', 'Editing blog')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.BlogBackend.Inline',
                        'description' => Yii::t('BlogModule.blog', 'Editing blog')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.BlogBackend.View',
                        'description' => Yii::t('BlogModule.blog', 'Viewing blogs')
                    ),
                    //posts

                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.PostBackend.Create',
                        'description' => Yii::t('BlogModule.blog', 'Creating post')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.PostBackend.Delete',
                        'description' => Yii::t('BlogModule.blog', 'Removing post')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.PostBackend.Index',
                        'description' => Yii::t('BlogModule.blog', 'List of posts')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.PostBackend.Update',
                        'description' => Yii::t('BlogModule.blog', 'Editing post')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.PostBackend.Inline',
                        'description' => Yii::t('BlogModule.blog', 'Editing post')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.PostBackend.View',
                        'description' => Yii::t('BlogModule.blog', 'Viewing post')
                    ),
                    //members

                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.UserToBlogBackend.Create',
                        'description' => Yii::t('BlogModule.blog', 'Creating member')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.UserToBlogBackend.Delete',
                        'description' => Yii::t('BlogModule.blog', 'Removing member')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.UserToBlogBackend.Index',
                        'description' => Yii::t('BlogModule.blog', 'List of members')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.UserToBlogBackend.Update',
                        'description' => Yii::t('BlogModule.blog', 'Editing member')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.UserToBlogBackend.Inline',
                        'description' => Yii::t('BlogModule.blog', 'Editing member')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Blog.UserToBlogBackend.View',
                        'description' => Yii::t('BlogModule.blog', 'Viewing member')
                    ),

                )
            )
        );
    }
}
