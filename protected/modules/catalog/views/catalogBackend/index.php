<?php

/**
 * @var $model Good
 * @var $this CatalogBackendController
 */
$this->breadcrumbs = array(
        Yii::t('CatalogModule.catalog', 'Products') => array('/catalog/catalogBackend/index'),
        Yii::t('CatalogModule.catalog', 'Manage'),
    );

    $this->pageTitle = Yii::t('CatalogModule.catalog', 'Manage products');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Manage products'), 'url' => array('/catalog/catalogBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CatalogModule.catalog', 'Add a product'), 'url' => array('/catalog/catalogBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CatalogModule.catalog', 'Products'); ?>
        <small><?php echo Yii::t('CatalogModule.catalog', 'administration'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('CatalogModule.catalog', 'Find products'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('good-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('CatalogModule.catalog', 'This section describes products manager'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'good-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
            'type' => 'raw',
            'value' => 'CHtml::link($data->id, array("/catalog/catalogBackend/update", "id" => $data->id))'
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'name',
            'editable' => array(
                'url' => $this->createUrl('/catalog/catalogBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'alias',
            'editable' => array(
                'url' => $this->createUrl('/catalog/catalogBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'class'  => 'bootstrap.widgets.TbEditableColumn',
			'editable' => array(
				'url'    => $this->createUrl('/catalog/catalogBackend/inline'),
				'mode'   => 'popup',
				'type'   => 'select',
				'title'  => Yii::t('CatalogModule.catalog', 'Select {field}', array('{field}' => mb_strtolower($model->getAttributeLabel('category_id')))),
				'source' => Category::model()->getFormattedList(Yii::app()->getModule('catalog')->mainCategory),
				'params' => array(
					Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
				)
			),
            'name'   => 'category_id',
            'type'   => 'raw',
            'value'  => '$data->category->name',
            'filter' => CHtml::activeDropDownList($model, 'category_id', Category::model()->getFormattedList(Yii::app()->getModule('catalog')->mainCategory), array('encode' => false, 'empty' => ''))
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'price',
            'editable' => array(
                'url' => $this->createUrl('/catalog/catalogBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'article',
            'editable' => array(
                'url' => $this->createUrl('/catalog/catalogBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),

        array(
            'name'  => 'is_special',
            'type'  => 'raw',
            'value'  => '$this->grid->returnBootstrapStatusHtml($data, "is_special", "Special", array("minus", "star"))',
            'filter' => Yii::app()->getModule('catalog')->getChoice()
        ),
        array(
            'class'  => 'bootstrap.widgets.TbEditableColumn',
			'editable' => array(
				'url'    => $this->createUrl('/catalog/catalogBackend/inline'),
				'mode'   => 'popup',
				'type'   => 'select',
				'title'  => Yii::t('CatalogModule.catalog', 'Select {field}', array('{field}' => mb_strtolower($model->getAttributeLabel('status')))),
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
            'name'   => 'user_id',
            'type'   => 'raw',
            'value'  => 'CHtml::link($data->user->getFullName(), array("/user/userBackend/view", "id" => $data->user->id))',
            'filter' => CHtml::listData(User::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll(),'id','nick_name')
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>