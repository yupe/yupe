<?php
class GalleryModule extends YWebModule
{
    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('gallery', 'Порядок следования в меню'),
        );
    }

    public  function getVersion()
    {
        return Yii::t('gallery', '0.1');
    }

    public function getCategory()
    {
        return Yii::t('gallery', 'Сервисы');
    }   

    public function getName()
    {
        return Yii::t('gallery', 'Галереи изображений');
    }

    public function getDescription()
    {
        return Yii::t('gallery', 'Модуль для простых галерей изображений');
    }

    public function getAuthor()
    {
        return Yii::t('gallery', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('gallery', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('gallery', 'http://yupe.ru');
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
            array('icon' => 'list-alt', 'label' => Yii::t('gallery', 'Список галерей'), 'url' => array('/gallery/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('gallery', 'Добавить галерею'), 'url' => array('/gallery/default/create')),
        );
    }
}