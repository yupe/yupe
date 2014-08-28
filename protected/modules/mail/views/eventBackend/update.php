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
$this->breadcrumbs = array(
    Yii::t('MailModule.mail', 'Mail events') => array('index'),
    $model->name                             => array('view', 'id' => $model->id),
    Yii::t('MailModule.mail', 'Edit'),
);
$this->pageTitle = Yii::t('MailModule.mail', 'Edit mail event');
$this->menu = array(
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
    array('label' => Yii::t('MailModule.mail', 'Event') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon'  => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('MailModule.mail', 'Edit event'),
        'url'   => array(
            '/mail/eventBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon'  => 'glyphicon glyphicon-eye-open',
        'label' => Yii::t('MailModule.mail', 'View mail event'),
        'url'   => array(
            '/mail/eventBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'glyphicon glyphicon-trash',
        'label'       => Yii::t('MailModule.mail', 'Remove event'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('/mail/eventBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('MailModule.mail', 'Do you really want to remove?'),
            'csrf'    => true,
        )
    ),
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
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Edit mail message'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
