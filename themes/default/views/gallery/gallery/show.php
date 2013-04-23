<?php $this->pageTitle = 'Галерея'; ?>
<?php $this->breadcrumbs = array('Галереи' => array('/gallery/gallery/list'),$model->name); ?>
<div id="gallery-wrapper">
    
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Галерея'); ?>
        "<?php echo CHtml::encode($model->name); ?>"
    </h1>

    <p><?php echo $model->description; ?></p>

    <?php $this->widget('gallery.widgets.GalleryWidget', array('id' => $model->id, 'limit' => 30)); ?>

    <?php if (Yii::app()->user->isAuthenticated()): ?>
    <div id="add-image-form">
        <h1><?php echo Yii::t('GalleryModule.gallery', 'Добавление фото'); ?></h1>
        <?php $this->renderPartial('_add_foto_form', array('model' => $image, 'gallery' => $model)); ?>
    </div>
    <?php else: ?>
    <br />
    <?php echo Yii::t('GalleryModule.gallery', 'Для добавления и редактирования фотографий Вам необходимо ') ?>
    <?php echo CHtml::link(Yii::t('GalleryModule.gallery', 'авторизоваться'), array('/user/account/login/')); ?>!
    <?php endif; ?>
</div>