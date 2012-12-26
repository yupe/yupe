<?php

class CatalogModule extends YWebModule
{
    public $mainCategory;
    public $uploadPath        = 'catalog';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize           = 0;
    public $maxSize;
    public $maxFiles          = 1;

    public function getDependencies()
    {
        return array(
            'user',
            'category'
        );
    }

    public function getUploadPath()
    {
        return  Yii::getPathOfAlias('webroot') . '/' .
                Yii::app()->getModule('yupe')->uploadPath . '/' .
                $this->uploadPath . '/';
    }

    public function checkSelf()
    {
        $messages = array();

        $uploadPath = $this->getUploadPath();

        if (!is_writable($uploadPath))
            $messages[YWebModule::CHECK_ERROR][] =  array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('catalog', 'Директория "{dir}" не доступна для записи! {link}', array(
                    '{dir}'  => $uploadPath,
                    '{link}' => CHtml::link(Yii::t('catalog', 'Изменить настройки'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => 'catalog',
                    )),
                )),
            );

        return count($messages[YWebModule::CHECK_ERROR]) ? $messages : true;
    }

    public function getEditableParams()
    {
        return array(
            'mainCategory' => Category::model()->allCategoryList,
            'uploadPath',
            'adminMenuOrder',
            'editor'       => Yii::app()->getModule('yupe')->editors,
            'allowedExtensions',
            'minSize',
            'maxSize',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'mainCategory'      => Yii::t('catalog', 'Главная категория каталога товаров'),
            'adminMenuOrder'    => Yii::t('catalog', 'Порядок следования в меню'),
            'uploadPath'        => Yii::t('catalog', 'Каталог для загрузки файлов (относительно Yii::app()->getModule("yupe")->uploadPath)'),
            'editor'            => Yii::t('catalog', 'Визуальный редактор'),
            'allowedExtensions' => Yii::t('catalog', 'Разрешенные расширения (перечислите через запятую)'),
            'minSize'           => Yii::t('catalog', 'Минимальный размер (в байтах)'),
            'maxSize'           => Yii::t('catalog', 'Максимальный размер (в байтах)'),
        );
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('catalog', 'Список товаров'), 'url' => array('/catalog/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('catalog', 'Добавить товар'), 'url' => array('/catalog/default/create')),
        );
    }

    public function getAdminPageLink()
    {
        return '/catalog/default/index';
    }
    
    public function getVersion()
    {
        return Yii::t('catalog', '0.2');
    }

    public function getCategory()
    {
        return Yii::t('catalog', 'Контент');
    }

    public function getName()
    {
        return Yii::t('catalog', 'Каталог товаров');
    }

    public function getDescription()
    {
        return Yii::t('catalog', 'Модуль для создания простого каталога товаров');
    }

    public function getAuthor()
    {
        return Yii::t('catalog', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('catalog', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('catalog', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return 'shopping-cart';
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'catalog.models.*',
            'catalog.components.*',
            //'category.models.*',
        ));
    }

    public function getCategoryList()
    {
        $criteria = ($this->mainCategory)
            ? array(
                'condition' => 'id = :id OR parent_id = :id',
                'params'    => array(':id' => $this->mainCategory),
                'order'     => 'id ASC',
            )
            : array();

        return Category::model()->findAll($criteria);
    }
}