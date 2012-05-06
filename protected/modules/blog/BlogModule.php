<?php
class BlogModule extends YWebModule
{
    public $editor = 'application.modules.yupe.widgets.editors.imperaviRedactor.EImperaviRedactorWidget';

    public function getCategory()
    {
        return Yii::t('blog', 'Блоги');
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('news', 'Порядок следования в меню'),
            'editor' => Yii::t('page', 'Визуальный редактор'),
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
            Yii::t('blog', 'Блоги') => '/blog/blogAdmin/admin/',
            Yii::t('blog', 'Записи') => '/blog/postAdmin/admin/',
            Yii::t('blog', 'Участники') => '/blog/userToBlogAdmin/admin/',
        );
    }

    public  function getVersion()
    {
        return '0.1 (dev)';
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

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'blog.models.*',
            'blog.components.*',
        ));
    }
}