<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array('admin'),
    Yii::t('queue','Задания') => array('index'),
    Yii::t('queue','Добавление'),
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('queue','Список заданий'), 'url' => array('/queue/default/index')),
    array('icon' => 'plus-sign white', 'label' =>  Yii::t('queue','Добавление задания'), 'url' => array('/queue/default/create')),
);
?>
<div class="page-header">
    <h1><?php  echo Yii::t('queue','Задания');?>
        <small><?php echo Yii::t('queue','добавление');?></small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', array('model'=> $model)); ?>