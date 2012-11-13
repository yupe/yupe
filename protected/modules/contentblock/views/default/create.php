<?php
$this->breadcrumbs = array(
    $this->getModule('contentblock')->getCategory() => array(''),
    Yii::t('contentblock', 'Блоки контента') => array('admin'),
    Yii::t('contentblock', 'Добавление нового блока'),
);

$this->menu = array(
    array('icon' => 'plus-sign','label' => Yii::t('contentblock', 'Добавить новый блок'), 'url' => array('/contentblock/default/create')),
    array('icon' => 'list-alt','label' => Yii::t('contentblock', 'Управление блоками контента'), 'url' => array('/contentblock/default/admin')),
);
?>

<h1><?php echo Yii::t('contentblock', 'Добавление блока контента'); ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>