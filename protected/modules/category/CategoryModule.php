<?php

class CategoryModule extends YWebModule
{
    public $uploadPath = 'category';

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . '/' . Yii::app()->getModule('yupe')->uploadPath . '/' . $this->uploadPath . '/';
    }

    public function checkSelf()
    {
        $messages = array();

        $uploadPath = $this->getUploadPath();

        if (!is_writable($uploadPath))
            $messages[YWebModule::CHECK_ERROR][] = array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('CategoryModule.category', 'Директория "{dir}" не доступна для записи! {link}', array(
                    '{dir}'  => $uploadPath,
                    '{link}' => CHtml::link(Yii::t('CategoryModule.category', 'Изменить настройки'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => 'category',
                    )),
                )),
            );

        return isset($messages[YWebModule::CHECK_ERROR]) ? $messages : true;
    }

    public function getInstall()
    {
        if(parent::getInstall())
            @mkdir($this->getUploadPath(),0755);

        return false;
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'uploadPath',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('CategoryModule.category', 'Порядок следования в меню'),
            'uploadPath'     => Yii::t('CategoryModule.category', 'Каталог для загрузки файлов (относительно Yii::app()->getModule("yupe")->uploadPath)'),
        );
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getVersion()
    {
        return Yii::t('CategoryModule.category', '0.5');
    }

    public function getCategory()
    {
        return Yii::t('CategoryModule.category', 'Структура');
    }

    public function getName()
    {
        return Yii::t('CategoryModule.category', 'Категории/разделы');
    }

    public function getDescription()
    {
        return Yii::t('CategoryModule.category', 'Модуль для управления категориями/разделами сайта');
    }

    public function getAuthor()
    {
        return Yii::t('CategoryModule.category', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('CategoryModule.category', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('CategoryModule.category', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return 'folder-open';
    }

    public function isMultiLang()
    {
        return true;
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'category.models.*',
            'category.components.*',
        ));
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('CategoryModule.category', 'Список категорий'), 'url' => array('/category/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('CategoryModule.category', 'Добавить категорию'), 'url' => array('/category/default/create')),
        );
    }
}