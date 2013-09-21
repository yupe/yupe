<?php

class QueueModule extends yupe\components\WebModule
{
    public function  getVersion()
    {
        return Yii::t('QueueModule.queue', '0.1');
    }

    public function getCategory()
    {
        return Yii::t('QueueModule.queue', 'Services');
    }

    public function getName()
    {
        return Yii::t('QueueModule.queue', 'Tasks');
    }

    public function getDescription()
    {
        return Yii::t('QueueModule.queue', 'Tasks creation and management module');
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
            array('icon' => 'list-alt', 'label' => Yii::t('QueueModule.queue', 'Task list'), 'url' => array('/queue/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('QueueModule.queue', 'Create task'), 'url' => array('/queue/default/create')),
            array('icon' => 'trash', 'label' => Yii::t('QueueModule.queue', 'Clean queue'), 'url' => array('/queue/default/clear')),
        );
    }
}