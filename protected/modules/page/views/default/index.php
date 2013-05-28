<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('page')->getCategory() => array(),
        Yii::t('PageModule.page', 'Страницы') => array('/page/default/index'),
        Yii::t('PageModule.page', 'Список'),
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Список страниц');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Список страниц'), 'url' => array('/page/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Добавить страницу'), 'url' => array('/page/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Страницы'); ?>
        <small><?php echo Yii::t('PageModule.page', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('PageModule.page', 'Поиск страниц'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('page-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model, 'pages' => $pages));
?>
</div>

<br/>

<p><?php echo Yii::t('PageModule.page', 'В данном разделе представлены средства управления страницами'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'page-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'sortField'    => 'order',
    'columns'      => array(
        array(
            'name'  => 'id',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->id, array("/page/default/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'title',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->title, array("/page/default/update", "id" => $data->id))',
        ),
        'title_short',
        array(
            'name'  => 'slug',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->slug, array("/page/default/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'category_id',
            'value' => '$data->getCategoryName()',
            'filter' => CHtml::listData($this->module->getCategoryList(),'id','name')
        ),
        array(
            'name'  => 'parent_id',
            'value' => '$data->parentName',
        ),
        array(
            'header' => Yii::t('PageModule.page', 'Публичный урл'),
            'type'   => 'raw',
            'value'  => 'CHtml::link($data->getPermaLink(),$data->getPermaLink(),array("target" => "_blank"))',
        ),
        array(
            'name'  => 'order',
            'type'  => 'raw',
            'value' => '$this->grid->getUpDownButtons($data)',
        ),
        array(
            'name'  => 'lang',
            'value'  => '$data->lang',
            'filter' => $this->yupe->getLanguagesList()
        ),
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("pencil", "ok-sign", "time"))',
            'filter' => $model->getStatusList()
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>