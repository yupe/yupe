<?php

use yupe\components\WebModule;

class RbacModule extends WebModule
{
    const VERSION = '0.9';

    public function init()
    {
        $this->setImport(
            array(
                'rbac.models.*',
                'rbac.components.*',
            )
        );

        parent::init();
    }

    public function getAdminPageLink()
    {
        return '/rbac/rbacBackend/assign';
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('RbacModule.rbac', 'Roles')),
            array(
                'icon'  => 'fa fa-fw fa-user',
                'label' => Yii::t('RbacModule.rbac', 'Assign roles'),
                'url'   => array('/rbac/rbacBackend/assign')
            ),
            array(
                'icon'  => 'fa fa-fw fa-align-left',
                'label' => Yii::t('RbacModule.rbac', 'Manage operations'),
                'url'   => array('/rbac/rbacBackend/index')
            ),
            array('label' => Yii::t('RbacModule.rbac', 'RBAC')),
            array(
                'icon'  => 'fa fa-fw fa-magnet',
                'label' => Yii::t('RbacModule.rbac', 'Import RBAC'),
                'url'   => array('/rbac/rbacBackend/import')
            )
        );
    }

    public function getName()
    {
        return Yii::t('RbacModule.rbac', 'RBAC');
    }

    public function getCategory()
    {
        return Yii::t('RbacModule.rbac', 'Users');
    }

    public function getDescription()
    {
        return Yii::t('RbacModule.rbac', 'Module for user rights and permissions');
    }

    public function getAuthor()
    {
        return Yii::t('RbacModule.rbac', 'amylabs team');
    }

    public function getAuthorEmail()
    {
        return 'hello@amylabs.ru';
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-check';
    }

    public function getDependencies()
    {
        return array('user');
    }

    public function getAuthItems()
    {
        return array(
            array(
                'name'        => 'Rbac.RbacManager',
                'description' => Yii::t('RbacModule.rbac', 'Manage roles'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => array(
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Rbac.RbacBackend.Assign',
                        'description' => Yii::t('RbacModule.rbac', 'Assign Roles')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Rbac.RbacBackend.Create',
                        'description' => Yii::t('RbacModule.rbac', 'Creating Roles')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Rbac.RbacBackend.Delete',
                        'description' => Yii::t('RbacModule.rbac', 'Removing roles')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Rbac.RbacBackend.Import',
                        'description' => Yii::t('RbacModule.rbac', 'Import Rules from modules')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Rbac.RbacBackend.Index',
                        'description' => Yii::t('RbacModule.rbac', 'List of roles')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Rbac.RbacBackend.Update',
                        'description' => Yii::t('RbacModule.rbac', 'Editing roles')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Rbac.RbacBackend.View',
                        'description' => Yii::t('RbacModule.rbac', 'Viewing roles')
                    ),
                )
            )
        );
    }
}
