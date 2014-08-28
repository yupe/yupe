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
        'icon'  => 'glyphicon glyphicon-list-alt',
        'label' => Yii::t('NewsModule.news', 'News management'),
        'url'   => array('/news/newsBackend/index')
    ),
    array(
        'icon'  => 'glyphicon glyphicon-plus-sign',
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
        <i class="glyphicon glyphicon-search">&nbsp;</i>
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

<p><?php echo Yii::t('NewsModule.news', 'This section describes News Management'); ?></p>

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
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/news/newsBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'NewsModule.news',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('status')))
                        ),
                    'source' => $model->getStatusList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'status',
                'type'     => 'raw',
                'value'    => '$data->getStatus()',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'status',
                        $model->getStatusList(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'name'   => 'lang',
                'value'  => '$data->getFlag()',
                'filter' => $this->yupe->getLanguagesList(),
                'type'   => 'html'
            ),
            array(
                'value' => 'yupe\helpers\Html::label($data->status, $data->getStatus(), [News::STATUS_DRAFT => yupe\helpers\Html::DEF, News::STATUS_PUBLISHED => yupe\helpers\Html::SUCCESS, News::STATUS_MODERATION => yupe\helpers\Html::WARNING])',
                'type'  => 'raw'
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn'
            ),
        ),
    )
); ?>
