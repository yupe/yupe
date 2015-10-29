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
    Yii::t('BlogModule.blog', 'Members') => ['/blog/userToBlogBackend/index'],
    Yii::t('BlogModule.blog', 'Administration'),
];

$this->pageTitle = Yii::t('BlogModule.blog', 'Members - administration');

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
        <?php echo Yii::t('BlogModule.blog', 'Members'); ?>
        <small><?php echo Yii::t('BlogModule.blog', 'administration'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('BlogModule.blog', 'Find members'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('user-to-blog-grid', {
            data: $(this).serialize()
        });

        return false;
    });"
    );
    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<p>
    <?php echo Yii::t('BlogModule.blog', 'In this category located member administration functions'); ?>
</p>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => 'user-to-blog-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
            [
                'name'   => 'user_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->user->getFullName(), array("/user/userBackend/view", "id" => $data->user->id))',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'user_id',
                    User::getFullNameList(),
                    ['class' => 'form-control', 'empty' => '']
                ),
            ],
            [
                'name'   => 'blog_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->blog->name, array("/blog/blogBackend/view", "id" => $data->blog->id))',
                'filter' => CHtml::listData(Blog::model()->cache($this->yupe->coreCacheTime)->findAll(), 'id', 'name')
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/blog/userToBlogBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                        'BlogModule.blog',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('role'))]
                    ),
                    'source' => $model->getRoleList(),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'name'     => 'role',
                'type'     => 'raw',
                'value'    => '$data->getRole()',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'role',
                    $model->getRoleList(),
                    ['class' => 'form-control', 'empty' => '']
                ),
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/blog/userToBlogBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    UserToBlog::STATUS_ACTIVE       => ['class' => 'label-success'],
                    UserToBlog::STATUS_BLOCK        => ['class' => 'label-default'],
                    UserToBlog::STATUS_CONFIRMATION => ['class' => 'label-info'],
                    UserToBlog::STATUS_DELETED      => ['class' => 'label-danger'],

                ],
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/blog/userToBlogBackend/inline'),
                    'mode'   => 'inline',
                    'title'  => Yii::t(
                        'BlogModule.blog',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('note'))]
                    ),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'name'     => 'note',
                'type'     => 'raw',
                'filter'   => CHtml::activeTextField($model, 'note', ['class' => 'form-control']),
            ],
            [
                'name'  => 'create_time',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "medium", "short")',
            ],
            [
                'name'  => 'update_time',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->update_time, "medium", "short")',
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
