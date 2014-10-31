<?php

/**
 * @var $model News
 * @var $this NewsBackendController
 */

$this->breadcrumbs = array(
    Yii::t('NewsModule.news', 'News') => array('/news/newsBackend/index'),
    Yii::t('NewsModule.news', 'Management'),
);

$this->pageTitle = Yii::t('NewsModule.news', 'News - management');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('NewsModule.news', 'News management'),
        'url'   => array('/news/newsBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('NewsModule.news', 'Create article'),
        'url'   => array('/news/newsBackend/create')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'News'); ?>
        <small><?php echo Yii::t('NewsModule.news', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('NewsModule.news', 'Find news'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('news-grid', {
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
        'id'           => 'news-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'title',
                'editable' => array(
                    'url'    => $this->createUrl('/news/newsBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'title', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'alias',
                'editable' => array(
                    'url'    => $this->createUrl('/news/newsBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'alias', array('class' => 'form-control')),
            ),
            'date',
            array(
                'name'   => 'category_id',
                'value'  => '$data->getCategoryName()',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'category_id',
                    Category::model()->getFormattedList(Yii::app()->getModule('news')->mainCategory),
                    array('class' => 'form-control', 'encode' => false, 'empty' => '')
                )
            ),
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/news/newsBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    News::STATUS_PUBLISHED  => ['class' => 'label-success'],
                    News::STATUS_MODERATION => ['class' => 'label-warning'],
                    News::STATUS_DRAFT      => ['class' => 'label-default'],
                ],
            ),
            array(
                'name'   => 'lang',
                'value'  => '$data->getFlag()',
                'filter' => $this->yupe->getLanguagesList(),
                'type'   => 'html'
            ),
            array(
                'class' => 'yupe\widgets\CustomButtonColumn'
            ),
        ),
    )
); ?>
