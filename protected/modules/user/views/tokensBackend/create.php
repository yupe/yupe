<?php
$this->breadcrumbs = [
    Yii::t('UserModule.user', 'Users')  => ['/user/userBackend/index'],
    Yii::t('UserModule.user', 'Tokens') => ['/user/tokensBackend/index'],
    Yii::t('UserModule.user', 'Create token'),
];

$this->pageTitle = Yii::t('UserModule.user', 'Create token');

$this->menu = [
    [
        'label' => Yii::t('UserModule.user', 'Users'),
        'items' => [
            [
                'icon'  => 'list-alt',
                'label' => Yii::t('UserModule.user', 'Manage users'),
                'url'   => ['/user/userBackend/index']
            ],
            [
                'icon'  => 'plus-sign',
                'label' => Yii::t('UserModule.user', 'Create user'),
                'url'   => ['/user/userBackend/create']
            ],
        ]
    ],
    [
        'label' => Yii::t('UserModule.user', 'Tokens'),
        'items' => [
            [
                'icon'  => 'list-alt',
                'label' => Yii::t('UserModule.user', 'Token list'),
                'url'   => ['/user/tokensBackend/index']
            ],
            [
                'icon'  => 'plus-sign',
                'label' => Yii::t('UserModule.user', 'Create token'),
                'url'   => ['/user/tokensBackend/create']
            ],
        ]
    ],
]; ?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Tokens'); ?>
        <small><?php echo Yii::t('UserModule.user', 'create token'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
