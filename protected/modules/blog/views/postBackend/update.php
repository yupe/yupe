<?php
/**
 * Отображение для postBackend/update:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 **/
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Posts') => ['/blog/postBackend/index'],
    $model->title => ['/blog/postBackend/view', 'id' => $model->id],
    Yii::t('BlogModule.blog', 'Edit'),
];

$this->pageTitle = Yii::t('BlogModule.blog', 'Posts - edit');

$this->menu = [
    [
        'label' => Yii::t('BlogModule.blog', 'Posts'),
        'items' => [
            ['label' => Yii::t('BlogModule.blog', 'Post').' «'.mb_substr($model->title, 0, 32).'»', 'utf-8'],
            [
                'icon' => 'fa fa-fw fa-pencil',
                'label' => Yii::t('BlogModule.blog', 'Edit posts'),
                'url' => [
                    '/blog/postBackend/update',
                    'id' => $model->id,
                ],
            ],
            [
                'icon' => 'fa fa-fw fa-comment',
                'label' => Yii::t('BlogModule.blog', 'Comments'),
                'url' => [
                    '/comment/commentBackend/index',
                    'Comment[model_id]' => $model->id,
                    'Comment[model]' => 'Post',

                ],
            ],
            [
                'icon' => 'fa fa-fw fa-eye',
                'label' => Yii::t('BlogModule.blog', 'View post'),
                'url' => [
                    '/blog/postBackend/view',
                    'id' => $model->id,
                ],
            ],
            [
                'icon' => 'fa fa-fw fa-external-link-square',
                'label' => Yii::t('BlogModule.blog', 'View post on site'),
                'url' => [
                    '/blog/post/view',
                    'slug' => $model->slug,
                ],
                'linkOptions' => [
                    'target' => '_blank',
                ],
                'visible' => $model->status == Post::STATUS_PUBLISHED
            ],
            [
                'icon' => 'fa fa-fw fa-trash-o',
                'label' => Yii::t('BlogModule.blog', 'Remove post'),
                'url' => '#',
                'linkOptions' => [
                    'submit' => ['/blog/postBackend/delete', 'id' => $model->id],
                    'confirm' => Yii::t('BlogModule.blog', 'Do you really want to delete selected post?'),
                    'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                ],
            ],
        ],
    ],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('BlogModule.blog', 'Edit post'); ?><br/>
        <small>&laquo;<?= $model->title; ?>&raquo;</small>
    </h1>
</div>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
