<?php
/**
 * Отображение для blogAdmin/view:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs = array(
    Yii::app()->getModule('blog')->getCategory() => array(),
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/BlogAdmin/index'),
    $model->name,
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Blogs - view');

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Blogs'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Blogs admin'), 'url' => array('/blog/BlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add blog'), 'url' => array('/blog/BlogAdmin/create')),
        array('label' => Yii::t('BlogModule.blog', 'Blog') . ' «' . mb_substr($model->name, 0, 32) . '»', 'utf-8'),
        array('icon' => 'pencil', 'encodeLabel' => false, 'label' => Yii::t('BlogModule.blog', 'Edit blog'), 'url' => array(
            '/blog/BlogAdmin/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'encodeLabel' => false, 'label' => Yii::t('BlogModule.blog', 'View blog'), 'url' => array(
            '/blog/BlogAdmin/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Remove blog'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/blog/BlogAdmin/delete', 'id' => $model->id),
            'confirm' => Yii::t('BlogModule.blog', 'Are you sure you want to remove blog?'),
        )),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Posts'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Posts admin'), 'url' => array('/blog/PostAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add post'), 'url' => array('/blog/PostAdmin/create/','blog' => $model->id)),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Members'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Members admin'), 'url' => array('/blog/UserToBlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add member'), 'url' => array('/blog/UserToBlogAdmin/create')),
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'View blog'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView', array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'name',
            'description',
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
                'name'  =>'update_date',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_date, "short", "short"),
            )
        ),
    )
); ?>