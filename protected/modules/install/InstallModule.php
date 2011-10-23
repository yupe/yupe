<?php
class InstallModule extends YWebModule
{

    public function checkSelf()
    {
        return array('type' => YWebModule::CHECK_ERROR, 'message' => Yii::t('yupe', 'У Вас активирован модуль "Установщик", после установки системы его необходимо отключить! <br/> <a href="http://www.yiiframework.ru/doc/guide/ru/basics.module">Подробнее про Yii модули</a>'));
    }

    public function getAdminPageLink()
    {
        return '/yupe/backend/';
    }

    public function getEditableParams()
    {
        return false;
    }

    public function getCategory()
    {
        return Yii::t('install', 'Ядрышко');
    }

    public function getName()
    {
        return Yii::t('install', 'Установщик');
    }

    public function getIsShowInAdminMenu()
    {
        return false;
    }

    public function getDescription()
    {
        return Yii::t('install', 'Модуль для установки системы');
    }

    public function getVersion()
    {
        return Yii::t('install', '0.1');
    }

    public function getAuthor()
    {
        return Yii::t('install', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('install', 'aopeykin@yandex.ru');
    }

    public function getUrl()
    {
        return Yii::t('install', 'http://yupe.ru');
    }

    public function init()
    {
        $this->setImport(array(
                              'install.models.*',
                              'install.components.*',
                         ));
    }
}

?>