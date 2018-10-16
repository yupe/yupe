<?php
/**
 * Отображение для Default/images:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->pageTitle = 'Галерея - Изображения галереи';

$this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/galleryBackend/index'],
    $model->name,
];

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
]; ?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Show gallery'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbTabs',
    [
        'type'   => 'tabs', // 'tabs' or 'pills'
        'tabs'   => [
            [
                'id'      => '_images_show',
                'label'   => Yii::t('GalleryModule.gallery', 'Show gallery'),
                'content' => $this->renderPartial(
                        '_images_show',
                        ['model' => $model, 'dataProvider' => $dataProvider],
                        true
                    ),
                'active'  => $tab == '_images_show',
            ],
            [
                'id'      => '_image_add',
                'label'   => Yii::t('GalleryModule.gallery', 'Create image'),
                'content' => $this->renderPartial('_image_add', ['model' => $image,], true),
                'active'  => $tab == '_image_add',
            ],
            [
                'id'      => '_images_add',
                'label'   => Yii::t('GalleryModule.gallery', 'Group adding'),
                'content' => $this->renderPartial('_images_add', ['model' => $image, 'gallery' => $model,], true),
                'active'  => $tab == '_images_add',
            ],
        ],
        'events' => ['shown' => 'js:loadContent']
    ]
); ?>
<script>
    var loadContent;
    var loadedCount = 0;
    jQuery(document).ready(function ($) {
        loadContent = function (e) {
            $.fn.yiiListView.update('gallery');
        }
    });
</script>
