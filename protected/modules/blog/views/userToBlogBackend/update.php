<?php
/**
 * Отображение для postBackend/update:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs = array(
    Yii::app()->getModule('blog')->getCategory() => array(),
    Yii::t('BlogModule.blog', 'Members') => array('/blog/userToBlogBackend/index'),
    $model->user->nick_name => array('/blog/userToBlogBackend/view', 'id' => $model->id),
    Yii::t('BlogModule.blog', 'Edit'),
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Members - edit');

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Blogs'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage blogs'), 'url' => array('/blog/blogBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add a blog'), 'url' => array('/blog/blogBackend/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Posts'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage posts'), 'url' => array('/blog/postBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add a post'), 'url' => array('/blog/postBackend/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Members'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Manage members'), 'url' => array('/blog/userToBlogBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Add a member'), 'url' => array('/blog/userToBlogBackend/create')),
        array('label' => Yii::t('BlogModule.blog', 'Member') . ' «' . mb_substr($model->id, 0, 32) . '»', 'utf-8'),
        array('icon' => 'pencil', 'label' => Yii::t('BlogModule.blog', 'Edit member'), 'url' => array(
            '/blog/userToBlogBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('BlogModule.blog', 'View member'), 'url' => array(
            '/blog/userToBlogBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Remove member'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/blog/userToBlogBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('BlogModule.blog', 'Do you really want to remove the member?'),
        )),
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Edit member');?><br />
        <small>&laquo;<?php echo $model->user->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
