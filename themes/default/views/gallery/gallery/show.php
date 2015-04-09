<?php
/**
 * @var $this GalleryController
 * @var $model Gallery
 */

$this->title = [Yii::t('GalleryModule.gallery', 'Gallery'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/gallery/list'],
    $model->name
];
?>
<div class="gallery-show">

    <h1 class="page-header"><?php echo CHtml::encode($model->name); ?></h1>

    <?php echo $model->description; ?>

    <?php $this->widget(
        'gallery.widgets.GalleryWidget',
        ['galleryId' => $model->id, 'gallery' => $model, 'limit' => 30]
    ); ?>

    <?php if (Yii::app()->user->isAuthenticated()) : ?>
        <?php if ($model->canAddPhoto) : ?>
            <?php $this->renderPartial('_form', ['model' => $image, 'gallery' => $model]); ?>
        <?php endif ?>
    <?php endif; ?>

</div>
