<?php
$this->breadcrumbs=array(
    $this->module->getCategory() => array('admin'),
	'Почтовые шаблоны'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('yupe','Редактирование'),
);
$this->pageTitle ="почтовые шаблоны - "."Yii::t('yupe','редактирование')";
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление почтовыми шаблонами'),'url'=>array('/mail/templateAdmin/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('yupe','Добавить почтовый шаблон'),'url'=>array('/mail/templateAdmin/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('yupe','Редактирование '). 'почтового шаблона<br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model->name,0,32)."</span>",'url'=>array('mail/templateAdmin/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('yupe','Просмотреть '). 'почтовый шаблон','url'=>array('/mail/templateAdmin/view','id'=>$model->id)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','Редактирование');?> <?php echo Yii::t('yupe','почтовом шаблоне');?><br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>