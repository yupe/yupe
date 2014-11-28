<?php
/**
 * SmsModule основной класс модуля sms
 *
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 * @package yupe.modules.sms
 *
 */

class SmsModule extends yupe\components\WebModule
{
    const VERSION = '0.2';

    public $api_id;
    public $sender;

	public function getParamsLabels()
	{
		return [
            'api_id'         => Yii::t('SmsModule.sms', 'Sms.ru API ID'),
            'sender'         => Yii::t('SmsModule.sms', 'Sender'),
			'adminMenuOrder' => Yii::t('SmsModule.sms', 'Menu items order'),
		];
	}

	public function getEditableParams()
	{
        $senders_array=Yii::app()->smsru->my_senders()['senders'];
        $senders=[];
        foreach($senders_array as $k=>$v)
            $senders[$v]=$v;
            return [
                'api_id',
                'sender'=>$senders,
		        'adminMenuOrder'
		    ];
	}

    public function getEditableParamsGroups()
    {
        return [
            '0.main' => [
                'label' => Yii::t('SmsModule.sms', 'Main settings'),
                'items' => [
                    'api_id',
                    'sender'
                ]
            ],
            '1.other' => [
                'label' => Yii::t('SmsModule.sms', 'Other'),
                'items' => [
                    'adminMenuOrder'
                ]
            ],
        ];
    }

	/**
     * Метод получения версии:
     *
     * @return string version
     **/
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Метод получения категории:
     *
     * @return string category
     **/
    public function getCategory()
    {
        return Yii::t('SmsModule.sms', 'Services');
    }

    /**
     * Метод получения названия модуля:
     *
     * @return string name
     **/
    public function getName()
    {
        return Yii::t('SmsModule.sms', 'Sms');
    }

    /**
     * Метод получения описвния модуля:
     *
     * @return string description
     **/
    public function getDescription()
    {
        return Yii::t('SmsModule.sms', 'Module for sms message sending');
    }

    /**
     * Метод получения автора модуля:
     *
     * @return string author
     **/
    public function getAuthor()
    {
        return Yii::t('SmsModule.sms', 'Zmiulan');
    }

    /**
     * Метод получения почты автора модуля:
     *
     * @return string author mail
     **/
    public function getAuthorEmail()
    {
        return Yii::t('SmsModule.sms', 'info@yohanga.biz');
    }

    /**
     * Метод получения ссылки на сайт автора модуля:
     *
     * @return string author url
     **/
    public function getUrl()
    {
        return Yii::t('SmsModule.sms', 'http://yohanga.biz');
    }

    /**
     * Метод получения иконки:
     *
     * @return string icon
     **/
    public function getIcon()
    {
        return 'fa fa-fw fa-envelope';
    }

    /**
     * Метод получения адреса модуля в админ панели:
     *
     * @return string admin url
     **/
    public function getAdminPageLink()
    {
        return '/sms/smsBackend/create';
    }

    /**
     * Метод получения меню модуля (для навигации):
     *
     * @return mixed navigation of module
     **/
    public function getNavigation()
    {
        return [
            ['label' => Yii::t('SmsModule.sms', 'Sms send')],
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('SmsModule.sms', 'Sms list'),
                'url'   => ['/sms/smsBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('SmsModule.sms', 'Sms send'),
                'url'   => ['/sms/smsBackend/create']
            ],
        ];
    }

    /**
     * Метод инициализации модуля:
     *
     * @return nothing
     **/
    public function init()
    {
        $this->setImport(
            [
                'sms.models.*',
                'sms.components.*',
                'sms.events.*',
                'sms.listeners.*',
                'yupe.YupeModule',
            ]
        );

        parent::init();
    }

    /**
     * Получаем массив с именами модулей, от которых зависит работа данного модуля
     *
     * @return array Массив с именами модулей, от которых зависит работа данного модуля
     *
     */
    public function getDependencies()
    {
        return ['user'];
    }

    public function getAuthItems()
    {
        return [
            [
                'name'        => 'Sms.SmsManager',
                'description' => Yii::t('SmsModule.sms', 'Manage sms'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    //mail events
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Sms.SmsBackend.Create',
                        'description' => Yii::t('SmsModule.sms', 'Sms send')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Sms.SmsBackend.Index',
                        'description' => Yii::t('SmsModule.sms', 'Sms list')
                    ],
                ]
            ]
        ];
    }
}
