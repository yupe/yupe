<?php
/**
 * Отображение для postAdmin/update:
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
    $model->title => array('/blog/PostAdmin/view', 'id' => $model->id),
    Yii::t('BlogModule.blog', 'Edit'),
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Posts - edit');

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Blogs'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Blogs admin'), 'url' => array('/blog/BlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add blog'), 'url' => array('/blog/BlogAdmin/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Posts'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Posts admin'), 'url' => array('/blog/PostAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add post'), 'url' => array('/blog/PostAdmin/create')),
        array('label' => Yii::t('BlogModule.blog', 'Post') . ' «' . mb_substr($model->title, 0, 32) . '»', 'utf-8'),
        array('icon' => 'pencil', 'label' => Yii::t('BlogModule.blog', 'Edit posts'), 'url' => array(
            '/blog/PostAdmin/update',
            'id' => $model->id
        )),
        array('icon' => 'comment', 'label' => Yii::t('BlogModule.blog', 'Comments'), 'url' => array(
            '/comment/default/index',
            'Comment[model_id]' => $model->id,
            'Comment[model]' => 'Post'

        )),
        array('icon' => 'eye-open', 'label' => Yii::t('BlogModule.blog', 'View post'), 'url' => array(
            '/blog/PostAdmin/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Remove post'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/blog/PostAdmin/delete', 'id' => $model->id),
            'confirm' => Yii::t('BlogModule.blog', 'Are you sure you want to delete selected post?'),
        )),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Members'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Members admin'), 'url' => array('/blog/UserToBlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add member'), 'url' => array('/blog/UserToBlogAdmin/create')),
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Edit post'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>