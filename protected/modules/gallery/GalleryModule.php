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
    const VERSION = '0.9';

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

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getCategory()
    {
        return Yii::t('GalleryModule.gallery', 'Content');
    }

    public function getName()
    {
        return Yii::t('GalleryModule.gallery', 'Galleries');
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
        return "fa fa-fw fa-camera";
    }

    public function getAdminPageLink()
    {
        return '/gallery/galleryBackend/index';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'gallery.models.*'
            )
        );
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor' => Yii::app()->getModule('yupe')->editors,
        );
    }

    public function getNavigation()
    {
        return array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('GalleryModule.gallery', 'Galleries list'),
                'url'   => array('/gallery/galleryBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('GalleryModule.gallery', 'Create gallery'),
                'url'   => array('/gallery/galleryBackend/create')
            ),
        );
    }

    public function getAuthItems()
    {
        return array(
            array(
                'name'        => 'Gallery.GalleryManager',
                'description' => Yii::t('GalleryModule.gallery', 'Manage gallery'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => array(
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Gallery.GalleryBackend.Create',
                        'description' => Yii::t('GalleryModule.gallery', 'Creating gallery')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Gallery.GalleryBackend.Delete',
                        'description' => Yii::t('GalleryModule.gallery', 'Removing gallery')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Gallery.GalleryBackend.Index',
                        'description' => Yii::t('GalleryModule.gallery', 'List of gallery')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Gallery.GalleryBackend.Update',
                        'description' => Yii::t('GalleryModule.gallery', 'Editing gallery')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Gallery.GalleryBackend.Inline',
                        'description' => Yii::t('GalleryModule.gallery', 'Editing gallery')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Gallery.GalleryBackend.View',
                        'description' => Yii::t('GalleryModule.gallery', 'Viewing gallery')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Gallery.GalleryBackend.Images',
                        'description' => Yii::t('GalleryModule.gallery', 'Images gallery')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Gallery.GalleryBackend.DeleteImage',
                        'description' => Yii::t('GalleryModule.gallery', 'Delete image')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Gallery.GalleryBackend.Addimages',
                        'description' => Yii::t('GalleryModule.gallery', 'Add image')
                    ),
                )
            )
        );
    }
}
