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
class BlogModule extends yupe\components\WebModule
{  
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
            'comment'
        );
    }

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . '/' . Yii::app()->getModule('yupe')->uploadPath . '/' . $this->uploadPath . '/';
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
            'rssCount'          => Yii::t('BlogModule.blog', 'RSS records count'),
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
            array('label' => Yii::t('BlogModule.blog', 'Posts')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Post list'), 'url' => array('/blog/postBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'New post'), 'url' => array('/blog/postBackend/create')),
            array('label' => Yii::t('BlogModule.blog', 'Members')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Member list'), 'url' => array('/blog/userToBlogBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'New member'), 'url' => array('/blog/userToBlogBackend/create')),
        );
    }

    public  function getVersion()
    {
        return Yii::t('BlogModule.blog', '0.6');
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

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'blog.models.*',
            'blog.components.*',
            'yupe.extensions.taggable.*',
        ));
    }
}