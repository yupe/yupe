<?php

class GalleryModule extends YWebModule
{
    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('gallery', 'Порядок следования в меню')
        );
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
        return Yii::t('gallery', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('gallery', 'aopeykin@yandex.ru');
    }

    public function getUrl()
    {
        return Yii::t('gallery', 'http://yupe.ru');
    }

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
                              'gallery.models.*',
                              'gallery.components.*',
                         ));
    }
}
