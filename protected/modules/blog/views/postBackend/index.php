<?php
/**
 * Отображение для postBackend/index:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Posts') => ['/blog/postBackend/index'],
    Yii::t('BlogModule.blog', 'Administration'),
];

$this->pageTitle = Yii::t('BlogModule.blog', 'Posts - administration');

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
        <?php echo Yii::t('BlogModule.blog', 'Posts'); ?>
        <small><?php echo Yii::t('BlogModule.blog', 'administration'); ?></small>
    </h1>
</div>

<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="fa fa-search">&nbsp;</i>
    <?php echo Yii::t('BlogModule.blog', 'Find posts'); ?>
    <span class="caret">&nbsp;</span>
</a>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('post-grid', {
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
        'id'           => 'post-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/blog/postBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                        'BlogModule.blog',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('blog_id'))]
                    ),
                    'source' => CHtml::listData(Blog::model()->findAll(), 'id', 'name'),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'name'     => 'blog_id',
                'type'     => 'raw',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'blog_id',
                    CHtml::listData(Blog::model()->findAll(), 'id', 'name'),
                    ['class' => 'form-control', 'empty' => '']
                ),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'title',
                'editable' => [
                    'url'    => $this->createUrl('/blog/postBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'title', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'slug',
                'editable' => [
                    'url'    => $this->createUrl('/blog/postBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'slug', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'publish_time',
                'editable' => [
                    'url'        => $this->createUrl('/blog/postBackend/inline'),
                    //'mode' => 'inline',
                    'type'       => 'datetime',
                    'options'    => [
                        'datetimepicker' => [
                            'format'   => 'dd-mm-yyyy hh:ii',
                            'language' => Yii::app()->language,
                        ],
                        'datepicker'     => [
                            'format' => 'dd-mm-yyyy',
                        ],

                    ],
                    'viewformat' => 'dd-mm-yyyy hh:ii',
                    'params'     => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'value'    => '$data->publish_time',
                'filter'   => CHtml::activeTextField($model, 'publish_time', ['class' => 'form-control']),
            ],
            [
                'name'   => 'create_user_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->createUser->getFullName(), array("/user/userBackend/view", "id" => $data->createUser->id))',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'create_user_id',
                    User::getFullNameList(),
                    ['class' => 'form-control', 'empty' => '']
                ),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/blog/postBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                        'BlogModule.blog',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('comment_status'))]
                    ),
                    'source' => array_merge(['' => '---'], $model->getCommentStatusList()),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'name'     => 'comment_status',
                'type'     => 'raw',
                'value'    => '$data->getCommentStatus()',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'comment_status',
                    $model->getCommentStatusList(),
                    ['class' => 'form-control', 'empty' => '']
                ),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'     => $this->createUrl('/blog/postBackend/inline'),
                    'mode'    => 'inline',
                    'type'    => 'select2',
                    'select2' => [
                        'tags' => array_values(CHtml::listData(Tag::model()->findAll(), 'id', 'name')),
                    ],
                ],
                'name'     => 'tags',
                'value'    => 'join(", ", $data->getTags())',
                'filter'   => false,
            ],
            [
                'header' => "<i class=\"fa fa-comment\"></i>",
                'value'  => 'CHtml::link(($data->commentsCount>0) ? $data->commentsCount-1 : 0,array("/comment/commentBackend/index/","Comment[model]" => "Post","Comment[model_id]" => $data->id))',
                'type'   => 'raw',
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/blog/postBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Post::STATUS_PUBLISHED => ['class' => 'label-success'],
                    Post::STATUS_SCHEDULED => ['class' => 'label-info'],
                    Post::STATUS_DRAFT     => ['class' => 'label-default'],
                    Post::STATUS_MODERATED => ['class' => 'label-warning'],
                ],
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
