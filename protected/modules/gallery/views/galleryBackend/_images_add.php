<?php
/**
 * Отображение для Default/_images_add:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$mainAssets = Yii::app()->assetManager->publish(
    Yii::getPathOfAlias('gallery.views.assets')
);
Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/fileupload.locale.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile($mainAssets . '/css/fileupload.css');
Yii::app()->clientScript->registerCss(
    'dragndrop-content',
    '.dragndrop:after { content: "' . Yii::t('GalleryModule.gallery', 'Move images here') . '"}'
);
$this->widget(
    'bootstrap.widgets.TbFileUpload',
    [
        'id'         => 'fileUploader',
        'url'        => $this->createUrl("/gallery/galleryBackend/addImages", ['id' => $gallery->id]),
        'model'      => $model,
        'attribute'  => 'file', // see the attribute?
        'multiple'   => true,
        'formView'   => 'gallery.views.galleryBackend._tform',
        'uploadView' => 'gallery.views.galleryBackend._upload', //bootstrap.views.fileupload.upload
        'options'    => [
            'maxFileSize'     => Yii::app()->getModule('image')->maxSize,
            'acceptFileTypes' => 'js:/(\.|\/)(' . implode(
                    '|',
                    Yii::app()->getModule('image')->allowedExtensions()
                ) . ')$/i',
        ]
    ]
);
