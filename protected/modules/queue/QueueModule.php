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
    const VERSION = '0.9.2';

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
            [
                'application.modules.queue.models.*',
                'application.modules.queue.components.*'
            ]
        );

        parent::init();
    }

    public function getNavigation()
    {
        return [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('QueueModule.queue', 'Task list'),
                'url'   => ['/queue/queueBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('QueueModule.queue', 'Create task'),
                'url'   => ['/queue/queueBackend/create']
            ],
            [
                'icon'  => 'fa fa-fw fa-trash-o',
                'label' => Yii::t('QueueModule.queue', 'Clean queue'),
                'url'   => ['/queue/queueBackend/clear']
            ],
        ];
    }

    public function getAuthItems()
    {
        return [
            [
                'name'        => 'Queue.QueueManager',
                'description' => Yii::t('QueueModule.queue', 'Manage queue'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.Create',
                        'description' => Yii::t('QueueModule.queue', 'Creating queue')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.Delete',
                        'description' => Yii::t('QueueModule.queue', 'Removing queue')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.Index',
                        'description' => Yii::t('QueueModule.queue', 'List of queue')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.Update',
                        'description' => Yii::t('QueueModule.queue', 'Editing queue')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.Inline',
                        'description' => Yii::t('QueueModule.queue', 'Editing queue')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Queue.QueueBackend.View',
                        'description' => Yii::t('QueueModule.queue', 'Viewing queue')
                    ],
                ]
            ]
        ];
    }
}
