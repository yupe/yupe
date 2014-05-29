<?php
    $this->breadcrumbs = array(      
        Yii::t('DictionaryModule.dictionary', 'Dictionaries') => array('/dictionary/dictionaryBackend/index'),
        Yii::t('DictionaryModule.dictionary', 'Management'),
    );

    $this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionaries - manage');

    $this->menu = array(
        array('label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries management'), 'url' => array('/dictionary/dictionaryBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Dictionary crate'), 'url' => array('/dictionary/dictionaryBackend/create')),
        )),
        array('label' => Yii::t('DictionaryModule.dictionary', 'Items'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Items list'), 'url' => array('/dictionary/dictionaryDataBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Create item'), 'url' => array('/dictionary/dictionaryDataBackend/create')),
        )),
    );
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Dictionaries'); ?>
        <small><?php echo Yii::t('DictionaryModule.dictionary', 'management'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('DictionaryModule.dictionary', 'Find dictionary'), '#', array('class' => 'search-button')); ?>
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

<p><?php echo Yii::t('DictionaryModule.dictionary', 'This section describes dictionary management'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'dictionary-group-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'bulkActions'      => array(
        'actionButtons' => array(
            array(
                'id'         => 'delete-post',
                'buttonType' => 'button',
                'type'       => 'danger',
                'size'       => 'small',
                'label'      => Yii::t('DictionaryModule.dictionary', 'Delete'),
                'click'      => 'js:function(values){ if(!confirm("' . Yii::t('DictionaryModule.dictionary', 'Do you really want to delete selected elements?') . '")) return false; multiaction("delete", values); }',
            ),
        ),
        'checkBoxColumnConfig' => array(
            'name' => 'id'
        ),
    ),
    'columns'      => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
            'type' => 'raw',
            'value' => 'CHtml::link($data->id, array("/dictionary/dictionaryBackend/update", "id" => $data->id))'
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'name',
            'editable' => array(
                'url' => $this->createUrl('/dictionary/dictionaryBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'code',
            'editable' => array(
                'url' => $this->createUrl('/dictionary/dictionaryBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'description',
            'editable' => array(
                'url' => $this->createUrl('/dictionary/dictionaryBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'header' => Yii::t('DictionaryModule.dictionary', 'Records'),
            'type'   => 'raw',
            'value'  => 'CHtml::link($data->dataCount, array("/dictionary/dictionaryDataBackend/index", "group_id" => $data->id))',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>