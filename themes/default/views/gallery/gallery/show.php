<div class="gallery-show">
    <?php $this->pageTitle = 'Галерея'; ?>
    <?php $this->breadcrumbs = array('Галереи' => array('/gallery/gallery/list'), $model->name); ?>
    <h1 class="page-header"><?php echo CHtml::encode($model->name); ?></h1>
    <?php echo $model->description; ?>
    <?php $this->widget(
        'gallery.widgets.GalleryWidget',
        array('galleryId' => $model->id, 'gallery' => $model, 'limit' => 30)
    ); ?>
    <?php if (Yii::app()->user->isAuthenticated()) : ?>
        <?php if ($model->canAddPhoto) : ?>
            <?php $this->renderPartial('_add-foto-form', array('model' => $image, 'gallery' => $model)); ?>
        <?php endif ?>
    <?php endif; ?>
</div>
