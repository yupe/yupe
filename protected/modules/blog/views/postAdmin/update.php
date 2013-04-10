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
    Yii::t('BlogModule.blog', 'Записи') => array('/blog/PostAdmin/index'),
    $model->title => array('/blog/PostAdmin/view', 'id' => $model->id),
    Yii::t('BlogModule.blog', 'Редактирование'),
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Записи - редактирование');

$this->menu = array(
    array('label' => Yii::t('BlogModule.blog', 'Блоги'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление блогами'), 'url' => array('/blog/BlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить блог'), 'url' => array('/blog/BlogAdmin/create')),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Записи'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление записями'), 'url' => array('/blog/PostAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить запись'), 'url' => array('/blog/PostAdmin/create')),
        array('label' => Yii::t('BlogModule.blog', 'Запись') . ' «' . mb_substr($model->title, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('BlogModule.blog', 'Редактирование записи'), 'url' => array(
            '/blog/PostAdmin/update',
            'id' => $model->id
        )),
        array('icon' => 'comment', 'label' => Yii::t('BlogModule.blog', 'Комментарии'), 'url' => array(
            '/comment/default/index',
            'Comment[model_id]' => $model->id,
            'Comment[model]' => 'Post'

        )),
        array('icon' => 'eye-open', 'label' => Yii::t('BlogModule.blog', 'Просмотреть запись'), 'url' => array(
            '/blog/PostAdmin/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Удалить запись'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/blog/PostAdmin/delete', 'id' => $model->id),
            'confirm' => Yii::t('BlogModule.blog', 'Вы уверены, что хотите удалить запись?'),
        )),
    )),
    array('label' => Yii::t('BlogModule.blog', 'Участники'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление участниками'), 'url' => array('/blog/UserToBlogAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить участника'), 'url' => array('/blog/UserToBlogAdmin/create')),
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Редактирование записи'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>