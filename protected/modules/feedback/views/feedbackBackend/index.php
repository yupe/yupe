<?php
$this->breadcrumbs = [
    Yii::t('FeedbackModule.feedback', 'Messages ') => ['/feedback/feedbackBackend/index'],
    Yii::t('FeedbackModule.feedback', 'Management'),
];

$this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - manage');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('FeedbackModule.feedback', 'Messages management'),
        'url'   => ['/feedback/feedbackBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('FeedbackModule.feedback', 'Create message '),
        'url'   => ['/feedback/feedbackBackend/create']
    ],
];
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
        <i class="fa fa-search">&nbsp;</i>
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
    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'             => 'feed-back-list',
        'dataProvider'   => $model->search(),
        'filter'         => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/feedback/feedbackBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns'        => [
            [
                'name'        => 'id',
                'htmlOptions' => ['style' => 'width:20px'],
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->id, array("/feedback/feedbackBackend/update", "id" => $data->id))'
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'theme',
                'editable' => [
                    'url'    => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'theme', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => [
                    'url'    => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'name', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'email',
                'editable' => [
                    'url'    => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'email', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'source' => $model->getTypeList(),
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'name'     => 'type',
                'type'     => 'raw',
                'value'    => '$data->getType()',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'type',
                    $model->getTypeList(),
                    ['class' => 'form-control', 'empty' => '']
                ),
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/feedback/feedbackBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    FeedBack::STATUS_ANSWER_SENDED => ['class' => 'label-default'],
                    FeedBack::STATUS_FINISHED      => ['class' => 'label-success'],
                    FeedBack::STATUS_NEW           => ['class' => 'label-danger'],
                    FeedBack::STATUS_PROCESS       => ['class' => 'label-info'],
                ],
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/feedback/feedbackBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'source' => $model->getIsFaqList(),
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'name'     => 'is_faq',
                'type'     => 'raw',
                'value'    => '$data->getIsFaq()',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'is_faq',
                    $model->getIsFaqList(),
                    ['class' => 'form-control', 'empty' => '']
                ),
            ],
            'create_time',
            'answer_time',
            [
                'class'    => 'yupe\widgets\CustomButtonColumn',
                'template' => '{answer}{view}{update}{delete}',
                'buttons'  => [
                    'answer' => [
                        'icon'  => 'fa fa-fw fa-envelope',
                        'label' => Yii::t('FeedbackModule.feedback', 'Messages - answer'),
                        'url'   => 'Yii::app()->createUrl("/feedback/feedbackBackend/answer", array("id" => $data->id))',
                    ]
                ]
            ],
        ]
    ]
); ?>
