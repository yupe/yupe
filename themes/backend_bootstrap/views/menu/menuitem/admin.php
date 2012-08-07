<?php
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню') => array('menu/admin'),
    Yii::t('menu', 'Пункты меню'),
);

$this->menu = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('label' => Yii::t('menu', 'Добавить меню'), 'url' => array('menu/create')),
    array('label' => Yii::t('menu', 'Список меню'), 'url' => array('menu/index')),
    array('label' => Yii::t('menu', 'Управление меню'), 'url' => array('menu/admin')),

    array('label' => Yii::t('menu', 'Пункты меню')),
    array('label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('create')),
    array('label' => Yii::t('menu', 'Cписок пунктов меню'), 'url' => array('index')),
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

<div class="page-header"><h1><?php echo $this->module->getName()?> <small><?php echo Yii::t('menu', 'управление'); ?></small></h1></div>

<button class="btn btn-small dropdown-toggle"
        data-toggle="collapse"
        data-target="#search-toggle" >
    <i class="icon-search"></i>
    <?php echo CHtml::link(Yii::t('menu', 'Поиск пунктов меню'), '#', array('class' => 'search-button')); ?>
    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
    <?php
    Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('news-grid', {
                data: $(this).serialize()
        });
        return false;
        });
    ");
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<?php
$this->widget('YCustomGridView', array(
    'id' => 'menu-grid',
    'itemsCssClass' => ' table table-condensed',
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
        array(
            'name' => 'condition_name',
            'value' => '$data->conditionName',
        ),
        array(
            'name'  => 'sort',
            'type'  => 'raw',
            'value' => '$this->grid->getUpDownButtons($data)'
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data)',
        ),
        array(
            'class' => 'bootstrap.widgets.BootButtonColumn',
        ),
    ),
));
?>