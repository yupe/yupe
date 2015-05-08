<?php
$this->breadcrumbs = [
    Yii::t('UserModule.user', 'Users')  => ['/user/userBackend/index'],
    Yii::t('UserModule.user', 'Tokens') => ['/user/tokensBackend/index'],
    Yii::t('UserModule.user', 'Token management'),
];

$this->pageTitle = Yii::t('UserModule.user', 'Token management');

$this->menu = [
    [
        'label' => Yii::t('UserModule.user', 'Users'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('UserModule.user', 'Manage users'),
                'url'   => ['/user/userBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('UserModule.user', 'Create user'),
                'url'   => ['/user/userBackend/create']
            ],
        ]
    ],
    [
        'label' => Yii::t('UserModule.user', 'Tokens'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('UserModule.user', 'Token list'),
                'url'   => ['/user/tokensBackend/index']
            ],
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Tokens'); ?>
        <small><?php echo Yii::t('UserModule.user', 'management'); ?></small>
    </h1>
</div>

<?php $this->renderPartial('_search', ['model' => $model]); ?>

<?php
$data = json_encode(
    [
        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken,
    ]
);
$confirmMessage = CJavaScript::encode(
    Yii::t('UserModule.user', 'Are you sure you want to compromise this token?')
);
$compromiseJS = <<<SCRIPT
    function (event) {
        event.preventDefault();

        if(!confirm($confirmMessage)) return false;

        jQuery('#user-tokens-grid').yiiGridView('update', {
            type: 'POST',
            url: jQuery(this).attr('href'),
            data: $data,
        });
    }
SCRIPT;
?>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => 'user-tokens-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'actionsButtons' => false,
        'columns'      => [
            [
                'name'   => 'user_id',
                'value'  => '$data->getFullName()',
                'filter' => $model->getUserList()
            ],
            [
                'name'        => 'type',
                'value'       => '$data->getType()',
                'filter'      => $model->getTypeList(),
                'htmlOptions' => [
                    'style' => implode(
                        ' ',
                        [
                            'white-space: nowrap;',
                            'max-width: 150px;',
                            'text-overflow: ellipsis;',
                            'overflow: hidden;',
                        ]
                    ),
                ],
            ],
            [
                'name'        => 'token',
                'value'       => '$data->token',
                'htmlOptions' => [
                    'style' => implode(
                        ' ',
                        [
                            'white-space: nowrap;',
                            'max-width: 150px;',
                            'text-overflow: ellipsis;',
                            'overflow: hidden;',
                        ]
                    ),
                ],
            ],
            [
                'name'        => 'create_time',
                'value'       => '$data->beautifyDate($data->create_time)',
                'filter'      => false,
                'htmlOptions' => [
                    'style' => 'width: 120px;'
                ]
            ],
            [
                'name'        => 'update_time',
                'filter'      => false,
                'value'       => '$data->beautifyDate($data->update_time)',
                'htmlOptions' => [
                    'style' => 'width: 120px;'
                ]
            ],
            [
                'name'        => 'expire_time',
                'filter'      => false,
                'value'       => '$data->beautifyDate($data->expire_time)',
                'htmlOptions' => [
                    'style' => 'width: 120px;'
                ]
            ],
            [
                'name'        => 'status',
                'value'       => 'yupe\helpers\Html::label($data->status, $data->getStatus(), [UserToken::STATUS_NEW => yupe\helpers\Html::SUCCESS, UserToken::STATUS_ACTIVATE => yupe\helpers\Html::INFO, UserToken::STATUS_FAIL => yupe\helpers\Html::DANGER])',
                'type'        => 'raw',
                'filter'      => $model->getStatusList(),
                'htmlOptions' => [
                    'style' => implode(
                        ' ',
                        [
                            'white-space: nowrap;',
                            'max-width: 100px;',
                            'text-overflow: ellipsis;',
                            'overflow: hidden;',
                        ]
                    ),
                ],
            ],
            [
                'header'      => Yii::t('UserModule.user', 'Management'),
                'class'       => 'yupe\widgets\CustomButtonColumn',
                'template'    => '{fail} &emsp; {view} {update} {delete}',
                'buttons'     => [
                    'fail' => [
                        'icon'    => 'fa fa-fw fa-times',
                        'label'   => Yii::t('UserModule.user', 'Compromise'),
                        'click'   => $compromiseJS,
                        'visible' => '$data->getIsCompromised() === false',
                        'url'     => 'array("/user/tokensBackend/compromise", "id" => $data->id)',
                    ],
                ],
                'htmlOptions' => [
                    'class' => 'button-column'
                ]
            ],
        ],
    ]
); ?>
