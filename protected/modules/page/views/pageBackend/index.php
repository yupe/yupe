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
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('PageModule.page', 'Pages list'),
        'url'   => array('/page/pageBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('PageModule.page', 'Create page'),
        'url'   => array('/page/pageBackend/create')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Pages'); ?>
        <small><?php echo Yii::t('PageModule.page', 'manage'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('PageModule.page', 'Find pages'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('page-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );
    $this->renderPartial('_search', array('model' => $model, 'pages' => $pages));
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'page-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'sortField'    => 'order',
        'columns'      => array(
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'title',
                'editable' => array(
                    'url'    => $this->createUrl('/page/pageBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'title', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'slug',
                'editable' => array(
                    'url'    => $this->createUrl('/page/pageBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'slug', array('class' => 'form-control')),
            ),
            array(
                'name'   => 'category_id',
                'value'  => '$data->getCategoryName()',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'category_id',
                    Category::model()->getFormattedList(Yii::app()->getModule('page')->mainCategory),
                    array('encode' => false, 'empty' => '', 'class' => 'form-control')
                )
            ),
            array(
                'name'   => 'parent_id',
                'value'  => '$data->parentName',
                'filter' => CHtml::listData(Page::model()->findAll(), 'id', 'title')
            ),
            array(
                'name'  => 'order',
                'type'  => 'raw',
                'value' => '$this->grid->getUpDownButtons($data)',
            ),
            array(
                'name'   => 'lang',
                'value'  => '$data->lang',
                'filter' => $this->yupe->getLanguagesList()
            ),
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/page/pageBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Page::STATUS_PUBLISHED  => ['class' => 'label-success'],
                    Page::STATUS_MODERATION => ['class' => 'label-warning'],
                    Page::STATUS_DRAFT      => ['class' => 'label-default'],
                ],
            ),
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
);
?>
