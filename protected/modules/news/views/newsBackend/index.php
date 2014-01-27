<?php
    $this->breadcrumbs = array(       
        Yii::t('NewsModule.news', 'News') => array('/news/newsBackend/index'),
        Yii::t('NewsModule.news', 'Management'),
    );

    $this->pageTitle = Yii::t('NewsModule.news', 'News - management');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('NewsModule.news', 'News management'), 'url' => array('/news/newsBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('NewsModule.news', 'Create article'), 'url' => array('/news/newsBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'News'); ?>
        <small><?php echo Yii::t('NewsModule.news', 'management'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('NewsModule.news', 'Find news'), '#', array('class' => 'search-button')); ?>
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

<p><?php echo Yii::t('NewsModule.news', 'This section describes News Management'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'news-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
            'type'  => 'raw',
            'value' => 'CHtml::link($data->id, array("/news/newsBackend/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'title',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->title, array("/news/newsBackend/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'alias',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->alias, array("/news/newsBackend/update", "id" => $data->id))',
        ),
        array(
            'name'        => 'date',
            'htmlOptions' => array('style' => 'width:80px'),
        ),
        array(
           'name'   => 'category_id',
           'value'  => '$data->getCategoryName()',
		   'filter' => CHtml::activeDropDownList($model, 'category_id', Category::model()->getFormattedList(Yii::app()->getModule('news')->mainCategory), array('encode' => false, 'empty' => ''))
        ),
        array(
            'name'   => 'status',
            'type'   => 'raw',
            'value'  => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("pencil", "ok-sign", "time"))',
            'filter' => $model->getStatusList()
        ),
        array(
            'name'  => 'lang',
            'value'  => '$data->lang',
            'filter' => $this->yupe->getLanguagesList()
        ),
        array(
            'class'   => 'bootstrap.widgets.TbButtonColumn'
        ),
    ),
)); ?>