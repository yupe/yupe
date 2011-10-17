<?php
$this->breadcrumbs = array(
    $this->getModule('vote')->getCategory() => array(''),
    Yii::t('vote', 'Голосование') => array('admin'),
    Yii::t('vote', 'Редактирование'),
);

$this->menu = array(
    array('label' => Yii::t('vote', 'Список голосов'), 'url' => array('index')),
    array('label' => Yii::t('vote', 'Добавить голос'), 'url' => array('create')),
    array('label' => Yii::t('vote', 'Просмотреть голос'), 'url' => array('view', 'id' => $model->id)),
    array('label' => Yii::t('vote', 'Управление голосами'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('vote', 'Редактирование голоса');?>
    № <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>