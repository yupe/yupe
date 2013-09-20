<?php
class BlogModule extends yupe\components\WebModule
{
    public $mainCategory;
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

    public function getCategoryList()
    {
        $criteria = ($this->mainCategory)
            ? array(
                'condition' => 'id = :id OR parent_id = :id',
                'params'    => array(':id' => $this->mainCategory),
                'order'     => 'id ASC',
            )
            : array();

        return Category::model()->findAll($criteria);
    }

    public function getCategoryListForPost()
    {
        $criteria = ($this->mainPostCategory)
            ? array(
                'condition' => 'id = :id OR parent_id = :id',
                'params'    => array(':id' => $this->mainPostCategory),
                'order'     => 'id ASC',
            )
            : array();

        return Category::model()->findAll($criteria);
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('BlogModule.blog', 'Blogs')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Blogs list'), 'url' => array('/blog/blogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'New blog'), 'url' => array('/blog/blogAdmin/create')),
            array('label' => Yii::t('BlogModule.blog', 'Posts')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Posts list'), 'url' => array('/blog/postAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'New post'), 'url' => array('/blog/postAdmin/create')),
            array('label' => Yii::t('BlogModule.blog', 'Members')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Members list'), 'url' => array('/blog/userToBlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'New member'), 'url' => array('/blog/userToBlogAdmin/create')),
        );
    }

    public  function getVersion()
    {
        return Yii::t('BlogModule.blog', '0.4');
    }

    public function getName()
    {
        return Yii::t('BlogModule.blog', 'Blogs');
    }

    public function getDescription()
    {
        return Yii::t('BlogModule.blog', 'Module for building a personal blog or blogging community');
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
        return '/blog/blogAdmin/index';
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
        ));
    }
}