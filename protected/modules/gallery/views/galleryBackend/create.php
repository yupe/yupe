<?php
    $this->breadcrumbs = array(       
        Yii::t('GalleryModule.gallery', 'Galleries') => array('/gallery/galleryBackend/index'),
        Yii::t('GalleryModule.gallery', 'Adding'),
    );

    $this->pageTitle = Yii::t('GalleryModule.gallery', 'Galleries - create');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Galeries list'), 'url' => array('/gallery/galleryBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Create gallery'), 'url' => array('/gallery/galleryBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Galleries'); ?>
        <small><?php echo Yii::t('GalleryModule.gallery', 'Adding'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>