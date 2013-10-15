<?php

/**
 * QueueModule основной класс модуля queue
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.queue
 * @version   0.6
 *
 */

class QueueModule extends yupe\components\WebModule
{
    public function  getVersion()
    {
        return Yii::t('QueueModule.queue', '0.6');
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
        return '/queue/queueBackend/index';
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
            array('icon' => 'list-alt', 'label' => Yii::t('QueueModule.queue', 'Task list'), 'url' => array('/queue/queueBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('QueueModule.queue', 'Create task'), 'url' => array('/queue/queueBackend/create')),
            array('icon' => 'trash', 'label' => Yii::t('QueueModule.queue', 'Clean queue'), 'url' => array('/queue/queueBackend/clear')),
        );
    }
}