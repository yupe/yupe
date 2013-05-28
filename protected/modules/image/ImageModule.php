<?php

class ImageModule extends YWebModule
{
    public $uploadPath        = 'image';
    public $documentRoot;
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize           = 0;
    public $maxSize           = 5242880 /* 5 MB */;
    public $maxFiles          = 1;
    public $types;

    public $mainCategory;

    public function getInstall()
    {
        if(parent::getInstall())
            @mkdir($this->getUploadPath(),0755);

        return false;
    }

    public function getUploadPath()
    {
        return  Yii::getPathOfAlias('webroot') . '/' .
            Yii::app()->getModule('yupe')->uploadPath . '/' .
            $this->uploadPath . '/';
    }

    public function getDependencies()
    {
        return array(
            'category',
        );
    }

    public  function getVersion()
    {
        return Yii::t('ImageModule.image', '0.4');
    }

    public function getIcon()
    {
        return "picture";
    }

    public function getParamsLabels()
    {
        return array(
            'mainCategory'      => Yii::t('ImageModule.image','Главная категория изображений'),
            'uploadPath'         => Yii::t('ImageModule.image', 'Каталог для загрузки изображений'),
            'allowedExtensions' => Yii::t('ImageModule.image', 'Разрешенные расширения (перечислите через запятую)'),
            'minSize'           => Yii::t('ImageModule.image', 'Минимальный размер (в байтах)'),
            'maxSize'           => Yii::t('ImageModule.image', 'Максимальный размер (в байтах)'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'uploadPath',
            'allowedExtensions',
            'minSize',
            'maxSize',
            'mainCategory' => CHtml::listData($this->getCategoryList(),'id','name'),
        );
    }

    public function createUploadDir()
    {
        $current = '/' . date('Y/m/d');
        $dirName = $this->getUploadPath() . $current;

        if (is_dir($dirName))
            return $current;

        return @mkdir($dirName, 0700, true) ? $current : false;
    }

    public function checkSelf()
    {
        $messages = array();

        if (!$this->uploadPath)
             $messages[YWebModule::CHECK_ERROR][] = array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('ImageModule.image', 'Пожалуйста, укажите каталог для хранения изображений! {link}', array(
                    '{link}' => CHtml::link(Yii::t('ImageModule.image', 'Изменить настройки модуля'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                     )),
                )),
            );

        if (!is_dir($this->getUploadPath()) || !is_writable($this->getUploadPath()))
            $messages[YWebModule::CHECK_ERROR][] = array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('ImageModule.image', 'Директория "{dir}" не доступна для записи или не существует! {link}', array(
                    '{dir}' => $this->getUploadPath(),
                    '{link}' => CHtml::link(Yii::t('ImageModule.image', 'Изменить настройки модуля'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                    )),
                )),
            );

        if (!$this->maxSize || $this->maxSize <= 0)
            $messages[YWebModule::CHECK_ERROR][] = array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('ImageModule.image', 'Укажите максимальный размер изображений {link}', array(
                    '{link}' => CHtml::link(Yii::t('ImageModule.image', 'Изменить настройки модуля'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => $this->id,
                     )),
                 )),
            );
        return (isset($messages[YWebModule::CHECK_ERROR])) ? $messages : true;
    }

    public function getCategory()
    {
        return Yii::t('ImageModule.image', 'Контент');
    }

    public function getName()
    {
        return Yii::t('ImageModule.image', 'Изображения');
    }

    public function getDescription()
    {
        return Yii::t('ImageModule.image', 'Модуль для хранения изображений');
    }

    public function getAuthor()
    {
        return Yii::t('ImageModule.image', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('ImageModule.image', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('ImageModule.image', 'http://yupe.ru');
    }

    public function init()
    {
        parent::init();

        $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];

        $forImport = array();

        if (Yii::app()->hasModule('gallery'))
            $forImport[] = 'gallery.models.*';

        $this->setImport(
            array_merge(
                array(
                    'image.models.*',
                    'image.components.*',
                ), $forImport
            )
        );
    }

    public function getCategoryList()
    {
        $criteria = array();

        if ($this->mainCategory)
            $criteria = array(
                'condition' => 'id = :id OR parent_id = :id',
                'params'    => array(':id' => $this->mainCategory),
                'order'     => 'id ASC',
            );

        return Category::model()->findAll($criteria);
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('ImageModule.image', 'Список изображений'), 'url' => array('/image/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('ImageModule.image', 'Добавить изображение'), 'url' => array('/image/default/create')),
        );
    }

    /**
     * Получаем разрешённые форматы:
     *
     * @return array of allowed extensions
     **/
    public function allowedExtensions()
    {
        return explode(',', $this->allowedExtensions);
    }
}