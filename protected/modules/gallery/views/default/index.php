<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('gallery')->getCategory() => array(),
        Yii::t('gallery', 'Галереи') => array('/gallery/default/index'),
        Yii::t('gallery', 'Управление'),
    );

    $this->pageTitle = Yii::t('gallery', 'Галереи - управление');

    $this->menu = array(
        array('icon' => 'list-alt white', 'label' => Yii::t('gallery', 'Управление галереями'), 'url' => array('/gallery/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('gallery', 'Добавить галерею'), 'url' => array('/gallery/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('gallery', 'Галереи'); ?>
        <small><?php echo Yii::t('gallery', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('gallery', 'Поиск галерей'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('gallery-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p>
    <?php echo Yii::t('gallery', 'В данном разделе представлены средства управления'); ?>
    <?php echo Yii::t('gallery', 'галереями'); ?>.
</p>

<?php
$this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'gallery-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        'name',
        'description',
        'status',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>