<?php
/**
 * Отображение для update:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->breadcrumbs = [
    Yii::t('MailModule.mail', 'Mail events') => ['index'],
    $model->name                             => ['view', 'id' => $model->id],
    Yii::t('MailModule.mail', 'Edit'),
];
$this->pageTitle = Yii::t('MailModule.mail', 'Edit mail event');
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
    ['label' => Yii::t('MailModule.mail', 'Event') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('MailModule.mail', 'Edit event'),
        'url'   => [
            '/mail/eventBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('MailModule.mail', 'View mail event'),
        'url'   => [
            '/mail/eventBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
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
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('MailModule.mail', 'Templates list'),
        'url'   => ['/mail/templateBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('MailModule.mail', 'Create template'),
        'url'   => ['/mail/templateBackend/create/', 'eid' => $model->id]
    ],
];
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Edit mail event'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
