<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('news')->getCategory() => array(),
        Yii::t('news', 'Новости') => array('/news/default/index'),
        Yii::t('news', 'Управление'),
    );

    $this->pageTitle = Yii::t('news', 'Новости - управление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление новостями'), 'url' => array('/news/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('news', 'Добавить новость'), 'url' => array('/news/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('news', 'Новости'); ?>
        <small><?php echo Yii::t('news', 'управление'); ?></small>
    </h1>
</div>


<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('news', 'Поиск новостей'), '#', array('class' => 'search-button')); ?>
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

<p><?php echo Yii::t('news', 'В данном разделе представлены средства управления новостями'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'            => 'news-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
        ),
        array(
            'name'  => 'title',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->title, array("/news/default/update", "alias" => $data->alias))',
        ),
        array(
            'name'        => 'date',
            'htmlOptions' => array('style' => 'width:80px'),
        ),
        array(
           'name'  => 'category_id',
           'value' => '$data->getCategoryName()',
        ),
        'alias',
        array(
            'header' => Yii::t('news', 'Публичный урл'),
            'value'  => '$data->getPermaLink()',
        ),
        'lang',
        array(
            'name'   => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("pencil", "ok-sign", "time"))',
        ),
        array(
            'class'   => 'bootstrap.widgets.TbButtonColumn',
            'buttons' => array(
                'update' => array('url' => 'array("/news/default/update", "alias" => $data->alias)'),
            ),
        ),
    ),
)); ?>