<?php
$this->breadcrumbs = array(
    $this->getModule('comment')->getCategory() => array(''),
    Yii::t('comment', 'Комментарии') => array('admin'),
    Yii::t('comment', 'Управление'),
);

$this->menu = array(
    array('icon'  => 'plus-sign','label' => Yii::t('comment', 'Добавить комментарий'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('comment-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<h1><?php echo $this->module->getName(); ?> <small><?php echo Yii::t('comment', 'управление'); ?></small></h1>

<button class="btn btn-small dropdown-toggle"  data-toggle="collapse"  data-target="#search-toggle" >
    <i class="icon-search"></i>
    <a class="search-button" href="#"><?php echo Yii::t('comment', 'Поиск комментариев');?></a><span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
    <?php
    Yii::app()->clientScript->registerScript('search', "
        $('.search-form').submit(function() {
            $.fn.yiiGridView.update('comment-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<br/>

<p><?php echo Yii::t('comment', 'В данном разделе представлены средства управления комментариями'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'comment-grid',
    'dataProvider' => $model->search(),
    'columns'      => array(
        array(
            'class'          => 'CCheckBoxColumn',
            'id'             => 'itemsSelected',
            'selectableRows' => '2',
            'htmlOptions'    => array('class' => 'center'),
        ),
        'id',
        'model',
        'model_id',
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data)'
        ),
        'text',
        'creation_date',
        'name',
        'email',
        array(
            'class'              => 'bootstrap.widgets.TbButtonColumn',
            'deleteConfirmation' => Yii::t('comment', 'Вы действительно хотите удалить выбранный комментарий?'),
        ),
    ),
)); ?>