<?php
$this->breadcrumbs = array(
    Yii::t('MailModule.mail', 'Mail events')    => array('/mail/eventBackend/index'),
    Yii::t('MailModule.mail', 'Mail templates') => array('index'),
    $model->name,
);
$this->pageTitle = Yii::t('MailModule.mail', 'View mail template');
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
        'url'   => array('/mail/templateBackend/create/', 'eid' => $model->id)
    ),
    array('label' => Yii::t('MailModule.mail', 'Template') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('MailModule.mail', 'Edit template'),
        'url'   => array(
            '/mail/templateBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('MailModule.mail', 'View mail template'),
        'url'   => array(
            '/mail/templateBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'fa fa-fw fa-trash-o',
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
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('MailModule.mail', 'Messages list'),
        'url'   => array('/mail/eventBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('MailModule.mail', 'Create event'),
        'url'   => array('/mail/eventBackend/create')
    ),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'View mail template'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'code',
            array(
                'name'  => 'event_id',
                'value' => $model->event->name,
            ),
            'name',
            'description',
            'from',
            'to',
            'theme',
            array(
                'name' => 'body',
                'type' => 'raw'
            ),
            array(
                'name'  => 'status',
                'value' => $model->getStatus(),
            ),
        ),
    )
); ?>
