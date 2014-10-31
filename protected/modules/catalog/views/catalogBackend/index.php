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
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CatalogModule.catalog', 'Manage products'),
        'url'   => array('/catalog/catalogBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CatalogModule.catalog', 'Add a product'),
        'url'   => array('/catalog/catalogBackend/create')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CatalogModule.catalog', 'Products'); ?>
        <small><?php echo Yii::t('CatalogModule.catalog', 'administration'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('CatalogModule.catalog', 'Find products'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('good-grid', {
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
        'id'             => 'good-grid',
        'dataProvider'   => $model->search(),
        'filter'         => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/catalog/catalogBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns'        => array(
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => array(
                    'url'    => $this->createUrl('/catalog/catalogBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'alias',
                'editable' => array(
                    'url'    => $this->createUrl('/catalog/catalogBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'alias', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/catalog/catalogBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                        'CatalogModule.catalog',
                        'Select {field}',
                        array('{field}' => mb_strtolower($model->getAttributeLabel('category_id')))
                    ),
                    'source' => Category::model()->getFormattedList(Yii::app()->getModule('catalog')->mainCategory),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'category_id',
                'type'     => 'raw',
                'value'    => '$data->category->name',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'category_id',
                    Category::model()->getFormattedList(Yii::app()->getModule('catalog')->mainCategory),
                    array('encode' => false, 'empty' => '', 'class' => 'form-control')
                )
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'price',
                'editable' => array(
                    'url'    => $this->createUrl('/catalog/catalogBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'price', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'article',
                'editable' => array(
                    'url'    => $this->createUrl('/catalog/catalogBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'article', array('class' => 'form-control')),
            ),
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'is_special',
                'url'     => $this->createUrl('/catalog/catalogBackend/inline'),
                'source'  => $model->getSpecialList(),
                'options' => [
                    Good::SPECIAL_ACTIVE     => array('class' => 'label-success'),
                    Good::SPECIAL_NOT_ACTIVE => array('class' => 'label-default'),
                ],
            ),
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/catalog/catalogBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Good::STATUS_ACTIVE     => ['class' => 'label-success'],
                    Good::STATUS_NOT_ACTIVE => ['class' => 'label-warning'],
                    Good::STATUS_ZERO       => ['class' => 'label-default'],
                ],
            ),
            array(
                'name'   => 'user_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->user->getFullName(), array("/user/userBackend/view", "id" => $data->user->id))',
                'filter' => CHtml::listData(
                    User::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll(),
                    'id',
                    'nick_name'
                )
            ),
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
