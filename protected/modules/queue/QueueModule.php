<?php

class QueueModule extends YWebModule
{
    public function  getVersion()
    {
        return '0.1 (dev)';
    }

    public function getCategory()
    {
        return Yii::t('queue', 'Система');
    }

    public function getName()
    {
        return Yii::t('queue', 'Задания');
    }

    public function getDescription()
    {
        return Yii::t('queue', 'Модуль для создания заданий');
    }

    public function getAuthor()
    {
        return Yii::t('queue', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('queue', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('queue', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return 'tasks';
    }

    public function getAdminPageLink()
    {
        return '/queue/default/';
    }

    public function init()
    {
        $this->setImport(array(
            'application.modules.queue.models.*',
            'application.modules.queue.components.*'
        ));

        parent::init();
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'th-list', 'label' => Yii::t('queue', 'Задания'), 'url' => array('/queue/default/')),
            array('icon' => 'trash', 'label' => Yii::t('queue', 'Очистить очередь'), 'url' => array('/queue/default/clear/')),
        );
    }
}