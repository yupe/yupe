<?php

/**
 * @var $model Page
 * @var $this PageBackendController
 * @var $pages array
 */
$this->breadcrumbs = array(
        Yii::t('PageModule.page', 'Pages') => array('/page/pageBackend/index'),
        Yii::t('PageModule.page', 'List'),
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Pages list');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Pages list'), 'url' => array('/page/pageBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Create page'), 'url' => array('/page/pageBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Pages'); ?>
        <small><?php echo Yii::t('PageModule.page', 'manage'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('PageModule.page', 'Find pages'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('page-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model, 'pages' => $pages));
?>
</div>

<br/>

<p><?php echo Yii::t('PageModule.page', 'This section describes page management'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'page-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'sortField'    => 'order',
    'columns'      => array(
        array(
            'name'  => 'id',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->id, array("/page/pageBackend/update", "id" => $data->id))',
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'title',
            'editable' => array(
                'url' => $this->createUrl('/page/pageBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'slug',
            'editable' => array(
                'url' => $this->createUrl('/page/pageBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'name'  => 'category_id',
            'value' => '$data->getCategoryName()',
			'filter' => CHtml::activeDropDownList($model, 'category_id', Category::model()->getFormattedList(Yii::app()->getModule('page')->mainCategory), array('encode' => false, 'empty' => ''))
        ),
        array(
            'name'   => 'parent_id',
            'value'  => '$data->parentName',
            'filter' => CHtml::listData(Page::model()->findAll(),'id','title')
        ),

        array(
            'name'  => 'order',
            'type'  => 'raw',
            'value' => '$this->grid->getUpDownButtons($data)',
        ),
        array(
            'name'  => 'lang',
            'value'  => '$data->lang',
            'filter' => $this->yupe->getLanguagesList()
        ),
        array(
            'class'  => 'bootstrap.widgets.TbEditableColumn',
            'editable' => array(
                'url'  => $this->createUrl('/page/pageBackend/inline'),
                'type' => 'select',
				'title'  => Yii::t('PageModule.page', 'Select {field}', array('{field}' => mb_strtolower($model->getAttributeLabel('status')))),
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
            'header' => Yii::t('PageModule.page', 'Public URL'),
            'type'   => 'raw',
            'value'  => 'CHtml::link($data->getPermaLink(),$data->getPermaLink(),array("target" => "_blank"))',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>