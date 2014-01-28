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

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder'
        );
    }

    public function getAdminPageLink()
    {
        return '/rbac/rbacBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('RbacModule.rbac', 'Roles')),
            array('icon' => 'list-user', 'label' => Yii::t('RbacModule.rbac', 'Manage roles'), 'url' => array('/rbac/rbacBackend/index'))
        );
    }

    public function getName()
    {
        return Yii::t('RbacModule.rbac', 'RBAC');
    }

    public function getCategory()
    {
        return Yii::t('RbacModule.rbac', 'Yupe!');
    }

    public function getDescription()
    {
        return Yii::t('RbacModule.rbac', 'Module for user rigths and permissions');
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
        return Yii::t('RbacModule.rbac', '0.1');
    }

    public function getIcon()
    {
        return 'user';
    }

    public function getDependencies()
    {
        return array('user');
    }
}
