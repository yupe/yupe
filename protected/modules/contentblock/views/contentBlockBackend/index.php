<?php
    $this->breadcrumbs = array(       
        Yii::t('ContentBlockModule.contentblock', 'Content blocks') => array('/contentblock/contentBlockBackend/index'),
        Yii::t('ContentBlockModule.contentblock', 'Administration'),
    );

    $this->pageTitle = Yii::t('ContentBlockModule.contentblock', 'Content blocks - admin');

    $this->menu = array(
        array('icon' => 'list-alt','label' => Yii::t('ContentBlockModule.contentblock', 'Content blocks administration'), 'url' => array('/contentblock/contentBlockBackend/index')),
        array('icon' => 'plus-sign','label' => Yii::t('ContentBlockModule.contentblock', 'Add new content block'), 'url' => array('/contentblock/contentBlockBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Content blocks'); ?>
        <small><?php echo Yii::t('ContentBlockModule.contentblock', 'administration'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('ContentBlockModule.contentblock', 'Find content blocks'), '#', array('class' => 'search-button')); ?>
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

<p><?php echo Yii::t('ContentBlockModule.contentblock', 'This section presents content blocks management'); ?></p>

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
            'value' => 'CHtml::link($data->name, array("/contentblock/contentBlockBackend/update", "id" => $data->id))',
        ),
        array(
            'name'   => 'type',
            'value'  => '$data->getType()',
            'filter' => $model->getTypes()
        ),
        'code',
        'description',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
   ),
)); ?>