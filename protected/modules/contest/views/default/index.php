<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('contest')->getCategory() => array(),
        Yii::t('contest', 'Конкурсы') => array('/contest/default/index'),
        Yii::t('contest', 'Управление'),
    );

    $this->pageTitle = Yii::t('contest', 'Конкурсы - управление');

    $this->menu = array(
        array('icon' => 'list-alt white', 'label' => Yii::t('contest', 'Управление конкурсами'), 'url' => array('/contest/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('contest', 'Добавить конкурс'), 'url' => array('/contest/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('contest', 'Конкурсы'); ?>
        <small><?php echo Yii::t('contest', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('contest', 'Поиск конкурсов'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('contest-grid', {
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
    <?php echo Yii::t('contest', 'В данном разделе представлены средства управления'); ?>    <?php echo Yii::t('contest', 'конкурсами'); ?>.
</p>


<?php
$this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'contest-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        'name',
        'description',
        'start_add_image',
        'stop_add_image',
        'start_vote',
        /*
        'stop_vote',
        'status',
        */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>