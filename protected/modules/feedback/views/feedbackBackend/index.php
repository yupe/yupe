<?php
$this->breadcrumbs = array(
    Yii::t('FeedbackModule.feedback', 'Messages ') => array('/feedback/feedbackBackend/index'),
    Yii::t('FeedbackModule.feedback', 'Management'),
);

$this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - manage');

$this->menu = array(
    array(
        'icon'  => 'glyphicon glyphicon-list-alt',
        'label' => Yii::t('FeedbackModule.feedback', 'Messages management'),
        'url'   => array('/feedback/feedbackBackend/index')
    ),
    array(
        'icon'  => 'glyphicon glyphicon-plus-sign',
        'label' => Yii::t('FeedbackModule.feedback', 'Create message '),
        'url'   => array('/feedback/feedbackBackend/create')
    ),
);
$assets = Yii::app()->getAssetManager()->publish(
    Yii::getPathOfAlias('feedback.views.assets')
);
Yii::app()->getClientScript()->registerScriptFile($assets . '/js/feedback.js');
Yii::app()->getClientScript()->registerCssFile($assets . '/css/feedback.css');
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('FeedbackModule.feedback', 'Messages '); ?>
        <small><?php echo Yii::t('FeedbackModule.feedback', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="glyphicon glyphicon-search">&nbsp;</i>
        <?php echo Yii::t('FeedbackModule.feedback', 'Find messages'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
                $('.search-form form').submit(function () {
                    $.fn.yiiGridView.update('feed-back-list', {
                        data: $(this).serialize()
                    });

                    return false;
                });
                $('.search-form form [type=reset]').click(function () {
                    $.fn.yiiGridView.update('feed-back-list', {
                        data: $(this).serialize()
                    });

                    return false;
                });
            "
    );
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<p>
    <?php echo Yii::t('FeedbackModule.feedback', 'This section represent feedback management'); ?>
</p>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'feed-back-list',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/feedback/feedbackBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns'      => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width:20px'),
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->id, array("/feedback/feedbackBackend/update", "id" => $data->id))'
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'theme',
                'editable' => array(
                    'url'    => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'theme', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => array(
                    'url'    => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'email',
                'editable' => array(
                    'url'    => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'email', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'source' => $model->getTypeList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'type',
                'type'     => 'raw',
                'value'    => '$data->getType()',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'type',
                        $model->getTypeList(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
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
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'source' => $model->getIsFaqList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'is_faq',
                'type'     => 'raw',
                'value'    => '$data->getIsFaq()',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'is_faq',
                        $model->getIsFaqList(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            'creation_date',
            'answer_date',
            array(
                'class'    => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{answer}{view}{update}{delete}',
                'buttons'  => array(
                    'answer' => array(
                        'label'   => false,
                        'url'     => 'Yii::app()->createUrl("/feedback/feedbackBackend/answer", array("id" => $data->id))',
                        'options' => array(
                            'class' => 'glyphicon glyphicon-envelope',
                            'title' => Yii::t('FeedbackModule.feedback', 'Messages - answer'),
                        ),
                    )
                )
            ),
        )
    )
); ?>
