<?php
class BlogModule extends YWebModule
{
    public function getDependencies()
    {
        return array(
            'user',
            'category'
        );
    }

    public function getCategory()
    {
        return Yii::t('BlogModule.blog', 'Контент');
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('BlogModule.blog', 'Порядок следования в меню'),
            'editor'         => Yii::t('BlogModule.blog', 'Визуальный редактор'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor' => Yii::app()->getModule('yupe')->getEditors(),
        );
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('BlogModule.blog', 'Блоги')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Список блогов'), 'url' => array('/admin/blog')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить блог'), 'url' => array('/admin/blog/create')),
            array('label' => Yii::t('BlogModule.blog', 'Записи')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Список записей'), 'url' => array('/admin/blog/post/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить запись'), 'url' => array('/admin/blog/post/create')),
            array('label' => Yii::t('BlogModule.blog', 'Участники')),
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Список участников'), 'url' => array('/admin/blog/userToBlog/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить участника'), 'url' => array('/admin/blog/userToBlog/create')),
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
        return '/admin/blog';
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