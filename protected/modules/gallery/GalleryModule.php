<?php
class GalleryModule extends YWebModule
{
    public function getDependencies()
    {
        return array(
            'user',
            'category',
            'image'
        );
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('GalleryModule.gallery', 'Порядок следования в меню'),
            'editor'         => Yii::t('GalleryModule.gallery', 'Визуальный редактор'),
        );
    }

    public  function getVersion()
    {
        return Yii::t('GalleryModule.gallery', '0.2');
    }

    public function getCategory()
    {
        return Yii::t('GalleryModule.gallery', 'Контент');
    }   

    public function getName()
    {
        return Yii::t('GalleryModule.gallery', 'Галереи изображений');
    }

    public function getDescription()
    {
        return Yii::t('GalleryModule.gallery', 'Модуль для простых галерей изображений');
    }

    public function getAuthor()
    {
        return Yii::t('GalleryModule.gallery', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('GalleryModule.gallery', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('GalleryModule.gallery', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "picture";
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'gallery.models.*',
            'gallery.components.*',
        ));
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor'        => Yii::app()->getModule('yupe')->editors,
        );
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Список галерей'), 'url' => array('/gallery/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Добавить галерею'), 'url' => array('/gallery/default/create')),
        );
    }
}
