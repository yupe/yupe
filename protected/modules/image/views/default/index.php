<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('image')->getCategory() => array(),
        Yii::t('ImageModule.image', 'Изображения') => array('/image/default/index'),
        Yii::t('ImageModule.image', 'Управление'),
    );

    $this->pageTitle = Yii::t('ImageModule.image', 'Изображения - управление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ImageModule.image', 'Управление изображениями'), 'url' => array('/image/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ImageModule.image', 'Добавить изображение'), 'url' => array('/image/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo ucfirst(Yii::t('ImageModule.image', 'Изображения')); ?>
        <small><?php echo Yii::t('ImageModule.image', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('ImageModule.image', 'Поиск изображений'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form').submit(function() {
        $.fn.yiiGridView.update('image-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('ImageModule.image', 'В данном разделе представлены средства управления изображениями'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'image-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        array(
            'name'  => Yii::t('ImageModule.image', 'file'),
            'type'  => 'raw',
            'value' => 'CHtml::image($data->getUrl(), $data->alt, array("width" => 75, "height" => 75))',
        ),
        array(
           'name'  => 'category_id',
           'value' => '$data->getCategoryName()'
        ),
        'name',
        'alt',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>