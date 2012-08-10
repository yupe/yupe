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
            'adminMenuOrder' => Yii::t('news', 'Порядок следования в меню'),
            'editor'         => Yii::t('page', 'Визуальный редактор'),
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
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить блог'), 'url'=>array('/blog/blogAdmin/create/')),
            array('icon' => 'th-list', 'label' => Yii::t('blog', 'Управление блогами'), 'url'=>array('/blog/blogAdmin/admin/')),
            array('label' => Yii::t('blog', 'Записи')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить запись'), 'url'=>array('/blog/postAdmin/create/')),
            array('icon' => 'th-list', 'label' => Yii::t('blog', 'Управление записями'), 'url'=>array('/blog/postAdmin/admin/')),
            array('label' => Yii::t('blog', 'Участники')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить участника'), 'url'=>array('/blog/postAdmin/create/')),
            array('icon' => 'th-list', 'label' => Yii::t('blog', 'Управление участниками'), 'url'=>array('/blog/postAdmin/admin/')),
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