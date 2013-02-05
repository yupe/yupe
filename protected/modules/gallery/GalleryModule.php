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
        );
    }

    public  function getVersion()
    {
        return Yii::t('GalleryModule.gallery', '0.1');
    }

    public function getCategory()
    {
        return Yii::t('GalleryModule.gallery', 'Сервисы');
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

     public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Список галерей'), 'url' => array('/gallery/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Добавить галерею'), 'url' => array('/gallery/default/create')),
        );
    }
}
