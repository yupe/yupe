<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array(''),
    Yii::t('menu', 'Меню') => array('/menu/menu/index'),
    Yii::t('menu', 'Пункты меню') => array('/menu/menuitem/index'),
    Yii::t('menu', 'Добавление'),
);

$this->menu = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'plus-sign', 'label' => Yii::t('menu', 'Добавить меню'), 'url' => array('/menu/menu/create')),
    array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление меню'), 'url' => array('/menu/menu/index')),
    array('label' => Yii::t('menu', 'Пункты меню')),
    array('icon' => 'plus-sign', 'label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('/menu/menuitem/create')),
    array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('/menu/menuitem/index')),
);
?>

<h1><?php echo Yii::t('menu', 'Добавление нового пункта меню'); ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>