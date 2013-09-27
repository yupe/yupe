<?php
/**
 * Отображение для gallery/show:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<div class="gallery-show">
    <?php $this->pageTitle = Yii::t('GalleryModule.gallery', 'Gallery'); ?>
    <?php $this->breadcrumbs = array(
        Yii::t('GalleryModule.gallery', 'Galleries') => array('/gallery/gallery/list'), $model->name
    ); ?>
    <h1 class="page-header"><?php echo CHtml::encode($model->name); ?></h1>
    <?php echo $model->description; ?>
    <?php $this->widget(
        'gallery.widgets.GalleryWidget',
        array('galleryId' => $model->id, 'gallery' => $model, 'limit' => 30)
    ); ?>
    <?php if (Yii::app()->user->isAuthenticated()) : ?>
        <?php if ($model->canAddPhoto) : ?>
            <?php $this->renderPartial('_form', array('model' => $image, 'gallery' => $model)); ?>
        <?php endif ?>
    <?php endif; ?>
</div>
