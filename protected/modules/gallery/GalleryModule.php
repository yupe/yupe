<?php
class GalleryModule extends yupe\components\WebModule
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
            'adminMenuOrder' => Yii::t('GalleryModule.gallery', 'Menu items order'),
            'editor'         => Yii::t('GalleryModule.gallery', 'Visual Editor'),
        );
    }

    public  function getVersion()
    {
        return Yii::t('GalleryModule.gallery', '0.3');
    }

    public function getCategory()
    {
        return Yii::t('GalleryModule.gallery', 'Content');
    }   

    public function getName()
    {
        return Yii::t('GalleryModule.gallery', 'Image galleries');
    }

    public function getDescription()
    {
        return Yii::t('GalleryModule.gallery', 'Module for create simple image galleries');
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
            array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Galleries list'), 'url' => array('/gallery/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Create gallery'), 'url' => array('/gallery/default/create')),
        );
    }
}
