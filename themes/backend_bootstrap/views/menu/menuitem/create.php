<?php
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню') => array('menu/admin'),
    Yii::t('menu', 'Пункты меню') => array('admin'),
    Yii::t('menu', 'Добавление'),
);

$this->menu = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('label' => Yii::t('menu', 'Добавить меню'), 'url' => array('menu/create')),
    array('label' => Yii::t('menu', 'Список меню'), 'url' => array('menu/index')),
    array('label' => Yii::t('menu', 'Управление меню'), 'url' => array('menu/admin')),

    array('label' => Yii::t('menu', 'Пункты меню')),
    array('label' => Yii::t('menu', 'Cписок пунктов меню'), 'url' => array('index')),
    array('label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('menu', 'Добавление нового пункта меню'); ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>