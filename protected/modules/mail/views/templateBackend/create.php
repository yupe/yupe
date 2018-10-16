<?php
$this->breadcrumbs = [
    Yii::t('MailModule.mail', 'Mail events')    => ['/mail/eventBackend/index'],
    Yii::t('MailModule.mail', 'Mail templates') => ['index'],
    Yii::t('MailModule.mail', 'Create'),
];

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
];
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Mail templates'); ?>
        <small><?php echo Yii::t('MailModule.mail', 'adding'); ?></small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
