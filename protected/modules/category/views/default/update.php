<?php
$this->breadcrumbs=array(
	'категории'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('yupe','Редактирование'),
);
$this->pageTitle ="категории - "."Yii::t('yupe','редактирование')";
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление категориями'),'url'=>array('/category/default/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('yupe','Добавление категории'),'url'=>array('/category/default/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('yupe','Редактирование '). 'категории<br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model->name,0,32)."</span>",'url'=>array('category/default/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('yupe','Просмотреть '). 'категорию','url'=>array('/category/default/view','id'=>$model->id)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','Редактирование');?> <?php echo Yii::t('yupe','категории');?><br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>