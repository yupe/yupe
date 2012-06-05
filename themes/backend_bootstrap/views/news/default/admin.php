<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('/news/default/admin'),
    Yii::t('news', 'Управление'),
);

$this->menu = array(
    array('icon' => 'list-alt white', 'label' => Yii::t('news', 'Управление новостями'), 'url' => array('/news/default/admin')),
    array('icon' => 'th-list', 'label' => Yii::t('news', 'Показать анонсами'), 'url' => array('/news/default/index')),
    array('icon' => 'file', 'label' => Yii::t('news', 'Добавить новость'), 'url' => array('create')),
);
?>
<div class="page-header"><h1><?=$this->module->getName()?> <small><?php echo Yii::t('news', 'управление');?></small></h1></div>

<button class="btn btn-small dropdown-toggle"
    data-toggle="collapse"
    data-target="#search-toggle" >
    <i class="icon-search"></i>
    <?=CHtml::link(Yii::t('news', 'Поиск новостей'), '#', array('class' => 'search-button'))?>
    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse <?=isset($_GET[get_class($model)])?'in':'out'; ?>">
<?php
    Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('news-grid', {
                data: $(this).serialize()
        });
        return false;
        });
    ");
    $this->renderPartial('_search', array(
    'model' => $model,
));
?>

</div>
<?php
        $dp = $model->search();
        $dp->criteria->order="date DESC";
        $this->widget('YCustomGridView', array(
                                                       'id' => 'news-grid',
                                                       'dataProvider' => $dp,
                                                       'itemsCssClass' => ' table table-condensed',
                                                       'columns' => array(
                                                           array(
                                                               'header' => '№',
                                                               'name' => 'id',
                                                               'htmlOptions' => array('style'=>'width:20px'),
                                                           ),
                                                           array(
                                                               'name' => 'status',
                                                               'type' => 'raw',
                                                               'value' => '$this->grid->returnBootstrapStatusHtml($data)',
                                                               'htmlOptions' => array('style'=>'width:40px; text-align:center;'),
                                                           ),
                                                           array(
                                                                'name' => 'date',
                                                                'htmlOptions' => array('style'=>'width:80px'),
                                                           ),
                                                           array(
                                                               'name' => 'title',
                                                               'type' => 'raw',
                                                               'value' => 'CHtml::link($data->title,array("/news/default/update","id" => $data->id))'
                                                           ),
                                                           array(
                                                               'class' => 'bootstrap.widgets.BootButtonColumn',
                                                           ),
                                                       ),
                                                  )); ?>
