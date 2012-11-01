<?php
$this->breadcrumbs = array(
    $this->getModule('vote')->getCategory() => array(''),
    Yii::t('vote', 'Голосование') => array('admin'),
    Yii::t('vote', 'Добавление'),
);

$this->menu = array(
    array('label' => Yii::t('vote', 'Список голосов'), 'url' => array('index')),
    array('label' => Yii::t('vote', 'Управление голосами'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('vote', 'Добавление голоса');?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>