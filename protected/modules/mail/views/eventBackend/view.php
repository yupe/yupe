<?php
/**
 * Отображение для view:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->breadcrumbs = [
    Yii::t('MailModule.mail', 'Mail events') => ['index'],
    $model->name,
];
$this->pageTitle = Yii::t('MailModule.mail', 'View mail event');
$this->menu = [
    ['label' => Yii::t('MailModule.mail', 'Mail events')],
    [
        'icon'  => 'list-alt',
        'label' => Yii::t('MailModule.mail', 'Messages list'),
        'url'   => ['/mail/eventBackend/index']
    ],
    [
        'icon'  => 'plus-sign',
        'label' => Yii::t('MailModule.mail', 'Create event'),
        'url'   => ['/mail/eventBackend/create']
    ],
    ['label' => Yii::t('MailModule.mail', 'Event') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon'  => 'pencil',
        'label' => Yii::t('MailModule.mail', 'Edit event'),
        'url'   => [
            '/mail/eventBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'eye-open',
        'label' => Yii::t('MailModule.mail', 'View mail event'),
        'url'   => [
            '/mail/eventBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'trash',
        'label'       => Yii::t('MailModule.mail', 'Remove event'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/mail/eventBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('MailModule.mail', 'Do you really want to remove?'),
            'csrf'    => true,
        ]
    ],
    ['label' => Yii::t('MailModule.mail', 'Mail templates')],
    [
        'icon'  => 'list-alt',
        'label' => Yii::t('MailModule.mail', 'Templates list'),
        'url'   => ['/mail/templateBackend/index']
    ],
    [
        'icon'  => 'plus-sign',
        'label' => Yii::t('MailModule.mail', 'Create template'),
        'url'   => ['/mail/templateBackend/create/', 'eid' => $model->id]
    ],
];
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Viewing mail event'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            'code',
            'name',
            'description',
        ],
    ]
); ?>
