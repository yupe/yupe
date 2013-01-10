<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('dictionary')->getCategory() => array(),
        Yii::t('DictionaryModule.dictionary', 'Справочники') => array('/dictionary/default/index'),
        Yii::t('DictionaryModule.dictionary', 'Значения справочников') => array('/dictionary/dictionaryData/index'),
        Yii::t('DictionaryModule.dictionary', 'Управление'),
    );

    $this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Значения справочников - управление');

    $this->menu = array(
        array('label' => Yii::t('DictionaryModule.dictionary', 'Справочники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Управление справочниками'), 'url' => array('/dictionary/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавление справочника'), 'url' => array('/dictionary/default/create')),
        )),
        array('label' => Yii::t('DictionaryModule.dictionary', 'Значения'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Список значений'), 'url' => array('/dictionary/dictionaryData/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавить значение'), 'url' => array('/dictionary/dictionaryData/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Значения справочников'); ?>
        <small><?php echo Yii::t('DictionaryModule.dictionary', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('DictionaryModule.dictionary', 'Поиск значений справочников'), '#', array('class' => 'search-button')); ?>
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

<p><?php echo Yii::t('DictionaryModule.dictionary', 'В данном разделе представлены средства управления значениями справочников'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'          => 'dictionary-data-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("/dictionary/dictionaryData/update", "id" => $data->id))',
        ),
        'value',
        'code',
        array(
            'name'  => 'group_id',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->group->name, array("/dictionary/default/update", "id" => $data->group->id))',
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
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("lock", "ok-sign"))',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>