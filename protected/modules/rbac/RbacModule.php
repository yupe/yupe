<?php

use yupe\components\WebModule;

class RbacModule extends WebModule
{
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
        return '/rbac/rbacBackend/index';
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
        return Yii::t('RbacModule.rbac', 'amylabs team / Dark_Cs');
    }

    public function getAuthorEmail()
    {
        return 'hello@amylabs.ru / darkcs2@gmail.com';
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getVersion()
    {
        return Yii::t('RbacModule.rbac', '0.1.1');
    }

    public function getIcon()
    {
        return 'user';
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
                'description' => 'Управление ролями пользователей',
                'type' => 1,
                'items' => array(
                    array('type' => 0, 'name' => 'Rbac.RbacBackend.Assign', 'description' => 'Назначение ролей',),
                    array('type' => 0, 'name' => 'Rbac.RbacBackend.Create', 'description' => 'Создание ролей',),
                    array('type' => 0, 'name' => 'Rbac.RbacBackend.Delete', 'description' => 'Удаление ролей',),
                    array('type' => 0, 'name' => 'Rbac.RbacBackend.Import', 'description' => 'Импорт правил из модулей',),
                    array('type' => 0, 'name' => 'Rbac.RbacBackend.Index', 'description' => 'Просмотр списка ролей',),
                    array('type' => 0, 'name' => 'Rbac.RbacBackend.Update', 'description' => 'Редактирование ролей',),
                    array('type' => 0, 'name' => 'Rbac.RbacBackend.View', 'description' => 'Просмотр ролей',),
                )
            )
        );
    }
}
