<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('catalog')->getCategory() => array(),
        Yii::t('catalog', 'Товары') => array('/catalog/default/index'),
        Yii::t('catalog', 'Управление'),
    );

    $this->pageTitle = Yii::t('catalog', 'Товары - управление');

    $this->menu = array(
        array('icon' => 'list-alt white', 'label' => Yii::t('catalog', 'Управление товарами'), 'url' => array('/catalog/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('catalog', 'Добавить товар'), 'url' => array('/catalog/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('catalog', 'Товары'); ?>
        <small><?php echo Yii::t('catalog', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('catalog', 'Поиск товаров'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
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

<p>
    <?php echo Yii::t('catalog', 'В данном разделе представлены средства управления'); ?>    <?php echo Yii::t('catalog', 'товарами'); ?>.
</p>


<?php
$this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'good-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        'category_id',
        'name',
        'price',
        'article',
        'image',
        /*
        'short_description',
        'description',
        'alias',
        'data',
        'is_special',
        'status',
        'create_time',
        'update_time',
        'user_id',
        'change_user_id',
        */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>