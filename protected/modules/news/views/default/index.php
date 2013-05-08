<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('news')->getCategory() => array(),
        Yii::t('NewsModule.news', 'Новости') => array('/news/default/index'),
        Yii::t('NewsModule.news', 'Управление'),
    );

    $this->pageTitle = Yii::t('NewsModule.news', 'Новости - управление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('NewsModule.news', 'Управление новостями'), 'url' => array('/news/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('NewsModule.news', 'Добавить новость'), 'url' => array('/news/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'Новости'); ?>
        <small><?php echo Yii::t('NewsModule.news', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('NewsModule.news', 'Поиск новостей'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('news-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('NewsModule.news', 'В данном разделе представлены средства управления новостями'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'news-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
            'type'  => 'raw',
            'value' => 'CHtml::link($data->id, array("/news/default/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'title',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->title, array("/news/default/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'alias',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->alias, array("/news/default/update", "id" => $data->id))',
        ),
        array(
            'name'        => 'date',
            'htmlOptions' => array('style' => 'width:80px'),
        ),
        array(
           'name'   => 'category_id',
           'value'  => '$data->getCategoryName()',
           'filter' => CHtml::listData($this->module->getCategoryList(),'id','name')
        ),
        array(
            'header' => Yii::t('NewsModule.news', 'Публичный урл'),
            'type'   => 'raw',
            'value'  => 'CHtml::link($data->getPermaLink(),$data->getPermaLink(),array("target" => "_blank"))',
        ),
        array(
            'name'  => 'lang',
            'value'  => '$data->lang',
            'filter' => $this->yupe->getLanguagesList()
        ),
        array(
            'name'   => 'status',
            'type'   => 'raw',
            'value'  => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("pencil", "ok-sign", "time"))',
            'filter' => $model->getStatusList()
        ),
        array(
            'class'   => 'bootstrap.widgets.TbButtonColumn'
        ),
    ),
)); ?>