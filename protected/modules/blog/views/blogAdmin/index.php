<?php
/**
 * Отображение для BlogAdmin/index:
 * 
 *   @category View
 *   @package  Yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('blog', 'Блоги') => array('/blog/BlogAdmin/index'),
        Yii::t('blog', 'Управление'),
    );

    $this->pageTitle = Yii::t('blog', 'Блоги - управление');

    $this->menu = array(
        array('label' => Yii::t('blog', 'Блоги'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление блогами'), 'url' => array('/blog/BlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить блог'), 'url' => array('/blog/BlogAdmin/create')),
        )),
        array('label' => Yii::t('blog', 'Записи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление записями'), 'url' => array('/blog/PostAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить запись'), 'url' => array('/blog/PostAdmin/create')),
        )),
        array('label' => Yii::t('blog', 'Участники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление участниками'), 'url' => array('/blog/UserToBlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить участника'), 'url' => array('/blog/UserToBlogAdmin/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('blog', 'Блоги'); ?>
        <small><?php echo Yii::t('blog', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('blog', 'Поиск блогов'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('blog-grid', {
            data: $(this).serialize()
        });
        return false;
    });"
);
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('blog', 'В данном разделе представлены средства управления блогами'); ?></p>

<?php $this->widget(
    'application.modules.yupe.components.YCustomGridView', array(
        'id'           => 'blog-grid',
        'type'         => 'condensed',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'bulkActions' => array(
            'actionButtons' => array(
                array(
                    'id'         => 'deleteAction',
                    'buttonType' => 'button',
                    'type'       => 'danger',
                    'size'       => 'small',
                    'label'      => Yii::t('YCustomGridView', 'Удалить'),
                    'click'      => 'js:function(values){ multiaction("delete", values); }',
                ),
            ),
            // if grid doesn't have a checkbox column type, it will attach
            // one and this configuration will be part of it
            'checkBoxColumnConfig' => array(
                'name' => 'id'
            ),
        ),
        'columns'      => array(
            'id',
            array(
                'name'  => 'name',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->name, array("/blog/blogAdmin/update", "id" => $data->id))',
            ),
            array(
                'header' => Yii::t('blog', 'Записей'),
                'value'  => '$data->postsCount',
            ),
            array(
                'header' => Yii::t('blog', 'Участников'),
                'value'  => '$data->membersCount',
            ),
            'icon',
            'slug',
            array(
                'name'  => 'type',
                'type'  => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data, "type", "Type", array(1 => "globe", 2 => "home"))',
            ),
            array(
                'name'  => 'status',
                'type'  => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("lock", "ok-sign", "remove"))',
            ),
            array(
                'name'  => 'create_user_id',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->createUser->getFullName(), array("/user/default/view", "id" => $data->createUser->id))',
            ),
            array(
                'name'  => 'create_date',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "short", "short")',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>