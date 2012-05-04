<?php
class GalleryModule extends YWebModule
{
    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('gallery', 'Порядок следования в меню')
        );
    }

    public  function getVersion()
    {
        return '0.1 (dev)';
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

    public function init()
    {
        $this->setImport(array(
                              'gallery.models.*',
                              'gallery.components.*',
                         ));
    }
}