<?php
/**
 * Отображение для postAdmin/create:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs = array(
    Yii::app()->getModule('blog')->getCategory() => array(),
    Yii::t('BlogModule.blog', 'Участники') => array('/blog/UserToBlogAdmin/index'),
    Yii::t('BlogModule.blog', 'Добавление'),
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Участники - добавление');

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Блоги'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление блогами'), 'url' => array('/blog/BlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить блог'), 'url' => array('/blog/BlogAdmin/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Записи'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление записями'), 'url' => array('/blog/PostAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить запись'), 'url' => array('/blog/PostAdmin/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Участники'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление участниками'), 'url' => array('/blog/UserToBlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить участника'), 'url' => array('/blog/UserToBlogAdmin/create')),
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Участники'); ?>
        <small><?php echo Yii::t('BlogModule.blog', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>