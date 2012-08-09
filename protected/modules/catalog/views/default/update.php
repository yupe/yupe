<?php
$this->breadcrumbs=array(
    $this->module->getCategory() => array(''),
	'Товары'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('yupe','Редактирование'),
);
$this->pageTitle ="товары - "."Yii::t('yupe','редактирование')";
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление товарами'),'url'=>array('/catalog/default/index')),
    array('icon'=> 'file', 'label' =>  Yii::t('yupe','Добавить товар'),'url'=>array('/catalog/default/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('yupe','Редактирование '). 'товара<br /><span class="label" style="font-size: 80%; margin-left:20px;">'.mb_substr($model->name,0,32)."</span>",'url'=>array('catalog/default/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('yupe','Просмотреть '). 'товар','url'=>array('/catalog/default/view','id'=>$model->id)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','Редактирование');?> <?php echo Yii::t('yupe','товара');?><br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>