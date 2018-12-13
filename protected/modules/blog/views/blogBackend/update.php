<?php
/**
 * Отображение для blogBackend/update:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 **/
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blogBackend/index'],
    $model->name                       => ['/blog/blogBackend/view', 'id' => $model->id],
    Yii::t('BlogModule.blog', 'Edit'),
];

$this->pageTitle = Yii::t('BlogModule.blog', 'Blogs - edit');

$this->menu = [
    [
        'label' => Yii::t('BlogModule.blog', 'Blogs'),
        'items' => [
            ['label' => Yii::t('BlogModule.blog', 'Blog') . ' «' . mb_substr($model->name, 0, 32) . '»', 'utf-8'],
            [
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('BlogModule.blog', 'Edit blog'),
                'url'   => [
                    '/blog/blogBackend/update',
                    'id' => $model->id
                ]
            ],
            [
                'icon'  => 'fa fa-fw fa-eye',
                'label' => Yii::t('BlogModule.blog', 'View blog'),
                'url'   => [
                    '/blog/blogBackend/view',
                    'id' => $model->id
                ]
            ],
            [
                'icon' => 'fa fa-fw fa-external-link-square',
                'label' => Yii::t('BlogModule.blog', 'View post on site'),
                'url' => [
                    '/blog/blog/view',
                    'slug' => $model->slug,
                ],
                'linkOptions' => [
                    'target' => '_blank',
                ],
                'visible' => $model->status == Blog::STATUS_ACTIVE
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
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('BlogModule.blog', 'Blog edit'); ?><br/>
        <small>&laquo;<?= $model->name; ?>&raquo;</small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
