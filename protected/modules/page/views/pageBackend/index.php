<?php

/**
 * @var $model Page
 * @var $this PageBackendController
 * @var $pages array
 */
$this->breadcrumbs = [
    Yii::t('PageModule.page', 'Pages') => ['/page/pageBackend/index'],
    Yii::t('PageModule.page', 'List'),
];

$this->pageTitle = Yii::t('PageModule.page', 'Pages list');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('PageModule.page', 'Pages list'),
        'url'   => ['/page/pageBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('PageModule.page', 'Create page'),
        'url'   => ['/page/pageBackend/create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('PageModule.page', 'Pages'); ?>
        <small><?= Yii::t('PageModule.page', 'manage'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?= Yii::t('PageModule.page', 'Find pages'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('page-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );
    $this->renderPartial('_search', ['model' => $model, 'pages' => $pages]);
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => 'page-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'sortableRows'      => true,
        'sortableAjaxSave'  => true,
        'sortableAttribute' => 'order',
        'sortableAction'    => '/page/pageBackend/sortable',
        'columns'      => [
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'title',
                'editable' => [
                    'url'    => $this->createUrl('/page/pageBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'title', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'slug',
                'editable' => [
                    'url'    => $this->createUrl('/page/pageBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'slug', ['class' => 'form-control']),
            ],
            [
                'name'   => 'category_id',
                'value'  => '$data->getCategoryName()',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'category_id',
                    Yii::app()->getComponent('categoriesRepository')->getFormattedList(Yii::app()->getModule('page')->mainCategory),
                    ['encode' => false, 'empty' => '', 'class' => 'form-control']
                )
            ],
            [
                'name'   => 'parent_id',
                'value'  => '$data->parentName',
                'filter' => CHtml::listData(Page::model()->findAll(), 'id', 'title')
            ],
            [
                'name'    => 'lang',
                'value'   => '$data->lang',
                'filter'  => $this->yupe->getLanguagesList(),
                'visible' => count($this->yupe->getLanguagesList()) > 1,
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/page/pageBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Page::STATUS_PUBLISHED  => ['class' => 'label-success'],
                    Page::STATUS_MODERATION => ['class' => 'label-warning'],
                    Page::STATUS_DRAFT      => ['class' => 'label-default'],
                ],
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'frontViewButtonUrl' => function($data){
                    return Yii::app()->createUrl('/page/page/view', ['slug' => $data->slug]);
                },
                'buttons' => [
                    'front_view' => [
                        'visible' => function ($row, $data) {
                            return $data->status == Page::STATUS_PUBLISHED;
                        }
                    ]
                ]
            ],
        ],
    ]
);
?>
