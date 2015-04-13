<?php
$this->breadcrumbs = [
    Yii::t('MailModule.mail', 'Mail events')    => ['/mail/eventBackend/index'],
    Yii::t('MailModule.mail', 'Mail templates') => ['index'],
    Yii::t('MailModule.mail', 'Management'),
];
$this->pageTitle = Yii::t('MailModule.mail', 'Mail templates list');

$this->menu = [
    ['label' => Yii::t('MailModule.mail', 'Mail templates')],
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('MailModule.mail', 'Templates list'),
        'url'   => ['/mail/templateBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('MailModule.mail', 'Create template'),
        'url'   => ['/mail/templateBackend/create']
    ],
    ['label' => Yii::t('MailModule.mail', 'Mail events')],
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('MailModule.mail', 'Messages list'),
        'url'   => ['/mail/eventBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('MailModule.mail', 'Create event'),
        'url'   => ['/mail/eventBackend/create']
    ],
];
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Mail templates'); ?>
        <small><?php echo Yii::t('MailModule.mail', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('MailModule.mail', 'Find mail templates'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out">
    <?php Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form').submit(function () {
        $.fn.yiiGridView.update('mail-template-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );

    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'             => 'mail-template-grid',
        'dataProvider'   => $model->search(),
        'filter'         => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/mail/templateBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns'        => [
            [
                'name'        => 'id',
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->id, array("/mail/templateBackend/update", "id" => $data->id))',
                'htmlOptions' => ['style' => 'width:20px'],
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => [
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'name', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'code',
                'editable' => [
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'code', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                        'MailModule.mail',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('event_id'))]
                    ),
                    'source' => CHtml::listData(MailEvent::model()->findAll(), 'id', 'name'),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'name'     => 'event_id',
                'type'     => 'raw',
                'value'    => '$data->event->name',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'event_id',
                    CHtml::listData(MailEvent::model()->findAll(), 'id', 'name'),
                    ['class' => 'form-control', 'empty' => '']
                ),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'theme',
                'editable' => [
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'inline',
                    'type'   => 'text',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'theme', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'from',
                'editable' => [
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'from', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'to',
                'editable' => [
                    'url'    => $this->createUrl('/mail/templateBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'to', ['class' => 'form-control']),
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/mail/templateBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    MailTemplate::STATUS_ACTIVE     => ['class' => 'label-success'],
                    MailTemplate::STATUS_NOT_ACTIVE => ['class' => 'label-default'],
                ],
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
