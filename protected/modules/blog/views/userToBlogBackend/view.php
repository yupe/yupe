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
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Members') => array('/blog/userToBlogBackend/index'),
    $model->user->nick_name,
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Members - view');

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
                'url'   => array('/blog/postBackend/create')
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
            array('label' => Yii::t('BlogModule.blog', 'Member') . ' «' . mb_substr($model->id, 0, 32) . '»', 'utf-8'),
            array(
                'icon'        => 'fa fa-fw fa-pencil',
                'encodeLabel' => false,
                'label'       => Yii::t('BlogModule.blog', 'Edit member'),
                'url'         => array(
                    '/blog/userToBlogBackend/update',
                    'id' => $model->id
                )
            ),
            array(
                'icon'        => 'fa fa-fw fa-eye',
                'encodeLabel' => false,
                'label'       => Yii::t('BlogModule.blog', 'View member'),
                'url'         => array(
                    '/blog/userToBlogBackend/view',
                    'id' => $model->id
                )
            ),
            array(
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('BlogModule.blog', 'Remove member'),
                'url'         => '#',
                'linkOptions' => array(
                    'submit'  => array('/blog/userToBlogBackend/delete', 'id' => $model->id),
                    'confirm' => Yii::t('BlogModule.blog', 'Do you really want to remove the member?'),
                    'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
                )
            ),
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'View member'); ?><br/>
        <small>&laquo;<?php echo $model->user->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            array(
                'name'  => 'user_id',
                'value' => $model->user->getFullName(),
            ),
            array(
                'name'  => 'blog_id',
                'value' => $model->blog->name,
            ),
            array(
                'name'  => 'create_date',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_date, "short", "short"),
            ),
            array(
                'name'  => 'update_date',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_date, "short", "short"),
            ),
            array(
                'name'  => 'role',
                'value' => $model->getRole(),
            ),
            array(
                'name'  => 'status',
                'value' => $model->getStatus(),
            ),
            'note',
        ),
    )
); ?>
