<?php
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню') => array('admin'),
    Yii::t('menu', 'Добавление'),
);

$this->menu = array(
    //@formatter:off
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'list-alt','label' => Yii::t('menu', 'Список меню'), 'url' => array('index')),
    array('icon' => 'list','label' => Yii::t('menu', 'Управление меню'), 'url' => array('admin')),
    array('icon' => 'file','label' => Yii::t('menu', 'Добавить меню'), 'url' => array('create')),

    array('label' => Yii::t('menu', 'Пункты меню')),
    array('icon' => 'file','label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('menuitem/create')),
    array('icon' => 'list-alt','label' => Yii::t('menu', 'Cписок пунктов меню'), 'url' => array('menuitem/index')),
    array('icon' => 'list','label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('menuitem/admin')),
    //@formatter:on
);
?>

<div class="page-header"><h1><?=$this->module->getName()?> <small><?php echo Yii::t('menu', 'добавление');?></small></h1></div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>