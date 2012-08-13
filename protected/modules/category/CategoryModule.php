<?php

class CategoryModule extends YWebModule
{
    public $uploadPath = 'category';

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule('yupe')->uploadPath . DIRECTORY_SEPARATOR . $this->uploadPath.DIRECTORY_SEPARATOR;
    }

    public function checkSelf()
    {
        $uploadPath = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule('yupe')->uploadPath . DIRECTORY_SEPARATOR . $this->uploadPath;

        if (!is_writable($uploadPath))
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('category', 'Директория "{dir}" не досутпна для записи! {link}', array(
                    '{dir}'  => $uploadPath,
                    '{link}' => CHtml::link(Yii::t('category', 'Изменить настройки'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => 'category',
                    )),
                )),
            );
    }

    public function getEditableParams()
    {
        return array(
            'uploadPath',
            'adminMenuOrder',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('category', 'Порядок следования в меню'),
            'uploadPath'     => Yii::t('yupe', 'Каталог для загрузки файлов (относительно Yii::app()->getModule("yupe")->uploadPath)'),
        );
    }

    public function getAdminPageLink()
    {
        return '/category/default/';
    }

    public function getVersion()
    {
        return '0.3';
    }

    public function getCategory()
    {
        return Yii::t('category', 'Структура');
    }

    public function getName()
    {
        return Yii::t('category', 'Категории/разделы');
    }

    public function getDescription()
    {
        return Yii::t('category', 'Модуль для управления категориями/разделами сайта');
    }

    public function getAuthor()
    {
        return Yii::t('category', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('category', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('category', 'http://yupe.ru');
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
            array('icon' => 'plus-sign', 'label' => Yii::t('category', 'Добавить категорию'), 'url' => array('/category/default/create/')),
            array('icon' => 'th-list', 'label' => Yii::t('category', 'Список категорий'), 'url' => array('/category/default/index/')),
        );
    }
}