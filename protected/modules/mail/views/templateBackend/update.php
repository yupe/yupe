<?php
$this->breadcrumbs = [
    Yii::t('MailModule.mail', 'Mail templates') => ['index'],
    Yii::t('MailModule.mail', 'Mail events')    => ['/mail/eventBackend/index'],
    $model->name                                => ['view', 'id' => $model->id],
    Yii::t('MailModule.mail', 'Edit'),
];
$this->pageTitle = Yii::t('MailModule.mail', 'Edit mail template');
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
        'url'   => ['/mail/templateBackend/create/', 'eid' => $model->id]
    ],
    ['label' => Yii::t('MailModule.mail', 'Template') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('MailModule.mail', 'Edit template'),
        'url'   => [
            '/mail/templateBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('MailModule.mail', 'View template'),
        'url'   => [
            '/mail/templateBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('MailModule.mail', 'Remove template'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/mail/templateBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('MailModule.mail', 'Do you really want to remove?'),
            'csrf'    => true,
        ]
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
    <h1><?=  Yii::t('MailModule.mail', 'Updating template'); ?><br/>
        <small>&laquo;<?=  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?=  $this->renderPartial('_form', ['model' => $model]); ?>
