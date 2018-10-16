<?php
$this->breadcrumbs = [
    Yii::t('UserModule.user', 'Users')  => ['/user/userBackend/index'],
    Yii::t('UserModule.user', 'Tokens') => ['/user/tokensBackend/index'],
    Yii::t('UserModule.user', 'Update token') . ' #' . $model->id,
];

$this->pageTitle = Yii::t('UserModule.user', 'Update token') . ' #' . $model->id;

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
    [
        'label' => Yii::t('UserModule.user', 'Token') . ' #' . $model->id,
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-eye',
                'label' => Yii::t('UserModule.user', 'View'),
                'url'   => ['/user/tokensBackend/view', 'id' => $model->id]
            ],
            [
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('UserModule.user', 'Update'),
                'url'   => ['/user/tokensBackend/update', 'id' => $model->id]
            ],
            [
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('UserModule.user', 'Delete'),
                'url'         => [
                    '/user/tokensBackend/delete',
                    'id' => $model->id
                ],
                'linkOptions' => [
                    'ajax' => $this->getDeleteLink($model),
                ]
            ],
        ]
    ],
]; ?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Tokens'); ?>
        <small><?php echo Yii::t('UserModule.user', 'update token') . ' #' . $model->id; ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
