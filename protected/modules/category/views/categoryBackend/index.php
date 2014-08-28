<?php
$this->breadcrumbs = array(
    Yii::t('CategoryModule.category', 'Categories') => array('/category/categoryBackend/index'),
    Yii::t('CategoryModule.category', 'Manage'),
);

$this->pageTitle = Yii::t('CategoryModule.category', 'Categories - manage');

$this->menu = array(
    array(
        'icon'  => 'glyphicon glyphicon-list-alt',
        'label' => Yii::t('CategoryModule.category', 'Category manage'),
        'url'   => array('/category/categoryBackend/index')
    ),
    array(
        'icon'  => 'glyphicon glyphicon-plus-sign',
        'label' => Yii::t('CategoryModule.category', 'Create category'),
        'url'   => array('/category/categoryBackend/create')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Categories'); ?>
        <small><?php echo Yii::t('CategoryModule.category', 'manage'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="glyphicon glyphicon-search">&nbsp;</i>
        <?php echo Yii::t('CategoryModule.category', 'Find category'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('category-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<p><?php echo Yii::t('CategoryModule.category', 'This section describes category management'); ?></p>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'category-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width:20px'),
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->id, array("/category/categoryBackend/update", "id" => $data->id))'
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => array(
                    'url'    => $this->createUrl('/category/categoryBackend/inline'),
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
                    'url'    => $this->createUrl('/category/categoryBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'alias', array('class' => 'form-control')),
            ),
            array(
                'name'   => 'parent_id',
                'value'  => '$data->getParentName()',
                'filter' => CHtml::activeDropDownList(
                        $model,
                        'parent_id',
                        Category::model()->getFormattedList(),
                        array('encode' => false, 'empty' => '', 'class' => 'form-control')
                    )
            ),
            array(
                'name'   => 'image',
                'type'   => 'raw',
                'value'  => '$data->image ? CHtml::image($data->imageSrc, $data->name, array("width"  => 100, "height" => 100)) : "---"',
                'filter' => false
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/category/categoryBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'CategoryModule.category',
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
                'value'  => '$data->lang',
                'filter' => $this->yupe->getLanguagesList()
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
