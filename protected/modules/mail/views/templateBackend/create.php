<?php
$this->breadcrumbs = array(
    Yii::t('MailModule.mail', 'Mail events')    => array('/mail/eventBackend/index'),
    Yii::t('MailModule.mail', 'Mail templates') => array('index'),
    Yii::t('MailModule.mail', 'Create'),
);

$this->menu = array(
    array('label' => Yii::t('MailModule.mail', 'Mail templates')),
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('MailModule.mail', 'Templates list'),
        'url'   => array('/mail/templateBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('MailModule.mail', 'Create template'),
        'url'   => array('/mail/templateBackend/create')
    ),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Mail templates'); ?>
        <small><?php echo Yii::t('MailModule.mail', 'adding'); ?></small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
