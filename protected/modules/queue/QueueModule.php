<?php

class QueueModule extends YWebModule
{
    public function  getVersion()
    {
        return Yii::t('QueueModule.queue', '0.1');
    }

    public function getCategory()
    {
        return Yii::t('QueueModule.queue', 'Сервисы');
    }

    public function getName()
    {
        return Yii::t('QueueModule.queue', 'Задания');
    }

    public function getDescription()
    {
        return Yii::t('QueueModule.queue', 'Модуль для создания заданий');
    }

    public function getAuthor()
    {
        return Yii::t('QueueModule.queue', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('QueueModule.queue', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('QueueModule.queue', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return 'tasks';
    }

    public function getAdminPageLink()
    {
        return '/queue/default/index';
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
            array('icon' => 'list-alt', 'label' => Yii::t('QueueModule.queue', 'Список заданий'), 'url' => array('/queue/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('QueueModule.queue', 'Добавить задание'), 'url' => array('/queue/default/create')),
            array('icon' => 'trash', 'label' => Yii::t('QueueModule.queue', 'Очистить очередь'), 'url' => array('/queue/default/clear')),
        );
    }
}