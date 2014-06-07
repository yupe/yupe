<?php
    $this->breadcrumbs = array(        
        Yii::t('DictionaryModule.dictionary', 'Dictionaries') => array('/dictionary/dictionaryBackend/index'),
        Yii::t('DictionaryModule.dictionary', 'Dictionary items') => array('/dictionary/dictionaryDataBackend/index'),
        Yii::t('DictionaryModule.dictionary', 'Management'),
    );

    $this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionary items - management');

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
        <?php echo Yii::t('DictionaryModule.dictionary', 'Dictionary items'); ?>
        <small><?php echo Yii::t('DictionaryModule.dictionary', 'management'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('DictionaryModule.dictionary', 'Find dictionariy items'), '#', array('class' => 'search-button')); ?>
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

<p><?php echo Yii::t('DictionaryModule.dictionary', 'This section describes dictionary items management'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'          => 'dictionary-data-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
            'type' => 'raw',
            'value' => 'CHtml::link($data->id, array("/dictionary/dictionaryDataBackend/update", "id" => $data->id))'
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'name',
            'editable' => array(
                'url' => $this->createUrl('/dictionary/dictionaryDataBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'value',
            'editable' => array(
                'url' => $this->createUrl('/dictionary/dictionaryDataBackend/inline'),
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
                'url' => $this->createUrl('/dictionary/dictionaryDataBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'class'  => 'bootstrap.widgets.TbEditableColumn',
			'editable' => array(
				'url'    => $this->createUrl('/dictionary/dictionaryDataBackend/inline'),
				'mode'   => 'popup',
				'type'   => 'select',
				'title'  => Yii::t('DictionaryModule.dictionary', 'Select {field}', array('{field}' => mb_strtolower($model->getAttributeLabel('group_id')))),
				'source' => CHtml::listData(DictionaryGroup::model()->findAll(), 'id', 'name'),
				'params' => array(
					Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
				)
			),
            'name'   => 'group_id',
            'type'   => 'raw',
            'value'  => '$data->group->name',
            'filter' => CHtml::listData(DictionaryGroup::model()->findAll(), 'id', 'name')
        ),
        array(
            'class'  => 'bootstrap.widgets.TbEditableColumn',
			'editable' => array(
				'url'    => $this->createUrl('/dictionary/dictionaryDataBackend/inline'),
				'mode'   => 'popup',
				'type'   => 'select',
				'title'  => Yii::t('DictionaryModule.dictionary', 'Select {field}', array('{field}' => mb_strtolower($model->getAttributeLabel('status')))),
				'source' => $model->getStatusList(),
				'params' => array(
					Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
				)
			),
            'name'   => 'status',
            'type'   => 'raw',
            'value'  => '$data->getStatus()',
            'filter' => $model->getStatusList()
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>