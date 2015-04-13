<?php
$this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/galleryBackend/index'],
    //$model->name => array('/gallery/galleryBackend/view', 'id' => $model->id),
    $model->name,
    Yii::t('GalleryModule.gallery', 'Edit'),
];

$this->pageTitle = Yii::t('GalleryModule.gallery', 'Galleries - edit');

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
    ['label' => Yii::t('GalleryModule.gallery', 'Gallery') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('GalleryModule.gallery', 'Edit gallery'),
        'url'   => [
            '/gallery/galleryBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-picture-o',
        'label' => Yii::t('GalleryModule.gallery', 'Gallery images'),
        'url'   => ['/gallery/galleryBackend/images', 'id' => $model->id]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('GalleryModule.gallery', 'Remove gallery'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/gallery/galleryBackend/delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('GalleryModule.gallery', 'Do you really want to remove gallery?'),
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Update gallery'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
