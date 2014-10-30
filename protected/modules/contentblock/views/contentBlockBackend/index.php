<?php
$this->breadcrumbs = array(
    Yii::t('ContentBlockModule.contentblock', 'Content blocks') => array('/contentblock/contentBlockBackend/index'),
    Yii::t('ContentBlockModule.contentblock', 'Administration'),
);

$this->pageTitle = Yii::t('ContentBlockModule.contentblock', 'Content blocks - admin');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('ContentBlockModule.contentblock', 'Content blocks administration'),
        'url'   => array('/contentblock/contentBlockBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('ContentBlockModule.contentblock', 'Add new content block'),
        'url'   => array('/contentblock/contentBlockBackend/create')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Blocks'); ?>
        <small><?php echo Yii::t('ContentBlockModule.contentblock', 'administration'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Find content blocks'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('content-block-grid', {
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
        'id'           => 'content-block-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => array(
                    'url'    => $this->createUrl('/contentblock/contentBlockBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/contentblock/contentBlockBackend/inline'),
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'ContentBlockModule.contentblock',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('type')))
                        ),
                    'source' => $model->getTypes(),
                    'params' => array(
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    )
                ),
                'name'     => 'type',
                'type'     => 'raw',
                'value'    => '$data->getType()',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'type',
                        $model->getTypes(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'code',
                'editable' => array(
                    'url'    => $this->createUrl('/contentblock/contentBlockBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'code', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'description',
                'editable' => array(
                    'url'       => $this->createUrl('/contentblock/contentBlockBackend/inline'),
                    'title'     => Yii::t(
                            'ContentBlockModule.contentblock',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('description')))
                        ),
                    'emptytext' => Yii::t(
                            'ContentBlockModule.contentblock',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('description')))
                        ),
                    'params'    => array(
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'description', array('class' => 'form-control')),
            ),
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
