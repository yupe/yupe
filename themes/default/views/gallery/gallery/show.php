<?php $this->pageTitle = 'Галерея'; ?>
<?php $this->breadcrumbs = array('Галереи' => array('/gallery/gallery/list'), $model->name); ?>


<div class="span9">
    <h1><?php echo Yii::t('GalleryModule.gallery', 'Галерея'); ?> "<?php echo CHtml::encode($model->name); ?>" </h1>

    <p><?php echo $model->description; ?></p>

    <?php $this->widget('gallery.widgets.GalleryWidget', array('galleryId' => $model->id, 'gallery' => $model, 'limit' => 30)); ?>

    <?php if (Yii::app()->user->isAuthenticated()) : ?>
        <?php if ($model->canAddPhoto) : ?>
          <?php $this->renderPartial('_add-foto-form', array('model' => $image, 'gallery' => $model)); ?>
        <?php endif ?>
    <?php endif; ?>
</div>
