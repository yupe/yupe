<?php
$this->breadcrumbs = [
    Yii::t('CategoryModule.category', 'Categories') => ['/category/categoryBackend/index'],
    Yii::t('CategoryModule.category', 'Manage'),
];

$this->pageTitle = Yii::t('CategoryModule.category', 'Categories - manage');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CategoryModule.category', 'Category manage'),
        'url'   => ['/category/categoryBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CategoryModule.category', 'Create category'),
        'url'   => ['/category/categoryBackend/create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Categories'); ?>
        <small><?php echo Yii::t('CategoryModule.category', 'manage'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('CategoryModule.category', 'Find category'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('category-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );
    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => 'category-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
            [
                'name'        => 'id',
                'htmlOptions' => ['style' => 'width:20px'],
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->id, array("/category/categoryBackend/update", "id" => $data->id))'
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => [
                    'url'    => $this->createUrl('/category/categoryBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'name', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'slug',
                'editable' => [
                    'url'    => $this->createUrl('/category/categoryBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'slug', ['class' => 'form-control']),
            ],
            [
                'name'   => 'parent_id',
                'value'  => '$data->getParentName()',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'parent_id',
                    Category::model()->getFormattedList(),
                    ['encode' => false, 'empty' => '', 'class' => 'form-control']
                )
            ],
            [
                'name'   => 'image',
                'type'   => 'raw',
                'value'  => '$data->image ? CHtml::image($data->getImageUrl(50, 50), $data->name, array("width"  => 50, "height" => 50)) : "---"',
                'filter' => false
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/category/categoryBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Category::STATUS_PUBLISHED  => ['class' => 'label-success'],
                    Category::STATUS_MODERATION => ['class' => 'label-warning'],
                    Category::STATUS_DRAFT      => ['class' => 'label-default'],
                ],
            ],
            [
                'name'   => 'lang',
                'value'  => '$data->lang',
                'filter' => $this->yupe->getLanguagesList()
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
