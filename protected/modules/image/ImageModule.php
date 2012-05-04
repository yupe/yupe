<?php

class ImageModule extends YWebModule
{
    public $uploadDir;

    public $documentRoot;

    public $allowedExtensions = 'jpg,jpeg,png,gif';

    public $maxSize;

    public $types;

    public  function getVersion()
    {
        return '0.2 (dev)';
    }

    public function getUploadPath()
    {
        return $this->documentRoot . Yii::app()->request->baseUrl . DIRECTORY_SEPARATOR . $this->uploadDir;
    }

    public function createUploadDir()
    {
        $current = DIRECTORY_SEPARATOR . date('Y/m/d');

        $dirName = $this->getUploadPath() . $current;

        if (is_dir($dirName))        
            return $current;        

        return @mkdir($dirName, 0700, true) ? $current : false;
    }

    public function checkSelf()
    {
        if (!$this->uploadDir)
            return array('type' => YWebModule::CHECK_ERROR, 'message' => Yii::t('image', 'Пожалуйста, укажите каталог для хранения изображений! {link}', array('{link}' => CHtml::link(Yii::t('image', 'Изменить настройки модуля'), array('/yupe/backend/modulesettings/', 'module' => $this->id)))));

        if (!is_dir($this->getUploadPath()) || !is_writable($this->getUploadPath()))
            return array('type' => YWebModule::CHECK_ERROR, 'message' => Yii::t('image', 'Директория "{dir}" не досутпна для записи или не существует! {link}', array('{dir}' => $this->getUploadPath(), '{link}' => CHtml::link(Yii::t('image', 'Изменить настройки модуля'), array('/yupe/backend/modulesettings/', 'module' => $this->id)))));
    }

    public function getParamsLabels()
    {
        return array(
            'uploadDir' => Yii::t('image', 'Каталог для загрузки изображений'),
            'allowedExtensions' => Yii::t('image', 'Разрешенные расширения (перечислите через запятую)'),
            'maxSize' => Yii::t('image', 'Максимальный размер (в байтах)'),
        );
    }

    public function getEditableParams()
    {
        return array('uploadDir', 'allowedExtensions', 'maxSize');
    }

    public function getCategory()
    {
        return Yii::t('image', 'Контент');
    }

    public function getName()
    {
        return Yii::t('image', 'Изображения');
    }

    public function getDescription()
    {
        return Yii::t('image', 'Модуль для хранения изображений');
    }

    public function getAuthor()
    {
        return Yii::t('image', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('image', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('image', 'http://yupe.ru');
    }


    public function init()
    {
        parent::init();

        $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];

        $this->setImport(array(
                              'image.models.*',
                              'image.components.*',
                         ));
    }
}