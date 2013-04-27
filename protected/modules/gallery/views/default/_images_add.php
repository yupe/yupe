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
$this->widget(
    'bootstrap.widgets.TbFileUpload', array(
        'id'           => 'fileUploader',
        'url'          => $this->createUrl("/gallery/default/addImages", array('id' => $gallery->id)),
        'model'        => $model,
        'attribute'    => 'file', // see the attribute?
        'multiple'     => true,
        'uploadView'   => 'gallery.views.default._upload', //bootstrap.views.fileupload.upload
        'downloadView' => 'gallery.views.default._download', //bootstrap.views.fileupload.download
        'options'      => array(
            'maxFileSize' => Yii::app()->getModule('image')->maxSize,
            'acceptFileTypes' => 'js:/(\.|\/)(' . implode('|', Yii::app()->getModule('image')->allowedExtensions()) . ')$/i',
        )
    )
);