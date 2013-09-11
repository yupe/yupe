<?php
/**
 * Отображение для postAdmin/_form:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs = array(
    Yii::app()->getModule('blog')->getCategory() => array(),
    Yii::t('BlogModule.blog', 'Posts') => array('/blog/PostAdmin/index'),
    $model->title,
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Posts - view');

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Blogs'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage Blogs'), 'url' => array('/blog/BlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add blog'), 'url' => array('/blog/BlogAdmin/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Posts'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage Posts'), 'url' => array('/blog/PostAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add post'), 'url' => array('/blog/PostAdmin/create')),
        array('label' => Yii::t('BlogModule.blog', 'Post') . ' «' . mb_substr($model->title, 0, 32) . '»', 'utf-8'),
        array('icon' => 'pencil', 'label' => Yii::t('BlogModule.blog', 'Edit posts'), 'url' => array(
            '/blog/PostAdmin/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('BlogModule.blog', 'View post'), 'url' => array(
            '/blog/PostAdmin/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Remove post'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/blog/PostAdmin/delete', 'id' => $model->id),
            'confirm' => Yii::t('BlogModule.blog', 'Are you sure you want to remove post?'),
        )),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Members'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage Members'), 'url' => array('/blog/UserToBlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add member'), 'url' => array('/blog/UserToBlogAdmin/create')),
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'View posts'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView', array(
        'data'       => $model,
        'attributes' => array(
            'id',
            array(
                'name'  => 'blog',
                'value' => $model->blog->name,
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
                'name'  => 'publish_date',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->publish_date, "short", "short"),
            ),
            array(
                'name'  => 'create_date',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_date, "short", "short"),
            ),
            array(
                'name'  => 'update_date',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_date, "short", "short"),
            ),
            'slug',
            'title',
            'quote',
            'content',
            'link',
            array(
                'name'  => 'status',
                'value' => $model->getStatus(),
            ),
            array(
                'name'  => 'comment_status',
                'value' => $model->getCommentStatus(),
            ),
            array(
                'name'  => 'access_type',
                'value' => $model->getAccessType(),
            ),
            'keywords',
            'description',
        ),
    )
); ?>