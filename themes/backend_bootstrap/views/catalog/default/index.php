<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array(''),
    'Товары' => array('index'),
    Yii::t('yupe', 'Управление'),
);
$this->pageTitle = "товары - " . "Yii::t('yupe', 'управление')";
$this->menu = array(
    array('icon' => 'list-alt white', 'label' => Yii::t('yupe', 'Управление товарами'), 'url' => array('/catalog/default/index')),
    array('icon' => 'file', 'label' => Yii::t('yupe', 'Добавить товар'), 'url' => array('/catalog/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo $this->module->getName(); ?> <small><?php echo Yii::t('yupe', 'управление'); ?></small></h1>
</div>
<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle" >
    <i class="icon-search"></i>
    <a class="search-button" href="#">Поиск товаров</a> <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
    <?php Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('good-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<br/>

<p><?php echo Yii::t('yupe', 'В данном разделе представлены средства управления'); ?> <?php echo Yii::t('yupe', 'товарами'); ?>.</p>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'good-grid',
    'type' => 'condensed',
    'pager' => array('class' => 'bootstrap.widgets.TbPager', 'prevPageLabel' => "←",'nextPageLabel' => "→"),
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name'  => 'category_id',
            'value' => '$data->category->name',
        ),
        'name',
        'alias',
        'price',
        'article',
        'image',
        array(
            'name'  => 'is_special',
            'value' => '$data->getIsSpecial()',
        ),
        array(
            'name'  => 'status',
            'value' => '$data->getStatus()',
        ),
        'create_time',
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>