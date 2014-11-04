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
    const VERSION = '0.9';

    public $workerNamesMap;

    public function getWorkerNamesMap()
    {
        return $this->workerNamesMap;
    }

    public function getVersion()
    {
        return self::VERSION;
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
        return 'fa fa-fw fa-tasks';
    }

    public function getAdminPageLink()
    {
        return '/queue/queueBackend/index';
    }

    public function init()
    {
        $this->setImport(
            array(
                'application.modules.queue.models.*',
                'application.modules.queue.components.*'
            )
        );

        parent::init();
    }

    public function getNavigation()
    {
        return array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('QueueModule.queue', 'Task list'),
                'url'   => array('/queue/queueBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('QueueModule.queue', 'Create task'),
                'url'   => array('/queue/queueBackend/create')
            ),
            array(
                'icon'  => 'fa fa-fw fa-trash-o',
                'label' => Yii::t('QueueModule.queue', 'Clean queue'),
                'url'   => array('/queue/queueBackend/clear')
            ),
        );
    }

    public function getAuthItems()
    {
        return array(
            array(
                'name'        => 'Queue.QueueManager',
                'description' => Yii::t('QueueModule.queue', 'Manage queue'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => array(
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.Create',
                        'description' => Yii::t('QueueModule.queue', 'Creating queue')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.Delete',
                        'description' => Yii::t('QueueModule.queue', 'Removing queue')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.Index',
                        'description' => Yii::t('QueueModule.queue', 'List of queue')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.Update',
                        'description' => Yii::t('QueueModule.queue', 'Editing queue')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.Inline',
                        'description' => Yii::t('QueueModule.queue', 'Editing queue')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.View',
                        'description' => Yii::t('QueueModule.queue', 'Viewing queue')
                    ),
                )
            )
        );
    }
}
