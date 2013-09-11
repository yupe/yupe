<?php
/**
 * Отображение для postAdmin/view:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs = array(
    Yii::app()->getModule('blog')->getCategory() => array(),
    Yii::t('BlogModule.blog', 'Members') => array('/blog/UserToBlogAdmin/index'),
    $model->user->nick_name,
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Members - view');

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Blogs'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Blogs admin'), 'url' => array('/blog/BlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add blog'), 'url' => array('/blog/BlogAdmin/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Posts'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Posts admin'), 'url' => array('/blog/PostAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add post'), 'url' => array('/blog/PostAdmin/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Members'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Members admin'), 'url' => array('/blog/UserToBlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add member'), 'url' => array('/blog/UserToBlogAdmin/create')),
        array('label' => Yii::t('BlogModule.blog', 'Member') . ' «' . mb_substr($model->id, 0, 32) . '»', 'utf-8'),
        array('icon' => 'pencil', 'encodeLabel' => false, 'label' => Yii::t('BlogModule.blog', 'Edit member'), 'url' => array(
            '/blog/UserToBlogAdmin/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'encodeLabel' => false, 'label' => Yii::t('BlogModule.blog', 'View member'), 'url' => array(
            '/blog/UserToBlogAdmin/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Remove member'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/blog/UserToBlogAdmin/delete', 'id' => $model->id),
            'confirm' => Yii::t('BlogModule.blog', 'Are you sure you want to remove member?'),
        )),
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'View member'); ?><br />
        <small>&laquo;<?php echo $model->user->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView', array(
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