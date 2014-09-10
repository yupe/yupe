<?php
$this->breadcrumbs = array(
    Yii::t('MailModule.mail', 'Mail templates') => array('index'),
    Yii::t('MailModule.mail', 'Mail events')    => array('/mail/eventBackend/index'),
    $model->name                                => array('view', 'id' => $model->id),
    Yii::t('MailModule.mail', 'Edit'),
);
$this->pageTitle = Yii::t('MailModule.mail', 'Edit mail template');
$this->menu = array(
    array('label' => Yii::t('MailModule.mail', 'Mail templates')),
    array(
        'icon'  => 'glyphicon glyphicon-list-alt',
        'label' => Yii::t('MailModule.mail', 'Templates list'),
        'url'   => array('/mail/templateBackend/index')
    ),
    array(
        'icon'  => 'glyphicon glyphicon-plus-sign',
        'label' => Yii::t('MailModule.mail', 'Create template'),
        'url'   => array('/mail/templateBackend/create/', 'eid' => $model->id)
    ),
    array('label' => Yii::t('MailModule.mail', 'Template') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon'  => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('MailModule.mail', 'Edit template'),
        'url'   => array(
            '/mail/templateBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon'  => 'glyphicon glyphicon-eye-open',
        'label' => Yii::t('MailModule.mail', 'View mail template'),
        'url'   => array(
            '/mail/templateBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'glyphicon glyphicon-trash',
        'label'       => Yii::t('MailModule.mail', 'Remove template'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('/mail/templateBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('MailModule.mail', 'Do you really want to remove?'),
            'csrf'    => true,
        )
    ),
    array('label' => Yii::t('MailModule.mail', 'Mail events')),
    array(
        'icon'  => 'glyphicon glyphicon-list-alt',
        'label' => Yii::t('MailModule.mail', 'Messages list'),
        'url'   => array('/mail/eventBackend/index')
    ),
    array(
        'icon'  => 'glyphicon glyphicon-plus-sign',
        'label' => Yii::t('MailModule.mail', 'Create event'),
        'url'   => array('/mail/eventBackend/create')
    ),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Edit template'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
