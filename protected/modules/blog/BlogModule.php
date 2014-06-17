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
    const VERSION = '0.7';

    public $mainPostCategory;
    public $minSize           = 0;
    public $maxSize           = 5368709120;
    public $maxFiles          = 1;
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $uploadPath        = 'blogs';
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
        $membersCnt = UserToBlog::model()->count('status = :status', array(':status' => UserToBlog::STATUS_CONFIRMATION));

        if($membersCnt) {
            $messages[WebModule::CHECK_NOTICE][] = array(
                'type' => WebModule::CHECK_NOTICE,
                'message' => Yii::t('BlogModule.blog', '{count} new members of blog wait for confirmation!', array(
                            '{count}' => CHtml::link($membersCnt, array('/blog/userToBlogBackend/index', 'UserToBlog[status]' => UserToBlog::STATUS_CONFIRMATION, 'order' => 'id.desc'))
                        ))
            );
        }

        $postsCount = Post::model()->count('status = :status', array(':status' => Post::STATUS_MODERATED));

        if($postsCount) {
            $messages[WebModule::CHECK_NOTICE][] = array(
                'type' => WebModule::CHECK_NOTICE,
                'message' => Yii::t('BlogModule.blog', '{count} new posts wait for moderation!', array(
                            '{count}' => CHtml::link($postsCount, array('/blog/postBackend/index', 'Post[status]' => Post::STATUS_MODERATED, 'order' => 'id.desc'))
                        ))
            );
        }

        return (isset($messages[WebModule::CHECK_ERROR]) || isset($messages[WebModule::CHECK_NOTICE]) ) ? $messages : true;
    }

    public function getPanelWidget()
    {
        $cacheTime = Yii::app()->controller->yupe->coreCacheTime;

        $dataProvider = new CActiveDataProvider('Post', array(
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
            'pagination'=>array(
                'pageSize'=>3,
            ),
        ));

        Yii::app()->controller->widget(
            'bootstrap.widgets.TbBox',
            array(
                'title' => Yii::t('BlogModule.blog', 'Blogs'),
                'headerIcon' => 'icon-pencil',
                'content' =>  Yii::app()->controller->renderPartial('application.modules.blog.views.blogBackend.blog-panel', array(
                            'postsCount'    => Post::model()->cache($cacheTime)->count('create_date >= :time', array(':time' => time() - 24 * 60 * 60)),
                            'commentCount'  => Comment::model()->cache($cacheTime)->count('creation_date >= (CURDATE() - INTERVAL 1 DAY)'),
                            'allPostsCnt'   => Post::model()->cache($cacheTime)->count(),
                            'allCommentCnt' => Comment::model()->cache($cacheTime)->count(),
                            'usersCount'  => User::model()->cache($cacheTime)->count('registration_date >= (CURDATE() - INTERVAL 1 DAY)'),
                            'allUsersCnt' => User::model()->cache($cacheTime)->count(),
                            'dataProvider' => $dataProvider
                        ), true)
            )
        );
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
            'uploadPath'        => Yii::t('BlogModule.blog', 'File directory (relatively {path})', array('{path}' => Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule("yupe")->uploadPath)),
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
            'editor' => Yii::app()->getModule('yupe')->getEditors(),
            'mainCategory' => CHtml::listData($this->getCategoryList(),'id','name'),
            'mainPostCategory' => CHtml::listData($this->getCategoryList(),'id','name'),
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
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Blog list'), 'url' => array('/blog/blogBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'New blog'), 'url' => array('/blog/blogBackend/create')),
            array('icon' => 'icon-folder-open', 'label' => Yii::t('BlogModule.blog', 'Blogs categories'), 'url' => array('/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory)),
            array('label' => Yii::t('BlogModule.blog', 'Posts')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Post list'), 'url' => array('/blog/postBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'New post'), 'url' => array('/blog/postBackend/create')),
            array('icon' => 'icon-folder-open', 'label' => Yii::t('BlogModule.blog', 'Posts categories'), 'url' => array('/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory)),
            array('label' => Yii::t('BlogModule.blog', 'Members')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Member list'), 'url' => array('/blog/userToBlogBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'New member'), 'url' => array('/blog/userToBlogBackend/create')),
        );
    }

    public  function getVersion()
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
        return "pencil";
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

        $this->setImport(array(
            'blog.listeners.*',
            'blog.events.*',
            'blog.models.*',
            'blog.components.*',
            'vendor.yiiext.taggable-behavior.*',
        ));
    }
}