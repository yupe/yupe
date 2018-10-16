<?php
$this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/galleryBackend/index'],
    Yii::t('GalleryModule.gallery', 'Adding'),
];

$this->pageTitle = Yii::t('GalleryModule.gallery', 'Galleries - create');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('GalleryModule.gallery', 'Gallery management'),
        'url'   => ['/gallery/galleryBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('GalleryModule.gallery', 'Create gallery'),
        'url'   => ['/gallery/galleryBackend/create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Galleries'); ?>
        <small><?php echo Yii::t('GalleryModule.gallery', 'Adding'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
