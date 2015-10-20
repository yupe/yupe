<?php
/**
 * Модуль "Обратный звонок"
 *
 * @package  yupe.modules.callback
 * @author   Oleg Filimonov <olegsabian@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.9.9
 **/
use \yupe\components\WebModule;

class CallbackModule extends WebModule
{
    const VERSION = '0.9.9';

    public $notifyEmailFrom;

    public $notifyEmailsTo;

    public $phoneMask = '+7(999)999-99-99';

    public function getDependencies()
    {
        return ['mail'];
    }

    public function getEditableParams()
    {
        return [
            'notifyEmailFrom',
            'notifyEmailsTo',
            'phoneMask',
        ];
    }

    public function getParamsLabels()
    {
        return [
            'notifyEmailFrom' => Yii::t('CallbackModule.callback', 'Notification email'),
            'notifyEmailsTo'  => Yii::t('CallbackModule.callback', 'Recipients of notifications (comma separated)'),
            'phoneMask' => Yii::t('CallbackModule.callback', 'Phone mask'),
        ];
    }

    public function getEditableParamsGroups()
    {
        return [
            '1.notify' => [
                'label' => Yii::t('CallbackModule.callback', 'Params'),
                'items' => [
                    'notifyEmailFrom',
                    'notifyEmailsTo',
                    'phoneMask',
                ],
            ],
        ];
    }

    public function checkSelf()
    {
        $messages = [];
        $callbacksCount = Callback::model()->new()->count();

        if(!$callbacksCount) {
            return false;
        }

        $messages[WebModule::CHECK_NOTICE][] = [
            'type' => WebModule::CHECK_NOTICE,
            'message' => Yii::t('CallbackModule.callback', 'New requests: {count}', [
                '{count}' => CHtml::link($callbacksCount, [
                    '/callback/callbackBackend/index',
                    'Callback[status]' => Callback::STATUS_NEW
                ])
            ])
        ];

        return $messages;
    }

    public function getCategory()
    {
        return Yii::t('CallbackModule.callback', 'Services');
    }

    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-phone',
                'label' => Yii::t('CallbackModule.callback', 'Messages'),
                'url' => ['/callback/callbackBackend/index']
            ],
        ];
    }

    public function getAdminPageLink()
    {
        return '/callback/callbackBackend/index';
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getName()
    {
        return Yii::t('CallbackModule.callback', 'Callback');
    }

    public function getDescription()
    {
        return Yii::t('CallbackModule.callback', 'Callback messages management module');
    }

    public function getAuthor()
    {
        return Yii::t('CallbackModule.callback', 'Oleg Filimonov');
    }

    public function getAuthorEmail()
    {
        return Yii::t('CallbackModule.callback', 'olegsabian@gmail.com');
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-phone';
    }

    public function init()
    {
        parent::init();

        $this->setImport([
            'callback.models.*',
        ]);
    }

    public function getAuthItems()
    {
        return [
            [
                'type' => AuthItem::TYPE_TASK,
                'name' => 'Callback.CallbackBackend.Management',
                'description' => Yii::t('CallbackModule.callback', 'Manage messages'),
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Callback.CallbackBackend.Index',
                        'description' => Yii::t('CallbackModule.callback', 'View messages list'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Callback.CallbackBackend.Update',
                        'description' => Yii::t('CallbackModule.callback', 'Update messages'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Callback.CallbackBackend.Delete',
                        'description' => Yii::t('CallbackModule.callback', 'Delete messages'),
                    ],
                ],
            ],
        ];
    }

    public function getNotifyTo()
    {
        return explode(',', $this->notifyEmailsTo);
    }
}