<?php
/**
 * Отображение для view:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs=array(
    $this->module->getCategory() => array('index'),
    Yii::t('MailModule.mail', 'Почтовые события')=>array('index'),
    $model->name,
);
$this-> pageTitle = Yii::t('MailModule.mail', 'Просмотр почтового события');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail', 'Список событий'),'url'=>array('/mail/eventAdmin/index')),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('MailModule.mail', 'Добавление события'),'url'=>array('/mail/eventAdmin/create')),
    array('icon'=>'pencil', 'encodeLabel'=> false, 'label' => Yii::t('MailModule.mail', 'Редактирование события'),'url'=>array('mail/eventAdmin/update', 'id'=>$model->id)),
    array('icon'=>'eye-open', 'encodeLabel'=> false, 'label' => Yii::t('MailModule.mail', 'Просмотреть событие'),'url'=>array('/mail/eventAdmin/view', 'id'=>$model->id)),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('MailModule.mail', 'Добавить  шаблон'),'url'=>array('/mail/templateAdmin/create/', 'eid' => $model->id)),
    array('icon'=>'remove', 'label' =>  Yii::t('MailModule.mail', 'Удалить  событие'),'url'=>'#', 'linkOptions'=>array('submit'=>array('delete', 'id'=>$model->id),'confirm'=> Yii::t('MailModule.mail', 'Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Просмотр почтового события');?><br /><small style='margin-left:-10px;'>&laquo;<?php echo  $model->name; ?>&raquo;</small></h1>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'id',
            'code',
            'name',
            'description',
        ),
    )
); ?>