<?php
$this->breadcrumbs = array(
    $this->getModule('comment')->getCategory() => array(''),
    Yii::t('comment', 'Комментарии') => array('admin'),
    Yii::t('comment', 'Добавление'),
);

$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('comment','Список комментариев'),'url'=>array('/comment/default/admin')),
    array('icon'=> 'plus-sign', 'label' => Yii::t('comment','Добавить комментарий'),'url'=>array('/comment/default/create')),
);
?>

<h1><?php echo Yii::t('comment', 'Комментарии'); ?> <small><?php echo Yii::t('comment','добавление');?></small></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>