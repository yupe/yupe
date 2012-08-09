<?php
$this->breadcrumbs=array(
    'товары'=>array('index'),
    Yii::t('yupe','Добавление'),
);

$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('yupe','Управление товарами'),'url'=>array('/catalog/default/index')),
    array('icon'=> 'file', 'label' => Yii::t('yupe','Добавить товар'),'url'=>array('/catalog/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','товары'); ?> <small><?php echo Yii::t('yupe','добавление'); ?></small></h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>