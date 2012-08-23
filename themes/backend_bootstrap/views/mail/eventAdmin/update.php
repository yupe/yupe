<?php
$this->breadcrumbs=array(
    $this->module->getCategory() => array('admin'),
	'Почтовые события'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('yupe','Редактирование'),
);
$this->pageTitle ="почтовые события - "."Yii::t('yupe','редактирование')";
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление почтовыми событиями'),'url'=>array('/mail/eventAdmin/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('yupe','Добавить почтовое событие'),'url'=>array('/mail/eventAdmin/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('yupe','Редактирование '). 'почтового события \''.mb_substr($model->name,0,32)." '",'url'=>array('mail/eventAdmin/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('yupe','Просмотреть '). 'почтовое событие','url'=>array('/mail/eventAdmin/view','id'=>$model->id)),
    array('icon'=> 'file', 'label' =>  Yii::t('yupe','Добавить почтовый шаблон'),'url'=>array('/mail/templateAdmin/create/','eid' => $model->id)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','Редактирование');?> <?php echo Yii::t('yupe','почтовом событии');?><br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>