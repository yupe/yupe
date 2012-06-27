<?php
$this->breadcrumbs = array(Yii::t('menu', 'Меню'));

$this->menu = array(
    //@formatter:off
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'file','label' => Yii::t('menu', 'Добавить меню'), 'url' => array('create')),
    array('icon' => 'list','label' => Yii::t('menu', 'Список меню'), 'url' => array('index')),

    array('label' => Yii::t('menu', 'Пункты меню')),
    array('icon' => 'file','label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('menuitem/create')),
    array('icon' => 'list','label' => Yii::t('menu', 'Cписок пунктов меню'), 'url' => array('menuitem/index')),
    array('icon' => 'list-alt','label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('menuitem/admin')),
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

<div class="page-header"><h1><?php echo $this->module->getName()?> <small><?php echo Yii::t('menu', 'управление');; ?></small></h1></div>

<button class="btn btn-small dropdown-toggle"
        data-toggle="collapse"
        data-target="#search-toggle" >
    <i class="icon-search"></i>
    <?php echo CHtml::link(Yii::t('menu', 'Поиск меню'), '#', array('class' => 'search-button')); ?>
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
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>

</div>

<?php
$this->widget('YCustomGridView', array(
    'id' => 'menu-grid',
    'itemsCssClass' => ' table table-condensed',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        'name',
        'code',
        'description',
        array(
            'name' => Yii::t('menu', 'Пунктов'),
            'value' => 'count($data->menuItems)',
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data)',
            'htmlOptions' => array('style'=>'width:40px; text-align:center;'),
        ),
        array(
            'class'    => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{view}{update}{delete}{add}',
            'buttons'  => array(
                'add' => array(
                    'label' => false,
                    'url'   => 'Yii::app()->createUrl("/menu/menuitem/create/",array("mid" => $data->id))',
                    'options' => array(
                        'class' => 'icon-plus-sign',
                        'title' => Yii::t('menu','Добавить пункт меню')
                    )
                )
            )
        ),
    ),
));
?>