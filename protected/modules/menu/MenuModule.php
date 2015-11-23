<?php

/**
 * MenuModule основной класс модуля menu
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2015 amyLabs && Yupe! team
 * @package yupe.modules.menu
 * @since 0.1
 *
 */
class MenuModule extends yupe\components\WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @var string
     */
    public $defaultController = 'menu';

    /**
     * @var string
     */
    public $menuCache = 'menu.cache';

    /**
     * @return bool
     */
    public function getIsInstallDefault()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('MenuModule.menu', 'Structure');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('MenuModule.menu', 'Menu');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('MenuModule.menu', 'Menu management module');
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('MenuModule.menu', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('MenuModule.menu', 'team@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('MenuModule.menu', 'http://yupe.ru');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-fw fa-list';
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/menu/menuBackend/index';
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            ['label' => Yii::t('MenuModule.menu', 'Menu')],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MenuModule.menu', 'Manage menu'),
                'url' => ['/menu/menuBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MenuModule.menu', 'Create menu'),
                'url' => ['/menu/menuBackend/create'],
            ],
            ['label' => Yii::t('MenuModule.menu', 'Menu items')],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MenuModule.menu', 'Manage menu items'),
                'url' => ['/menu/menuitemBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MenuModule.menu', 'Create menu item'),
                'url' => ['/menu/menuitemBackend/create'],
            ],
        ];
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'application.modules.menu.models.*',
            ]
        );
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'Menu.MenuManager',
                'description' => Yii::t('MenuModule.menu', 'Manage menus'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    //menu
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Menu.MenuBackend.Create',
                        'description' => Yii::t('MenuModule.menu', 'Creating menu'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Menu.MenuBackend.Delete',
                        'description' => Yii::t('MenuModule.menu', 'Removing menu'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Menu.MenuBackend.Index',
                        'description' => Yii::t('MenuModule.menu', 'List of menu'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Menu.MenuBackend.Update',
                        'description' => Yii::t('MenuModule.menu', 'Editing menu'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Menu.MenuBackend.View',
                        'description' => Yii::t('MenuModule.menu', 'Viewing menu'),
                    ],
                    //menu items
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Menu.MenuitemBackend.Create',
                        'description' => Yii::t('MenuModule.menu', 'Creating menu item'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Menu.MenuitemBackend.Delete',
                        'description' => Yii::t('MenuModule.menu', 'Removing menu item'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Menu.MenuitemBackend.Index',
                        'description' => Yii::t('MenuModule.menu', 'List of menu items'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Menu.MenuitemBackend.Update',
                        'description' => Yii::t('MenuModule.menu', 'Editing menu items'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Menu.MenuitemBackend.View',
                        'description' => Yii::t('MenuModule.menu', 'Viewing menu items'),
                    ],
                ],
            ],
        ];
    }

}
