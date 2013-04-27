<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('catalog')->getCategory() => array(),
        Yii::t('CatalogModule.catalog', 'Товары') => array('/catalog/default/index'),
        Yii::t('CatalogModule.catalog', 'Управление'),
    );

    $this->pageTitle = Yii::t('CatalogModule.catalog', 'Товары - управление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Управление товарами'), 'url' => array('/catalog/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CatalogModule.catalog', 'Добавить товар'), 'url' => array('/catalog/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CatalogModule.catalog', 'Товары'); ?>
        <small><?php echo Yii::t('CatalogModule.catalog', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('CatalogModule.catalog', 'Поиск товаров'), '#', array('class' => 'search-button')); ?>
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

<p><?php echo Yii::t('CatalogModule.catalog', 'В данном разделе представлены средства управления товарами'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'good-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("/catalog/default/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'alias',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->alias, $data->permaLink)',
        ),
        array(
            'name'  => 'category_id',
            'type'  => 'raw',
            'value' => '$data->categoryLink'
        ),
        'price',
        'article',
        array(
            'name'  => 'is_special',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "is_special", "Special", array("minus", "star"))',
        ),
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("time", "ok-sign", "minus-sign"))',
        ),
        array(
            'name'  => 'user_id',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->user->getFullName(), array("/user/default/view", "id" => $data->user->id))',
        ),       
        array(
            'name'  => 'create_time',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "short", "short")',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>