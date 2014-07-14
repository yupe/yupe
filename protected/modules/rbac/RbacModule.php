<?php

use yupe\components\WebModule;

class RbacModule extends WebModule
{
    const VERSION = '0.1.1';

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
            array('icon' => 'user', 'label' => Yii::t('RbacModule.rbac', 'Assign roles'), 'url' => array('/rbac/rbacBackend/assign')),
            array('icon' => 'align-left', 'label' => Yii::t('RbacModule.rbac', 'Manage operations'), 'url' => array('/rbac/rbacBackend/index')),
            array('label' => Yii::t('RbacModule.rbac', 'RBAC')),
            array('icon' => 'magnet', 'label' => Yii::t('RbacModule.rbac', 'Import RBAC'), 'url' => array('/rbac/rbacBackend/import'))
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
        return 'ok';
    }

    public function getDependencies()
    {
        return array('user');
    }

    public function getAuthItems()
    {
        return array(
            array(
                'name' => 'Rbac.RbacManager',
                'description' => Yii::t('RbacModule.rbac', 'Manage roles'),
                'type' => AuthItem::TYPE_OPERATION,
                'items' => array(
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Rbac.RbacBackend.Assign', 'description' => 'Назначение ролей',),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Rbac.RbacBackend.Create', 'description' => 'Создание ролей',),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Rbac.RbacBackend.Delete', 'description' => 'Удаление ролей',),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Rbac.RbacBackend.Import', 'description' => 'Импорт правил из модулей',),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Rbac.RbacBackend.Index', 'description' => 'Просмотр списка ролей',),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Rbac.RbacBackend.Update', 'description' => 'Редактирование ролей',),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Rbac.RbacBackend.View', 'description' => 'Просмотр ролей',),
                )
            )
        );
    }
}
