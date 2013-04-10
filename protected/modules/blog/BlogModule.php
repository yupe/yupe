<?php
class BlogModule extends YWebModule
{
    public $mainCategory;

    public function getDependencies()
    {
        return array(
            'user',
            'category',
            'comment'
        );
    }

    public function getCategory()
    {
        return Yii::t('BlogModule.blog', 'Контент');
    }

    public function getParamsLabels()
    {
        return array(
            'mainCategory'   => Yii::t('BlogModule.blog', 'Главная категория блогов'),
            'adminMenuOrder' => Yii::t('BlogModule.blog', 'Порядок следования в меню'),
            'editor'         => Yii::t('BlogModule.blog', 'Визуальный редактор'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor' => Yii::app()->getModule('yupe')->getEditors(),
            'mainCategory' => CHtml::listData($this->getCategoryList(),'id','name'),
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

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('BlogModule.blog', 'Блоги')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Список блогов'), 'url' => array('/blog/blogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить блог'), 'url' => array('/blog/blogAdmin/create')),
            array('label' => Yii::t('BlogModule.blog', 'Записи')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Список записей'), 'url' => array('/blog/postAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить запись'), 'url' => array('/blog/postAdmin/create')),
            array('label' => Yii::t('BlogModule.blog', 'Участники')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Список участников'), 'url' => array('/blog/userToBlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить участника'), 'url' => array('/blog/userToBlogAdmin/create')),
        );
    }

    public  function getVersion()
    {
        return Yii::t('BlogModule.blog', '0.3');
    }

    public function getName()
    {
        return Yii::t('BlogModule.blog', 'Блоги');
    }

    public function getDescription()
    {
        return Yii::t('BlogModule.blog', 'Модуль для построения личного блога или блогового сообщества');
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