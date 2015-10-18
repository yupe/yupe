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
        <?php echo Yii::t('CallbackModule.callback', 'Callback'); ?>
        <small><?php echo Yii::t('CallbackModule.callback', 'manage'); ?></small>
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
            [
                'name' => 'name',
                'filter' => false
            ],
            [
                'name' => 'phone',
                'filter' => false
            ],
            [
                'name' => 'time',
                'filter' => false
            ],
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
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
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
                'class' => 'yupe\widgets\CustomButtonColumn',
                'template' => '{delete}',
            ],
        ],
    ]
); ?>
