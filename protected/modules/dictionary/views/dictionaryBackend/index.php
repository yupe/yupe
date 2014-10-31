<?php
$this->breadcrumbs = array(
    Yii::t('DictionaryModule.dictionary', 'Dictionaries') => array('/dictionary/dictionaryBackend/index'),
    Yii::t('DictionaryModule.dictionary', 'Management'),
);

$this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionaries - manage');

$this->menu = array(
    array(
        'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries management'),
                'url'   => array('/dictionary/dictionaryBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('DictionaryModule.dictionary', 'Dictionary crate'),
                'url'   => array('/dictionary/dictionaryBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('DictionaryModule.dictionary', 'Items'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('DictionaryModule.dictionary', 'Items list'),
                'url'   => array('/dictionary/dictionaryDataBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('DictionaryModule.dictionary', 'Create item'),
                'url'   => array('/dictionary/dictionaryDataBackend/create')
            ),
        )
    ),
);
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Dictionaries'); ?>
        <small><?php echo Yii::t('DictionaryModule.dictionary', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Find dictionary'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('dictionary-group-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'dictionary-group-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/dictionary/dictionaryBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns'      => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width:20px'),
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->id, array("/dictionary/dictionaryBackend/update", "id" => $data->id))'
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => array(
                    'url'    => $this->createUrl('/dictionary/dictionaryBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'code',
                'editable' => array(
                    'url'    => $this->createUrl('/dictionary/dictionaryBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'code', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'description',
                'editable' => array(
                    'url'    => $this->createUrl('/dictionary/dictionaryBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'description', array('class' => 'form-control')),
            ),
            array(
                'header' => Yii::t('DictionaryModule.dictionary', 'Records'),
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->dataCount, array("/dictionary/dictionaryDataBackend/index", "group_id" => $data->id))',
            ),
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
