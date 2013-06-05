<?php
/**
 * Отображение для postAdmin/index:
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
    Yii::t('BlogModule.blog', 'Управление'),
);

$this->pageTitle = Yii::t('BlogModule.blog', 'Участники - управление');

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
        <small><?php echo Yii::t('BlogModule.blog', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('BlogModule.blog', 'Поиск участников'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('user-to-blog-grid', {
            data: $(this).serialize()
        });
        return false;
    });"
);
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('BlogModule.blog', 'В данном разделе представлены средства управления участниками'); ?></p>

<?php $this->widget(
    'application.modules.yupe.components.YCustomGridView', array(
        'id'           => 'user-to-blog-grid',
        'type'         => 'condensed',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            'id',
            array(
                'name'  => 'user_id',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->user->getFullName(), array("/user/default/view", "id" => $data->user->getId()))',
            ),
            array(
                'name'  => 'blog_id',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->blog->name, array("/blog/blogAdmin/view", "id" => $data->blog->id))',
            ),
            array(
                'name'  => 'create_date',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "short", "short")',
            ),
            array(
                'name'  => 'update_date',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->update_date, "short", "short")',
            ),
            array(
                'name'  => 'role',
                'type'  => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data, "role", "Role", array(1 => "user", 2 => "eye-open", 3 => "asterisk"))',
            ),
            array(
                'name'  => 'status',
                'type'  => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array(1 => "ok-sign", 2 => "lock"))',
            ),
            'note',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>