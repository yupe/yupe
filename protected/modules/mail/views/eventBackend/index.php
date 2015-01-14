<?php
/**
 * Отображение для index:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->breadcrumbs = [
    Yii::t('MailModule.mail', 'Mail events') => ['index'],
    Yii::t('MailModule.mail', 'List'),
];
$this->pageTitle = Yii::t('MailModule.mail', 'Events list');

$this->menu = [
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
];

Yii::app()->clientScript->registerScript(
    'search',
    "
    $('.search-button').click(function () {
    	$('.search-form').toggle();
    	return false;
    });
    $('.search-form').submit(function () {
    	$.fn.yiiGridView.update('mail-event-grid', {
    		data: $(this).serialize()
    	});
    	return false;
    });"
);

?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Mail events'); ?>
        <small><?php echo Yii::t('MailModule.mail', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('MailModule.mail', 'Find mail messages'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form').submit(function () {
        $.fn.yiiGridView.update('mail-event-grid', {
            data: $(this).serialize()
        });

        return false;
    });"
    );

    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'             => 'mail-event-grid',
        'dataProvider'   => $model->search(),
        'filter'         => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/mail/eventBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns'        => [
            [
                'name'        => 'id',
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->id, array("/mail/eventBackend/update", "id" => $data->id))',
                'htmlOptions' => ['style' => 'width:20px'],
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'code',
                'editable' => [
                    'url'    => $this->createUrl('/mail/eventBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'code', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => [
                    'url'    => $this->createUrl('/mail/eventBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'name', ['class' => 'form-control']),
            ],
            [
                'class'       => 'bootstrap.widgets.TbEditableColumn',
                'name'        => 'description',
                'value'       => '$data->shortDescription;',
                'editable'    => [
                    'url'    => $this->createUrl('/mail/eventBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'textarea',
                    'title'  => Yii::t(
                        'MailModule.mail',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('description'))]
                    ),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'htmlOptions' => [
                    'style' => 'width: 20%;'
                ],
                'filter'      => CHtml::activeTextField($model, 'description', ['class' => 'form-control']),
            ],
            [
                'header' => Yii::t('MailModule.mail', 'Templates'),
                'type'   => 'raw',
                'value'  => 'CHtml::link(count($data->templates), array("/mail/templateBackend/index/", "event" => $data->id))',
            ],
            [
                'class'    => 'yupe\widgets\CustomButtonColumn',
                'template' => '{view}{update}{delete}{add}',
                'buttons'  => [
                    'add' => [
                        'icon'  => 'fa fa-fw fa-plus-square',
                        'label' => Yii::t('MailModule.mail', 'Create mail template'),
                        'url'   => 'Yii::app()->createUrl("/mail/templateBackend/create/", array("eid" => $data->id))',
                    ]
                ]
            ],
        ],
    ]
); ?>
