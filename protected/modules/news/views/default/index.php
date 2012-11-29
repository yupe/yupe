<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('/news/default/index'),
    Yii::t('news', 'Управление'),
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление новостями'), 'url' => array('/news/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('news', 'Добавить новость'), 'url' => array('/news/default/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo $this->module->getName(); ?> 
        <small><?php echo Yii::t('news', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search"></i>
    <?php echo CHtml::link(Yii::t('news', 'Поиск новостей'), '#', array('class' => 'search-button')); ?>
    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse <?php echo isset($_GET[get_class($model)]) ? 'in' : 'out'; ?>">
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
<?php
$this->widget('YCustomGridView', array(
    'id'            => 'news-grid',
    'dataProvider'  => $model->search(),
    'itemsCssClass' => ' table table-condensed',
    'columns'       => array(
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
            'name'  => Yii::t('news', 'Публичный урл'),
            'value' => '$data->getPermaLink()',
        ),
        'lang',
        array(
            'name'        => 'status',
            'type'        => 'raw',
            'value'       => '$this->grid->returnBootstrapStatusHtml($data)',
            'htmlOptions' => array('style' => 'width:40px; text-align:center;'),
        ),
        array(
            'class'   => 'bootstrap.widgets.TbButtonColumn',
            'buttons' => array(
                'update' => array('url' => 'array("/news/default/update", "alias" => $data->alias)'),
            ),
        ),
    ),
));
?>