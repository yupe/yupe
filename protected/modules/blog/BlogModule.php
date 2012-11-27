<?php
class BlogModule extends YWebModule
{
    public $editor = 'application.modules.yupe.widgets.editors.imperaviRedactor.EImperaviRedactorWidget';

    public function getCategory()
    {
        return Yii::t('blog', 'Контент');
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('blog', 'Порядок следования в меню'),
            'editor'         => Yii::t('blog', 'Визуальный редактор'),
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
            array('label' => Yii::t('blog', 'Блоги')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить блог'), 'url' => array('/blog/BlogAdmin/create')),
            array('icon' => 'th-list', 'label' => Yii::t('blog', 'Список блогов'), 'url' => array('/blog/BlogAdmin/index')),
            array('label' => Yii::t('blog', 'Записи')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить запись'), 'url' => array('/blog/PostAdmin/create')),
            array('icon' => 'th-list', 'label' => Yii::t('blog', 'Список записей'), 'url' => array('/blog/PostAdmin/index')),
            array('label' => Yii::t('blog', 'Участники')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить участника'), 'url' => array('/blog/UserToBlogAdmin/create')),
            array('icon' => 'th-list', 'label' => Yii::t('blog', 'Список участников'), 'url' => array('/blog/UserToBlogAdmin/index')),
        );
    }

    public  function getVersion()
    {
        return '0.2 (dev)';
    }

    public function getName()
    {
        return Yii::t('blog', 'Блоги');
    }

    public function getDescription()
    {
        return Yii::t('blog', 'Модуль для построения личного блога или блогового сообщества');
    }

    public function getAuthor()
    {
        return Yii::t('blog', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('blog', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('blog', 'http://yupe.ru');
    }

    public function getAdminPageLink()
    {
        return '/blog/blogAdmin/admin/';
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