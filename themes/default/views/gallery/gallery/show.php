<?php $this->pageTitle = 'Галерея'; ?>
<?php $this->breadcrumbs = array('Галереи' => array('/gallery/gallery/list'), $model->name); ?>

<div id="gallery-wrapper" class="row" xmlns="http://www.w3.org/1999/html">
    <div class="span9">
        <h1><?php echo Yii::t('GalleryModule.gallery', 'Галерея'); ?> "<?php echo CHtml::encode($model->name); ?>" </h1>

        <p><?php echo $model->description; ?></p>

        <?php $this->widget('gallery.widgets.GalleryWidget', array('gallery_id' => $model->id, 'gallery' => $model, 'limit' => 30)); ?>

        <?php if (Yii::app()->user->isAuthenticated()) : ?>
            <?php if ($model->canAddPhoto) : ?>
                <div id="add-image-form">
                    <h1><?php echo Yii::t('GalleryModule.gallery', 'Добавление фото'); ?></h1>
                    <?php $this->renderPartial('_add-foto-form', array('model' => $image, 'gallery' => $model)); ?>
                </div>
            <?php endif ?>
        <?php endif; ?>
    </div>
</div>