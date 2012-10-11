<?php
$this->breadcrumbs = array(Yii::t('menu', 'Меню'));

$this->menu = array(
    //@formatter:off
    array('label' => Yii::t('menu', 'Меню')),
    array('label' => Yii::t('menu', 'Добавить меню'), 'url' => array('create')),
    array('label' => Yii::t('menu', 'Список меню'), 'url' => array('index')),

    array('label' => Yii::t('menu', 'Пункты меню')),
    array('label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('menuitem/create')),
    array('label' => Yii::t('menu', 'Cписок пунктов меню'), 'url' => array('menuitem/index')),
    array('label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('menuitem/admin')),
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
        ),
        array(
            'class'    => 'CButtonColumn',
            'template' => '{view}{update}{delete}{add}',
            'buttons'  => array(
                'add' => array(
                    'label' => Yii::t('dictionary','Добавить пункт меню'),
                    'url'   => 'Yii::app()->createUrl("/menu/menuitem/create/",array("mid" => $data->id))',
                    'imageUrl' => Yii::app()->baseUrl.'/web/images/add.png'
                )
            )
        ),
    ),
));
?>