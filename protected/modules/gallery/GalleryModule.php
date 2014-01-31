<?php
/**
 * GalleryModule основной класс модуля gallery
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.gallery
 * @since     0.6
 *
 */

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
        return Yii::t('GalleryModule.gallery', '0.6');
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
        return "camera-retro";
    }

    public function getAdminPageLink()
    {
        return '/gallery/galleryBackend/index';
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'gallery.models.*'          
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
            array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Galleries list'), 'url' => array('/gallery/galleryBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Create gallery'), 'url' => array('/gallery/galleryBackend/create')),
        );
    }
}
