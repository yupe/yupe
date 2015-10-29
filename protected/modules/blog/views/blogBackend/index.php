<?php
/**
 * Отображение для blogBackend/index:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blogBackend/index'],
    Yii::t('BlogModule.blog', 'Administration'),
];

$this->pageTitle = Yii::t('BlogModule.blog', 'Blogs - administration');

$this->menu = [
    [
        'label' => Yii::t('BlogModule.blog', 'Blogs'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage blogs'),
                'url'   => ['/blog/blogBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'Add a blog'),
                'url'   => ['/blog/blogBackend/create']
            ],
        ]
    ],
    [
        'label' => Yii::t('BlogModule.blog', 'Posts'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage posts'),
                'url'   => ['/blog/postBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'Add a post'),
                'url'   => ['/blog/postBackend/create']
            ],
        ]
    ],
    [
        'label' => Yii::t('BlogModule.blog', 'Members'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage members'),
                'url'   => ['/blog/userToBlogBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'Add a member'),
                'url'   => ['/blog/userToBlogBackend/create']
            ],
        ]
    ],
];
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Blogs'); ?>
        <small><?php echo Yii::t('BlogModule.blog', 'Administration'); ?></small>
    </h1>
</div>

<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="fa fa-search">&nbsp;</i>
    <?php echo Yii::t('BlogModule.blog', 'Find a blog'); ?>
    <span class="caret">&nbsp;</span>
</a>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('blog-grid', {
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
        'id'           => 'blog-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
            [
                'name'   => 'icon',
                'header' => false,
                'type'   => 'raw',
                'value'  => 'CHtml::image($data->getImageUrl(64, 64), $data->name, array("width"  => 64, "height" => 64))',
                'filter' => false
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => [
                    'url'    => $this->createUrl('/blog/blogBackend/inline'),
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
                    'url'    => $this->createUrl('/blog/blogBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'slug', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/blog/blogBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                        'BlogModule.blog',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('type'))]
                    ),
                    'source' => $model->getTypeList(),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'name'     => 'type',
                'type'     => 'raw',
                'value'    => '$data->getType()',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'type',
                    $model->getTypeList(),
                    ['class' => 'form-control', 'empty' => '']
                ),

            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/blog/blogBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Blog::STATUS_ACTIVE  => ['class' => 'label-success'],
                    Blog::STATUS_BLOCKED => ['class' => 'label-default'],
                    Blog::STATUS_DELETED => ['class' => 'label-danger'],
                ],
            ],
            [
                'name'   => 'category_id',
                'value'  => 'empty($data->category) ? "---" : $data->category->name',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'category_id',
                    Category::model()->getFormattedList(Yii::app()->getModule('blog')->mainCategory),
                    ['encode' => false, 'empty' => '', 'class' => 'form-control']
                )
            ],
            [
                'name'   => 'create_user_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->createUser->getFullName(), array("/user/userBackend/view", "id" => $data->createUser->id))',
                'filter' => User::getFullNameList()
            ],
            [
                'name'   => 'create_time',
                'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "short", "short")',
                'filter' => false
            ],
            [
                'header' => Yii::t('BlogModule.blog', 'Posts'),
                'value'  => 'CHtml::link($data->postsCount, array("/blog/postBackend/index","Post[blog_id]" => $data->id ))',
                'type'   => 'html'
            ],
            [
                'header' => Yii::t('BlogModule.blog', 'Members'),
                'value'  => 'CHtml::link($data->membersCount, array("/blog/userToBlogBackend/index","UserToBlog[blog_id]" => $data->id ))',
                'type'   => 'html'
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
