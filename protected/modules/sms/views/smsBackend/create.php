<?php
/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
$this->breadcrumbs=[
    Yii::t('SmsModule.sms', 'Sms')=>['index'],
    Yii::t('SmsModule.sms', 'Sms send'),
];
$this->pageTitle = Yii::t('SmsModule.sms', 'Sms send');

$this->menu=[
    ['icon'=> 'fa fa-fw fa-list', 'label' => Yii::t('SmsModule.sms', 'Sms list'),'url'=>array('/sms/smsBackend/index')],
    ['icon'=> 'fa fa-fw fa-pencil', 'label' =>  Yii::t('SmsModule.sms', 'Sms send'),'url'=>array('/sms/smsBackend/create')],
    ['icon'=> 'fa fa-fw fa-gears', 'label' =>  Yii::t('SmsModule.sms', 'Settings'),'url'=>array('/backend/modulesettings?module=sms')],
];

?>
<div class="page-header">
    <h1><?php echo Yii::t('SmsModule.sms', 'Sms');?> <small><?php echo Yii::t('SmsModule.sms', 'sending');?></small>
    </h1>
</div>

<br/>

<?php echo  $this->renderPartial('_form', ['model'=>$model]); ?>

