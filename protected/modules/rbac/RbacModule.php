<?php

use yupe\components\WebModule;

/**
 * Class RbacModule
 */
class RbacModule extends WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     *
     */
    public function init()
    {
        $this->setImport(
            [
                'rbac.models.*',
                'rbac.components.*',
            ]
        );

        parent::init();
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/rbac/rbacBackend/assign';
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            ['label' => Yii::t('RbacModule.rbac', 'Operations')],
            [
                'icon' => 'fa fa-fw fa-align-left',
                'label' => Yii::t('RbacModule.rbac', 'Manage operations'),
                'url' => ['/rbac/rbacBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('RbacModule.rbac', 'Create operation'),
                'url' => ['/rbac/rbacBackend/create'],
            ],
            ['label' => Yii::t('RbacModule.rbac', 'Roles')],
            [
                'icon' => 'fa fa-fw fa-user',
                'label' => Yii::t('RbacModule.rbac', 'Assign roles'),
                'url' => ['/rbac/rbacBackend/userList'],
            ],
            ['label' => Yii::t('RbacModule.rbac', 'RBAC')],
            [
                'icon' => 'fa fa-fw fa-magnet',
                'label' => Yii::t('RbacModule.rbac', 'Import RBAC'),
                'url' => ['/rbac/rbacBackend/import'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('RbacModule.rbac', 'RBAC');
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('RbacModule.rbac', 'Users');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('RbacModule.rbac', 'Module for user rights and permissions');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('RbacModule.rbac', 'amylabs team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return 'hello@amylabs.ru';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'http://amylabs.ru';
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
    public function getIcon()
    {
        return 'fa fa-fw fa-check';
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return ['user'];
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'Rbac.RbacManager',
                'description' => Yii::t('RbacModule.rbac', 'Manage roles'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Rbac.RbacBackend.Assign',
                        'description' => Yii::t('RbacModule.rbac', 'Assign Roles'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Rbac.RbacBackend.Create',
                        'description' => Yii::t('RbacModule.rbac', 'Creating Roles'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Rbac.RbacBackend.Delete',
                        'description' => Yii::t('RbacModule.rbac', 'Removing roles'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Rbac.RbacBackend.Import',
                        'description' => Yii::t('RbacModule.rbac', 'Import Rules from modules'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Rbac.RbacBackend.Index',
                        'description' => Yii::t('RbacModule.rbac', 'List of roles'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Rbac.RbacBackend.Update',
                        'description' => Yii::t('RbacModule.rbac', 'Editing roles'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Rbac.RbacBackend.View',
                        'description' => Yii::t('RbacModule.rbac', 'Viewing roles'),
                    ],
                ],
            ],
        ];
    }
}
