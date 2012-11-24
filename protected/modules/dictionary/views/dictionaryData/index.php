<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('/dictionary/default/index'),
    Yii::t('dictionary', 'Значения справочников') => array('/dictionary/dictionaryData/index'),
    Yii::t('dictionary', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('dictionary', 'Значения')),
    array('icon' => 'list-alt','label' => Yii::t('dictionary', 'Список значений'), 'url' => array('/dictionary/dictionaryData/index')),
    array('icon' => 'plus-sign','label' => Yii::t('dictionary', 'Добавить значение'), 'url' => array('/dictionary/dictionaryData/create')),
    array('label' => Yii::t('dictionary', 'Справочники')),
    array('icon' => 'list-alt','label' => Yii::t('dictionary', 'Список справочников'), 'url' => array('/dictionary/default/index')),
    array('icon' => 'plus-sign','label' => Yii::t('dictionary', 'Добавить справочник'), 'url' => array('/dictionary/default/create')),
);

?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('dictionary', 'Значения справочников'); ?>
        <small><?php echo Yii::t('dictionary', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('dictionary', 'Поиск значений'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('dictionary-data-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('dictionary', 'В данном разделе представлены средства управления значениями справочников'); ?></p>

<?php $this->widget('YCustomGridView', array(
    'id'          => 'dictionary-data-grid',
    'dataProvider'=> $model->search(),
    'columns'     => array(
        'id',
        array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name,array("/dictionary/dictionaryData/update/","id" => $data->id))',
        ),
        'value',
        'code',
        array(
            'name'  => 'group_id',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->group->name,array("/dictionary/default/update/","id" => $data->group->id))',
        ),
        'creation_date',
        'update_date',
        array(
            'name'  => 'create_user_id',
            'value' => '$data->createUser->getFullName()',
        ),
        array(
            'name'  => 'update_user_id',
            'value' => '$data->updateUser->getFullName()',
        ),
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data)',
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>