<?php
/**
 * Отображение для default/index:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 **/

$this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/galleryBackend/index'],
    Yii::t('GalleryModule.gallery', 'Management'),
];

$this->pageTitle = Yii::t('GalleryModule.gallery', 'Galleries - manage');

$this->menu = [
    [
        'icon' => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('GalleryModule.gallery', 'Gallery management'),
        'url' => ['/gallery/galleryBackend/index']
    ],
    [
        'icon' => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('GalleryModule.gallery', 'Create gallery'),
        'url' => ['/gallery/galleryBackend/create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('GalleryModule.gallery', 'Galleries'); ?>
        <small><?= Yii::t('GalleryModule.gallery', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?= Yii::t('GalleryModule.gallery', 'Find galleries'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('gallery-grid', {
            data: $(this).serialize()
        });

        return false;
    });"
    );
    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'gallery-grid',
        'sortableRows' => true,
        'sortableAjaxSave' => true,
        'sortableAttribute' => 'sort',
        'sortableAction' => '/gallery/galleryBackend/sortableGallery',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => [
            [
                'header' => '',
                'value' => 'CHtml::image($data->previewImage(), $data->name, array("width" => 75))',
                'type' => 'html'
            ],
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'name',
                'editable' => [
                    'url' => $this->createUrl('/gallery/galleryBackend/inline'),
                    'mode' => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter' => CHtml::activeTextField($model, 'name', ['class' => 'form-control']),
            ],
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'description',
                'value' => 'trim(strip_tags($data->description))',
                'editable' => [
                    'url' => $this->createUrl('/gallery/galleryBackend/inline'),
                    'type' => 'textarea',
                    'title' => Yii::t(
                        'GalleryModule.gallery',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('description'))]
                    ),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter' => CHtml::activeTextField($model, 'description', ['class' => 'form-control']),
            ],
            [
                'name' => 'category_id',
                'value' => '$data->getCategoryName()',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'category_id',
                    Yii::app()->getComponent('categoriesRepository')->getFormattedList(Yii::app()->getModule('gallery')->mainCategory),
                    ['class' => 'form-control', 'encode' => false, 'empty' => '']
                ),
            ],
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'status',
                'url' => $this->createUrl('/gallery/galleryBackend/inline'),
                'source' => $model->getStatusList(),
                'options' => [
                    Gallery::STATUS_DRAFT => ['class' => 'label-default'],
                    Gallery::STATUS_PERSONAL => ['class' => 'label-info'],
                    Gallery::STATUS_PRIVATE => ['class' => 'label-warning'],
                    Gallery::STATUS_PUBLIC => ['class' => 'label-success'],
                ],
            ],
            [
                'name' => 'owner',
                'value' => '$data->ownerName',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'owner',
                    User::getFullNameList(),
                    ['class' => 'form-control', 'empty' => '']
                ),

            ],
            [
                'name' => 'imagesCount',
                'value' => 'CHtml::link($data->imagesCount, array("/gallery/galleryBackend/images", "id" => $data->id))',
                'type' => 'raw',
                'filter' => false
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'template' => '{images}{front_view}{update}{delete}',
                'buttons' => [
                    'images' => [
                        'icon' => 'fa fa-fw fa-picture-o',
                        'label' => Yii::t('GalleryModule.gallery', 'Gallery images'),
                        'url' => 'array("/gallery/galleryBackend/images", "id" => $data->id)',
                        'options' => ['class' => 'btn btn-sm btn-default'],
                    ],
                    'front_view' => [
                        'visible' => function ($row, $data) {
                            return $data->status == Gallery::STATUS_PUBLIC;
                        }
                    ]
                ],
                'frontViewButtonUrl' => function($data){
                    return Yii::app()->createUrl('/gallery/gallery/view', ['id' => $data->id]);
                },
            ],
        ],
    ]
); ?>
