<?php
/**
 * Отображение для gallery/editimage:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->pageTitle   = 'Галерея';
$this->breadcrumbs = array(
    'Галереи'                => array('/gallery/gallery/list'),
    $model->gallery->name => array('/gallery/gallery/show', 'id' => $model->gallery->id),
    Yii::t(
        'GalleryModule.gallery', 'Редактирование изображения #{id}', array(
            '{id}' => $model->id
        )
    )
); ?>
<h1><?php echo Yii::t('GalleryModule.gallery', 'Редактирование изображения #{id}', array('{id}' => $model->id)); ?></h1>

<?php $this->renderPartial('_add_foto_form', array('model' => $model)); ?>