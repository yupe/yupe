<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('page')->getCategory() => array(),
        Yii::t('PageModule.page', 'Страницы') => array('/page/default/index'),
        Yii::t('PageModule.page', 'Управление'),
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Управление страницами');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Управление страницами'), 'url' => array('/page/default/index')),
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
        'id',
        array(
            'name'  => 'title',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->title, array("/page/default/update", "slug" => $data->slug))',
        ),
        'title_short',
        array(
            'name'  => 'category_id',
            'value' => '$data->getCategoryName()',
        ),
        array(
            'name'  => 'parent_id',
            'value' => '($data->parentPage) ? $data->parentPage->title : ""',
        ),
        array(
            'name'  => 'slug',
            'value' => '$data->slug',
        ),
        array(
            'header' => Yii::t('PageModule.page', 'Публичный урл'),
            'value'  => 'Yii::app()->createAbsoluteUrl("/page/page/show", array("slug" => $data->slug))',
        ),
        array(
            'name'  => 'order',
            'type'  => 'raw',
            'value' => '$this->grid->getUpDownButtons($data)',
        ),
        'lang',
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("pencil", "ok-sign", "time"))',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>
