<?php

/**
 * MailModule основной класс модуля install
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.mail
 * @since 0.1
 *
 */
class MailModule extends yupe\components\WebModule
{
    const VERSION = '0.9.9';

    public function getParamsLabels()
    {
        return [
            'editor' => Yii::t('MailModule.mail', 'Visual editor'),
        ];
    }

    public function getEditableParams()
    {
        return [
            'editor' => Yii::app()->getModule('yupe')->getEditors(),
        ];
    }

    public function getEditableParamsGroups()
    {
        return [
            '1.main' => [
                'label' => Yii::t('MailModule.mail', 'Visual editor settings'),
                'items' => [
                    'editor'
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
        return Yii::t('MailModule.mail', 'Services');
    }

    /**
     * Метод получения названия модуля:
     *
     * @return string name
     **/
    public function getName()
    {
        return Yii::t('MailModule.mail', 'Mail');
    }

    /**
     * Метод получения описвния модуля:
     *
     * @return string description
     **/
    public function getDescription()
    {
        return Yii::t('MailModule.mail', 'Module for mail message management');
    }

    /**
     * Метод получения автора модуля:
     *
     * @return string author
     **/
    public function getAuthor()
    {
        return Yii::t('MailModule.mail', 'yupe team');
    }

    /**
     * Метод получения почты автора модуля:
     *
     * @return string author mail
     **/
    public function getAuthorEmail()
    {
        return Yii::t('MailModule.mail', 'team@yupe.ru');
    }

    /**
     * Метод получения ссылки на сайт автора модуля:
     *
     * @return string author url
     **/
    public function getUrl()
    {
        return Yii::t('MailModule.mail', 'http://yupe.ru');
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
        return '/mail/eventBackend/index';
    }

    /**
     * Метод получения меню модуля (для навигации):
     *
     * @return mixed navigation of module
     **/
    public function getNavigation()
    {
        return [
            ['label' => Yii::t('MailModule.mail', 'Mail events')],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MailModule.mail', 'Messages list'),
                'url' => ['/mail/eventBackend/index']
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MailModule.mail', 'Create event'),
                'url' => ['/mail/eventBackend/create']
            ],
            ['label' => Yii::t('MailModule.mail', 'Mail templates')],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MailModule.mail', 'Templates list'),
                'url' => ['/mail/templateBackend/index']
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MailModule.mail', 'Create template'),
                'url' => ['/mail/templateBackend/create']
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
                'mail.models.*',
                'mail.components.*',
            ]
        );

        parent::init();
    }

    /**
     * Получаем массив с именами модулей, от которых зависит работа данного модуля
     *
     * @return array Массив с именами модулей, от которых зависит работа данного модуля
     *
     * @since 0.5
     */
    public function getDependencies()
    {
        return ['user'];
    }

    public function getAuthItems()
    {
        return [
            [
                'name' => 'Mail.MailManager',
                'description' => Yii::t('MailModule.mail', 'Manage mail events and templates'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    //mail events
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Mail.EventBackend.Create',
                        'description' => Yii::t('MailModule.mail', 'Creating mail event')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Mail.EventBackend.Delete',
                        'description' => Yii::t('MailModule.mail', 'Removing mail event')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Mail.EventBackend.Index',
                        'description' => Yii::t('MailModule.mail', 'List of mail events')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Mail.EventBackend.Update',
                        'description' => Yii::t('MailModule.mail', 'Editing mail events')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Mail.EventBackend.View',
                        'description' => Yii::t('MailModule.mail', 'Viewing mail events')
                    ],
                    //mail templates
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Mail.TemplateBackend.Create',
                        'description' => Yii::t('MailModule.mail', 'Creating mail event template')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Mail.TemplateBackend.Delete',
                        'description' => Yii::t('MailModule.mail', 'Removing mail event template')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Mail.TemplateBackend.Index',
                        'description' => Yii::t('MailModule.mail', 'List of mail event templates')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Mail.TemplateBackend.Update',
                        'description' => Yii::t('MailModule.mail', 'Editing mail event templates')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Mail.TemplateBackend.View',
                        'description' => Yii::t('MailModule.mail', 'Viewing mail event templates')
                    ],
                ]
            ]
        ];
    }
}
