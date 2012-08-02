<?php
$this->breadcrumbs = array(
    Yii::t('feedback', 'Сообщения с сайта') => array('admin'),
    Yii::t('feedback', 'Добавление сообщения'),
);

$this->menu = array(
    array('label' => Yii::t('feedback', 'Управление сообщениями'), 'url' => array('/feedback/default/admin')),
    array('label' => Yii::t('feedback', 'Добавить сообщение'), 'url' => array('/feedback/default/create')),
);
?>

<h1><?php echo Yii::t('feedback', 'Добавление сообщения');?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>