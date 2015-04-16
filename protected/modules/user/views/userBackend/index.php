<?php

/**
 * @var $model User
 * @var $this UserBackendController
 */

$this->breadcrumbs = [
    Yii::t('UserModule.user', 'Users') => ['/user/userBackend/index'],
    Yii::t('UserModule.user', 'Management'),
];

$this->pageTitle = Yii::t('UserModule.user', 'Users - management');

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
        <?php echo Yii::t('UserModule.user', 'Users'); ?>
        <small><?php echo Yii::t('UserModule.user', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('UserModule.user', 'Find users'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        event.preventDefault();

        $.fn.yiiGridView.update('user-grid', {
            data: $(this).serialize()
        });
    });

    $(document).on('click', '.verify-email', function () {
        var link = $(this);

        event.preventDefault();

        $.post(link.attr('href'), actionToken.token)
            .done(function (response) {
                bootbox.alert(response.data);
            });
    });
"
    );
    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => 'user-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
            [
                'name'  => 'nick_name',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->nick_name, array("/user/userBackend/update", "id" => $data->id))',
            ],
            [
                'name'  => 'email',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->email, "mailto:" . $data->email)',
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/user/userBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                        'UserModule.user',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('access_level'))]
                    ),
                    'source' => $model->getAccessLevelsList(),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'name'     => 'access_level',
                'type'     => 'raw',
                'value'    => '$data->getAccessLevel()',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'access_level',
                    $model->getAccessLevelsList(),
                    ['class' => 'form-control', 'empty' => '']
                ),
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/user/userBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    User::STATUS_ACTIVE     => ['class' => 'label-success'],
                    User::STATUS_BLOCK      => ['class' => 'label-danger'],
                    User::STATUS_NOT_ACTIVE => ['class' => 'label-warning'],
                ],
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/user/userBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                        'UserModule.user',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('email_confirm'))]
                    ),
                    'source' => $model->getEmailConfirmStatusList(),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'name'     => 'email_confirm',
                'type'     => 'raw',
                'value'    => '$data->getEmailConfirmStatus()',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'email_confirm',
                    $model->getEmailConfirmStatusList(),
                    ['class' => 'form-control', 'empty' => '']
                ),
            ],
            [
                'name'   => 'create_time',
                'filter' => false
            ],
            [
                'name'   => 'visit_time',
                'filter' => false
            ],
            [
                'header'      => Yii::t('UserModule.user', 'Management'),
                'class'       => 'yupe\widgets\CustomButtonColumn',
                'template'    => '{view}{update}{password}{sendactivation}{delete}',
                'buttons'     => [
                    'password'       => [
                        'icon'  => 'fa fa-fw fa-lock',
                        'label' => Yii::t('UserModule.user', 'Change password'),
                        'url'   => 'array("/user/userBackend/changepassword", "id" => $data->id)',
                    ],
                    'sendactivation' => [
                        'label'   => Yii::t('UserModule.user', 'Send activation confirm'),
                        'url'     => 'array("/user/userBackend/sendactivation", "id" => $data->id)',
                        'icon'    => 'fa fa-fw fa-repeat',
                        'visible' => '$data->status != User::STATUS_ACTIVE',
                        'options' => [
                            'class' => 'user sendactivation'
                        ]
                    ],
                ],
            ],
        ],
    ]
); ?>
