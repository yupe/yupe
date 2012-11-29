<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('dictionary')->getCategory() => array(),
        Yii::t('dictionary', 'Справочники') => array('/dictionary/default/index'),
        Yii::t('dictionary', 'Управление'),
    );

    $this->pageTitle = Yii::t('dictionary', 'Справочники - управление');

    $this->menu = array(
        array('label' => Yii::t('dictionary', 'Справочники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Управление справочниками'), 'url' => array('/dictionary/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавление справочника'), 'url' => array('/dictionary/default/create')),
        )),
        array('label' => Yii::t('dictionary', 'Значения'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Список значений'), 'url' => array('/dictionary/dictionaryData/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавить значение'), 'url' => array('/dictionary/dictionaryData/create')),
        )),
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
    <?php echo CHtml::link(Yii::t('blog', 'Поиск записей'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('post-grid', {
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

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'dictionary-group-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("/dictionary/default/update", "id" => $data->id))',
        ),
        'code',
        array(
            'name'  => Yii::t('dictionary', 'Записей'),
            'type'  => 'raw',
            'value' => 'CHtml::link($data->dataCount, array("/dictionary/dictionaryData/index", "group_id" => $data->id"))',
        ),
        array(
            'name'  => 'creation_date',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->creation_date, "short", "short")',
        ),
        array(
            'name'  => 'update_date',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->update_date, "short", "short")',
        ),
        array(
            'name'  => 'create_user_id',
            'value' => '$data->createUser->getFullName()',
        ),
        array(
            'name'  => 'update_user_id',
            'value' => '$data->updateUser->getFullName()',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>