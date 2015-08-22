<?php
/**
 * @var $this GalleryController
 * @var $model Gallery
 */

$this->title = [Yii::t('GalleryModule.gallery', 'Gallery'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/gallery/index'],
    $model->name
];
?>
<div class="gallery-show">

    <h1 class="page-header"><?= CHtml::encode($model->name); ?></h1>

    <?= $model->description; ?>

    <?php $this->widget(
        'gallery.widgets.GalleryWidget',
        ['galleryId' => $model->id, 'gallery' => $model, 'limit' => 30]
    ); ?>

    <?php if (Yii::app()->getUser()->isAuthenticated()) : ?>
        <?php if ($model->canAddPhoto) : ?>
            <?php $this->renderPartial('_form', ['model' => $image, 'gallery' => $model]); ?>
        <?php endif ?>
    <?php endif; ?>

</div>
