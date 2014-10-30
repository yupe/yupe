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
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blogBackend/index'),
    $model->name,
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Blogs - view');

$this->menu = array(
    array(
        'label' => Yii::t('BlogModule.blog', 'Blogs'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage blogs'),
                'url'   => array('/blog/blogBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'Add a blog'),
                'url'   => array('/blog/blogBackend/create')
            ),
            array('label' => Yii::t('BlogModule.blog', 'Blog') . ' «' . mb_substr($model->name, 0, 32) . '»', 'utf-8'),
            array(
                'icon'        => 'fa fa-fw fa-pencil',
                'encodeLabel' => false,
                'label'       => Yii::t('BlogModule.blog', 'Edit blog'),
                'url'         => array(
                    '/blog/blogBackend/update',
                    'id' => $model->id
                )
            ),
            array(
                'icon'        => 'fa fa-fw fa-eye',
                'encodeLabel' => false,
                'label'       => Yii::t('BlogModule.blog', 'View blog'),
                'url'         => array(
                    '/blog/blogBackend/view',
                    'id' => $model->id
                )
            ),
            array(
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('BlogModule.blog', 'Remove blog'),
                'url'         => '#',
                'linkOptions' => array(
                    'submit'  => array('/blog/blogBackend/delete', 'id' => $model->id),
                    'confirm' => Yii::t('BlogModule.blog', 'Do you really want to remove the blog?'),
                    'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
                )
            ),
        )
    ),
    array(
        'label' => Yii::t('BlogModule.blog', 'Posts'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage posts'),
                'url'   => array('/blog/postBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'Add a post'),
                'url'   => array('/blog/postBackend/create/', 'blog' => $model->id)
            ),
        )
    ),
    array(
        'label' => Yii::t('BlogModule.blog', 'Members'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('BlogModule.blog', 'Manage members'),
                'url'   => array('/blog/userToBlogBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('BlogModule.blog', 'Add a member'),
                'url'   => array('/blog/userToBlogBackend/create')
            ),
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'View blog'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'name',
            array(
                'name'  => 'icon',
                'value' => CHtml::image($model->getImageUrl()),
                'type'  => 'raw'
            ),
            array(
                'name' => 'description',
                'type' => 'raw'
            ),
            array(
                'name'  => 'create_user_id',
                'value' => CHtml::link($model->createUser->getFullName(), ['/user/userBackend/view', 'id' => $model->createUser->id]),
                'type'  => 'raw'
            ),
            array(
                'name'  => 'update_user_id',
                'value' => CHtml::link($model->updateUser->getFullName(), ['/user/userBackend/view', 'id' => $model->updateUser->id]),
                'type'  => 'raw'
            ),

            array(
                'name'  => Yii::t('BlogModule.blog', 'Posts'),
                'value' => $model->postsCount
            ),
            array(
                'name'  => Yii::t('BlogModule.blog', 'Members'),
                'value' => $model->membersCount
            ),
            'icon',
            'slug',
            array(
                'name'  => 'type',
                'value' => $model->getType(),
            ),
            array(
                'name'  => 'status',
                'value' => $model->getStatus(),
            ),
            array(
                'name'  => 'create_user_id',
                'value' => $model->createUser->getFullName(),
            ),
            array(
                'name'  => 'update_user_id',
                'value' => $model->updateUser->getFullName(),
            ),
            array(
                'name'  => 'create_date',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_date, "short", "short"),
            ),
            array(
                'name'  => 'update_date',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_date, "short", "short"),
            )
        ),
    )
); ?>
