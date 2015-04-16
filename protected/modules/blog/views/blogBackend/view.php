<?php
/**
 * Отображение для blogBackend/view:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blogBackend/index'],
    $model->name,
];

$this->pageTitle = Yii::t('BlogModule.blog', 'Blogs - view');

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
            ['label' => Yii::t('BlogModule.blog', 'Blog') . ' «' . mb_substr($model->name, 0, 32) . '»', 'utf-8'],
            [
                'icon'        => 'fa fa-fw fa-pencil',
                'encodeLabel' => false,
                'label'       => Yii::t('BlogModule.blog', 'Edit blog'),
                'url'         => [
                    '/blog/blogBackend/update',
                    'id' => $model->id
                ]
            ],
            [
                'icon'        => 'fa fa-fw fa-eye',
                'encodeLabel' => false,
                'label'       => Yii::t('BlogModule.blog', 'View blog'),
                'url'         => [
                    '/blog/blogBackend/view',
                    'id' => $model->id
                ]
            ],
            [
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('BlogModule.blog', 'Remove blog'),
                'url'         => '#',
                'linkOptions' => [
                    'submit'  => ['/blog/blogBackend/delete', 'id' => $model->id],
                    'confirm' => Yii::t('BlogModule.blog', 'Do you really want to remove the blog?'),
                    'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                ]
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
                'url'   => ['/blog/postBackend/create/', 'blog' => $model->id]
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
        <?php echo Yii::t('BlogModule.blog', 'Viewing blogs'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            'name',
            [
                'name'  => 'icon',
                'value' => CHtml::image($model->getImageUrl()),
                'type'  => 'raw'
            ],
            [
                'name' => 'description',
                'type' => 'raw'
            ],
            [
                'name'  => 'create_user_id',
                'value' => CHtml::link($model->createUser->getFullName(), ['/user/userBackend/view', 'id' => $model->createUser->id]),
                'type'  => 'raw'
            ],
            [
                'name'  => 'update_user_id',
                'value' => CHtml::link($model->updateUser->getFullName(), ['/user/userBackend/view', 'id' => $model->updateUser->id]),
                'type'  => 'raw'
            ],

            [
                'name'  => Yii::t('BlogModule.blog', 'Posts'),
                'value' => $model->postsCount
            ],
            [
                'name'  => Yii::t('BlogModule.blog', 'Members'),
                'value' => $model->membersCount
            ],
            'icon',
            'slug',
            [
                'name'  => 'type',
                'value' => $model->getType(),
            ],
            [
                'name'  => 'status',
                'value' => $model->getStatus(),
            ],
            [
                'name'  => 'create_user_id',
                'value' => $model->createUser->getFullName(),
            ],
            [
                'name'  => 'update_user_id',
                'value' => $model->updateUser->getFullName(),
            ],
            [
                'name'  => 'create_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_time, "short", "short"),
            ],
            [
                'name'  => 'update_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_time, "short", "short"),
            ]
        ],
    ]
); ?>
