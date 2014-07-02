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
            array('icon' => 'user', 'label' => Yii::t('RbacModule.rbac', 'Assign roles'), 'url' => array('/rbac/rbacBackend/userList')),
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
                    array(
                        'name' => 'Rbac.RbacBackend.Assign',
                        'description' => 'Назначение ролей',
                        'type' => 0,
                    ),
                    array(
                        'name' => 'Rbac.RbacBackend.Create',
                        'description' => 'Создание ролей',
                        'type' => 0,
                    ),
                    array(
                        'name' => 'Rbac.RbacBackend.Delete',
                        'description' => 'Удаление ролей',
                        'type' => 0,
                    ),
                    array(
                        'name' => 'Rbac.RbacBackend.Import',
                        'description' => 'Импорт правил из модулей',
                        'type' => 0,
                    ),
                    array(
                        'name' => 'Rbac.RbacBackend.Index',
                        'description' => 'Просмотр списка ролей',
                        'type' => 0,
                    ),
                    array(
                        'name' => 'Rbac.RbacBackend.Update',
                        'description' => 'Редактирование ролей',
                        'type' => 0,
                    ),
                    array(
                        'name' => 'Rbac.RbacBackend.View',
                        'description' => 'Просмотр ролей',
                        'type' => 0,
                    ),
                )
            )
        );
    }
}
