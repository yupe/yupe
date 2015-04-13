<?php

/**
 * MenuModule основной класс модуля menu
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.menu
 * @since 0.1
 *
 */
class MenuModule extends yupe\components\WebModule
{
    const VERSION = '0.9.4';

    public $defaultController = 'menu';

    public $menuCache = 'menu.cache';

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getCategory()
    {
        return Yii::t('MenuModule.menu', 'Structure');
    }

    public function getName()
    {
        return Yii::t('MenuModule.menu', 'Menu');
    }

    public function getDescription()
    {
        return Yii::t('MenuModule.menu', 'Menu management module');
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getAuthor()
    {
        return Yii::t('MenuModule.menu', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('MenuModule.menu', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('MenuModule.menu', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "fa fa-fw fa-list";
    }

    public function getAdminPageLink()
    {
        return '/menu/menuBackend/index';
    }

    public function getNavigation()
    {
        return [
            ['label' => Yii::t('MenuModule.menu', 'Menu')],
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MenuModule.menu', 'Manage menu'),
                'url'   => ['/menu/menuBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MenuModule.menu', 'Create menu'),
                'url'   => ['/menu/menuBackend/create']
            ],
            ['label' => Yii::t('MenuModule.menu', 'Menu items')],
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MenuModule.menu', 'Manage menu items'),
                'url'   => ['/menu/menuitemBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MenuModule.menu', 'Create menu item'),
                'url'   => ['/menu/menuitemBackend/create']
            ],
        ];
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'application.modules.menu.models.*'
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'name'        => 'Menu.MenuManager',
                'description' => Yii::t('MenuModule.menu', 'Manage menus'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    //menu
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuBackend.Create',
                        'description' => Yii::t('MenuModule.menu', 'Creating menu')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuBackend.Delete',
                        'description' => Yii::t('MenuModule.menu', 'Removing menu')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuBackend.Index',
                        'description' => Yii::t('MenuModule.menu', 'List of menu')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuBackend.Update',
                        'description' => Yii::t('MenuModule.menu', 'Editing menu')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuBackend.Inline',
                        'description' => Yii::t('MenuModule.menu', 'Editing menu')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuBackend.View',
                        'description' => Yii::t('MenuModule.menu', 'Viewing menu')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuBackend.Multiaction',
                        'description' => Yii::t('MenuModule.menu', 'Batch delete menu')
                    ],
                    //menu items
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuitemBackend.Create',
                        'description' => Yii::t('MenuModule.menu', 'Creating menu item')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuitemBackend.Delete',
                        'description' => Yii::t('MenuModule.menu', 'Removing menu item')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuitemBackend.Index',
                        'description' => Yii::t('MenuModule.menu', 'List of menu items')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuitemBackend.Update',
                        'description' => Yii::t('MenuModule.menu', 'Editing menu items')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuitemBackend.Inline',
                        'description' => Yii::t('MenuModule.menu', 'Editing menu')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuitemBackend.View',
                        'description' => Yii::t('MenuModule.menu', 'Viewing menu items')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Menu.MenuitemBackend.Multiaction',
                        'description' => Yii::t('MenuModule.menu', 'Batch delete menu items')
                    ],
                ]
            ]
        ];
    }

}
