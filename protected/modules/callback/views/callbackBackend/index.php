<?php
$this->breadcrumbs = [
    Yii::t('CallbackModule.callback', 'Callback') => ['/callback/callbackBackend/index'],
];

$this->pageTitle = Yii::t('CallbackModule.callback', 'Callback - manage');

$this->menu = [
    [
        'label' => Yii::t('CallbackModule.callback', 'Callback'),
        'items' => [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('CallbackModule.callback', 'Messages'),
                'url' => ['/callback/callbackBackend/index']
            ],
        ]
    ]
];
?>
<div class="page-header">
    <h1>
        <?=  Yii::t('CallbackModule.callback', 'Callback'); ?>
        <small><?=  Yii::t('CallbackModule.callback', 'manage'); ?></small>
    </h1>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'callback-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'actionsButtons' => false,
        'columns' => [
            'name',
            'phone',
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'type',
                'type' => 'raw',
                'url' => $this->createUrl('/callback/callbackBackend/inline'),
                'source' => Callback::model()->getTypeList(),
            ],
            'time',
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'comment',
                'editable' => [
                    'emptytext' => '---',
                    'url' => $this->createUrl('/callback/callbackBackend/inline'),
                    'mode' => 'popup',
                    'type' => 'textarea',
                    'inputclass' => 'input-large',
                    'title' => Yii::t('CallbackModule.callback', 'Comment'),
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter' => CHtml::activeTextField($model, 'comment', ['class' => 'form-control']),
            ],
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'status',
                'type' => 'raw',
                'url' => $this->createUrl('/callback/callbackBackend/inline'),
                'source' => Callback::model()->getStatusList(),
                'options' => Callback::model()->getStatusLabelList(),
            ],
            [
                'name' => 'create_time',
                'type' => 'html',
                'filter' => $this->widget('booster.widgets.TbDatePicker', [
                    'model' => $model,
                    'attribute' => 'create_time',
                    'options' => [
                        'format' => 'yyyy-mm-dd'
                    ],
                    'htmlOptions' => [
                        'class' => 'form-control',
                    ],
                ], true),
                'value' => function (Callback $data) {
                    return Yii::app()->getDateFormatter()->formatDateTime($data->create_time, 'medium');
                },
            ],
            [
                'name' => 'url',
                'type' => 'raw',
                'value' => function (Callback $data) {
                    return CHtml::link(mb_strimwidth($data->url, 0, 80, '&#8230;'), $data->url, [
                        'data-toggle' => 'tooltip',
                        'title' => $data->url,
                        'target' => '_blank',
                    ]);
                }
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'template' => '{delete}',
            ],
        ],
    ]
); ?>
