<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('contentblock')->getCategory() => array(''),
        Yii::t('ContentBlockModule.contentblock', 'Блоки контента') => array('/contentblock/default/index'),
        Yii::t('ContentBlockModule.contentblock', 'Управление'),
    );

    $this->pageTitle = Yii::t('catalog', 'Блоки контента - управление');

    $this->menu = array(
        array('icon' => 'list-alt','label' => Yii::t('ContentBlockModule.contentblock', 'Управление блоками контента'), 'url' => array('/contentblock/default/index')),
        array('icon' => 'plus-sign','label' => Yii::t('ContentBlockModule.contentblock', 'Добавить блок контента'), 'url' => array('/contentblock/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Блоки контента'); ?>
        <small><?php echo Yii::t('ContentBlockModule.contentblock', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('ContentBlockModule.contentblock', 'Поиск блоков контента'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('content-block-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('ContentBlockModule.contentblock', 'В данном разделе представлены средства управления блоками контента'); ?></p>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'           => 'content-block-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("/contentblock/default/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'type',
            'value' => '$data->getType()',
        ),
        'code',
        'description',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
   ),
)); ?>