<?php
$this->breadcrumbs = array(
    $this->getModule('contentblock')->getCategory() => array(''),
    Yii::t('contentblock', 'Блоки контента') => array('admin'),
    Yii::t('contentblock', 'Добавление нового блока'),
);

$this->menu = array(
    array('label' => Yii::t('contentblock', 'Список блоков контента'), 'url' => array('index')),
    array('label' => Yii::t('contentblock', 'Управление блоками контента'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('contentblock', 'Добавление блока контента');?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>