<?php

$this->breadcrumbs = [
    Yii::t('OrderModule.order', 'Clients') => ['/order/clientBackend/index'],
    Yii::t('OrderModule.order', 'Manage'),
];

$this->pageTitle = Yii::t('OrderModule.order', 'Clients - manage');

$this->menu = [
    [
        'label' => Yii::t('OrderModule.order', 'Clients'),
        'items' => [
            ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('OrderModule.order', 'Manage clients'), 'url' => ['/order/clientBackend/index']],
            ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('OrderModule.order', 'Create client'), 'url' => ['/user/userBackend/create']],
        ]
    ]
];
?>

<div>
    <h1>
        <?= Yii::t('OrderModule.order', 'Client'); ?><br/>
        <small>&laquo;<?= $model->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data' => $model,
        'attributes' => [
            [
                'name' => 'full_name',
                'value' => $model->getFullName(),
            ],
            'nick_name',
            'email',
            'location',
            'site',
            'birth_date',
            'phone',
            'about',
            [
                'name' => 'gender',
                'value' => $model->getGender(),
            ],
            [
                'name' => 'status',
                'value' => $model->getStatus(),
            ],
            [
                'name' => 'access_level',
                'value' => $model->getAccessLevel(),
            ],
            [
                'name' => 'email_confirm',
                'value' => $model->getEmailConfirmStatus(),
            ],
            'visit_time',
            'create_time',
            'update_time'
        ],
    ]
); ?>