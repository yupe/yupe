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
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            'user',
            'category',
            'image'
        ];
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'editor' => Yii::t('GalleryModule.gallery', 'Visual Editor'),
        ];
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('GalleryModule.gallery', 'Content');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('GalleryModule.gallery', 'Galleries');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('GalleryModule.gallery', 'Module for create simple image galleries');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('GalleryModule.gallery', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('GalleryModule.gallery', 'team@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('GalleryModule.gallery', 'http://yupe.ru');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return "fa fa-fw fa-camera";
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/gallery/galleryBackend/index';
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'gallery.models.*'
            ]
        );
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'editor' => Yii::app()->getModule('yupe')->editors,
        ];
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('GalleryModule.gallery', 'Galleries list'),
                'url' => ['/gallery/galleryBackend/index']
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('GalleryModule.gallery', 'Create gallery'),
                'url' => ['/gallery/galleryBackend/create']
            ],
        ];
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'Gallery.GalleryManager',
                'description' => Yii::t('GalleryModule.gallery', 'Manage gallery'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Gallery.GalleryBackend.Create',
                        'description' => Yii::t('GalleryModule.gallery', 'Creating gallery')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Gallery.GalleryBackend.Delete',
                        'description' => Yii::t('GalleryModule.gallery', 'Removing gallery')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Gallery.GalleryBackend.Index',
                        'description' => Yii::t('GalleryModule.gallery', 'List of gallery')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Gallery.GalleryBackend.Update',
                        'description' => Yii::t('GalleryModule.gallery', 'Editing gallery')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Gallery.GalleryBackend.View',
                        'description' => Yii::t('GalleryModule.gallery', 'Viewing gallery')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Gallery.GalleryBackend.Images',
                        'description' => Yii::t('GalleryModule.gallery', 'Images gallery')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Gallery.GalleryBackend.DeleteImage',
                        'description' => Yii::t('GalleryModule.gallery', 'Delete image')
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Gallery.GalleryBackend.Addimages',
                        'description' => Yii::t('GalleryModule.gallery', 'Add image')
                    ],
                ]
            ]
        ];
    }
}
