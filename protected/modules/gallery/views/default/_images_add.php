<?php
/**
 * Отображение для Default/_images_add:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$mainAssets = Yii::app()->assetManager->publish(
    Yii::getPathOfAlias('gallery.views.assets')
);
Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/fileupload.locale.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile($mainAssets . '/css/fileupload.css');
Yii::app()->clientScript->registerCss(
    'drugndrop-content',
    '.drugndrop:after { content: "' . Yii::t('GalleryModule.gallery', 'Переместите сюда изображения') .'"}'
);
$this->widget(
    'bootstrap.widgets.TbFileUpload', array(
        'id'           => 'fileUploader',
        'url'          => $this->createUrl("/gallery/default/addImages", array('id' => $gallery->id)),
        'model'        => $model,
        'attribute'    => 'file', // see the attribute?
        'multiple'     => true,
        'formView'     => 'gallery.views.default._tform',
        'uploadView'   => 'gallery.views.default._upload', //bootstrap.views.fileupload.upload
        'options'      => array(
            'maxFileSize' => Yii::app()->getModule('image')->maxSize,
            'acceptFileTypes' => 'js:/(\.|\/)(' . implode('|', Yii::app()->getModule('image')->allowedExtensions()) . ')$/i',
        )
    )
);