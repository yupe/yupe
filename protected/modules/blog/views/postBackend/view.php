<?php
/**
 * Отображение для postBackend/_form:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Posts') => ['/blog/postBackend/index'],
    $model->title,
];

$this->pageTitle = Yii::t('BlogModule.blog', 'Posts - view');

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
            ['label' => Yii::t('BlogModule.blog', 'Post') . ' «' . mb_substr($model->title, 0, 32) . '»', 'utf-8'],
            [
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('BlogModule.blog', 'Edit posts'),
                'url'   => [
                    '/blog/postBackend/update',
                    'id' => $model->id
                ]
            ],
            [
                'icon'  => 'fa fa-fw fa-eye',
                'label' => Yii::t('BlogModule.blog', 'View post'),
                'url'   => [
                    '/blog/postBackend/view',
                    'id' => $model->id
                ]
            ],
            [
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('BlogModule.blog', 'Remove post'),
                'url'         => '#',
                'linkOptions' => [
                    'submit'  => ['/blog/postBackend/delete', 'id' => $model->id],
                    'confirm' => Yii::t('BlogModule.blog', 'Do you really want to remove the post?'),
                    'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                ]
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
        <?php echo Yii::t('BlogModule.blog', 'Viewing post'); ?><br/>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            [
                'name'  => 'blog',
                'value' => $model->blog->name,
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
                'name'  => 'publish_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->publish_time, "short", "short"),
            ],
            [
                'name'  => 'create_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_time, "short", "short"),
            ],
            [
                'name'  => 'update_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_time, "short", "short"),
            ],
            'slug',
            'title',
            [
                'name' => 'quote',
                'type' => 'raw'
            ],
            [
                'name' => 'content',
                'type' => 'raw'
            ],
            'link',
            [
                'name'  => 'status',
                'value' => $model->getStatus(),
            ],
            [
                'name'  => 'comment_status',
                'value' => $model->getCommentStatus(),
            ],
            [
                'name'  => 'access_type',
                'value' => $model->getAccessType(),
            ],
            'keywords',
            'description',
        ],
    ]
); ?>
