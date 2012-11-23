<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Справочники') => array('admin'),
    Yii::t('dictionary', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('dictionary', 'Справочники')),
    array('icon' => 'list-alt white','label' => Yii::t('dictionary', 'Список справочников'), 'url' => array('/dictionary/default/admin')),
    array('icon' => 'plus-sign','label' => Yii::t('dictionary', 'Добавить справочник'), 'url' => array('/dictionary/default/create')),
    array('label' => Yii::t('dictionary', 'Значения')),
    array('icon' => 'list-alt','label' => Yii::t('dictionary', 'Список значений'), 'url' => array('/dictionary/dictionaryData/admin')),
    array('icon' => 'plus-sign','label' => Yii::t('dictionary', 'Добавить значение'), 'url' => array('/dictionary/dictionaryData/create')),
);
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('dictionary', 'Справочники'); ?>
        <small><?php echo Yii::t('dictionary', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('dictionary', 'Поиск справочников'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('dictionary-group-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('dictionary', 'В данном разделе представлены средства управления справочниками'); ?></p>

<?php
$this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id' => 'dictionary-group-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name,array("/dictionary/default/update/","id" => $data->id))'
        ),
        'code',
        array(
            'name' => Yii::t('dictionary', 'Записей'),
            'type' => 'raw',
            'value' => 'CHtml::link($data->dataCount,array("/dictionary/dictionaryData/admin?group_id={$data->id}"))'
        ),
        'creation_date',
        'update_date',
        array(
            'name' => 'create_user_id',
            'value' => '$data->createUser->getFullName()'
        ),
        array(
            'name' => 'update_user_id',
            'value' => '$data->updateUser->getFullName()'
        ),        
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',            
        ),
    ),
));
?>