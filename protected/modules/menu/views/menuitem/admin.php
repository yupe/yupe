<?php
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню') => array('admin'),
    Yii::t('menu', 'Пункты меню'),
);

$this->menu = array(
    //@formatter:off
    array('label' => Yii::t('menu', 'Меню')),
    array('label' => Yii::t('menu', 'Добавить меню'), 'url' => array('menu/create')),
    array('label' => Yii::t('menu', 'Список меню'), 'url' => array('menu/index')),
    array('label' => Yii::t('menu', 'Управление меню'), 'url' => array('menu/admin')),

    array('label' => Yii::t('menu', 'Пункты меню')),
    array('label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('create')),
    array('label' => Yii::t('menu', 'Cписок пунктов меню'), 'url' => array('index')),
    //@formatter:on
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function() {
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('menu-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<h1><?php echo $this->module->getName(); ?></h1>

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('menu', 'Поиск'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php
$this->widget('YCustomGridView', array(
    'id' => 'menu-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        'title',
        'href',
        array(
            'name' => 'menu_id',
            'value' => '$data->menu->name',
        ),
        // :KLUDGE: Обратить внимание, возможно сделать иначе определение корня
        array(
            'name' => 'parent_id',
            'value' => '$data->parent',
        ),
        'type',
        'sort',
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$this->grid->returnStatusHtml($data)',
        ),
        array(
            'class' => 'CButtonColumn',
            // :TODO: Найти способ сделать компактнее или добавить новый контроллер или создать заявку на yiisoft
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("id" => $data->primaryKey))',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("update", array("id" => $data->primaryKey))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->primaryKey))',
        ),
    ),
));
?>