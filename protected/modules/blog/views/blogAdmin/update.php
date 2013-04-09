<?php
/**
 * Отображение для blogAdmin/update:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs = array(
    Yii::app()->getModule('blog')->getCategory() => array(),
    Yii::t('BlogModule.blog', 'Блоги') => array('/blog/BlogAdmin/index'),
    $model->name => array('/blog/BlogAdmin/view', 'id' => $model->id),
    Yii::t('BlogModule.blog', 'Редактирование'),
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Блоги - редактирование');

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Блоги'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление блогами'), 'url' => array('/blog/BlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить блог'), 'url' => array('/blog/BlogAdmin/create')),
        array('label' => Yii::t('BlogModule.blog', 'Блог') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('BlogModule.blog', 'Редактирование блога'), 'url' => array(
            '/blog/BlogAdmin/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('BlogModule.blog', 'Просмотреть блог'), 'url' => array(
            '/blog/BlogAdmin/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Удалить блог'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/blog/BlogAdmin/delete', 'id' => $model->id),
            'confirm' => Yii::t('BlogModule.blog', 'Вы уверены, что хотите удалить блог?'),
        )),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Записи'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление записями'), 'url' => array('/blog/PostAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить запись'), 'url' => array('/blog/PostAdmin/create/','blog' => $model->id)),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Участники'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление участниками'), 'url' => array('/blog/UserToBlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить участника'), 'url' => array('/blog/UserToBlogAdmin/create')),
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Редактирование блога'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>