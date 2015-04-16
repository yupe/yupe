<?php
/**
 * Отображение для postBackend/view:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Members') => ['/blog/userToBlogBackend/index'],
    $model->user->nick_name,
];

$this->pageTitle = Yii::t('BlogModule.blog', 'Members - view');

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
            ['label' => Yii::t('BlogModule.blog', 'Member') . ' «' . mb_substr($model->id, 0, 32) . '»', 'utf-8'],
            [
                'icon'        => 'fa fa-fw fa-pencil',
                'encodeLabel' => false,
                'label'       => Yii::t('BlogModule.blog', 'Edit member'),
                'url'         => [
                    '/blog/userToBlogBackend/update',
                    'id' => $model->id
                ]
            ],
            [
                'icon'        => 'fa fa-fw fa-eye',
                'encodeLabel' => false,
                'label'       => Yii::t('BlogModule.blog', 'View member'),
                'url'         => [
                    '/blog/userToBlogBackend/view',
                    'id' => $model->id
                ]
            ],
            [
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('BlogModule.blog', 'Remove member'),
                'url'         => '#',
                'linkOptions' => [
                    'submit'  => ['/blog/userToBlogBackend/delete', 'id' => $model->id],
                    'confirm' => Yii::t('BlogModule.blog', 'Do you really want to remove the member?'),
                    'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                ]
            ],
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Viewing member'); ?><br/>
        <small>&laquo;<?php echo $model->user->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            [
                'name'  => 'user_id',
                'value' => $model->user->getFullName(),
            ],
            [
                'name'  => 'blog_id',
                'value' => $model->blog->name,
            ],
            [
                'name'  => 'create_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_time, "short", "short"),
            ],
            [
                'name'  => 'update_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_time, "short", "short"),
            ],
            [
                'name'  => 'role',
                'value' => $model->getRole(),
            ],
            [
                'name'  => 'status',
                'value' => $model->getStatus(),
            ],
            'note',
        ],
    ]
); ?>
