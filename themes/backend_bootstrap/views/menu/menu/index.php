<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array(''),
    Yii::t('menu', 'Меню') => array('admin'),
    Yii::t('menu', 'Список меню'),
);

$this->menu = array(
    //@formatter:off
    array('label' => Yii::t('menu', 'Меню')),
    array('label' => Yii::t('menu', 'Добавить меню'), 'url' => array('create')),
    array('label' => Yii::t('menu', 'Управление меню'), 'url' => array('admin')),
    
    array('label' => Yii::t('menu', 'Пункты меню')),
    array('label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('menuitem/create')),
    array('label' => Yii::t('menu', 'Cписок пунктов меню'), 'url' => array('menuitem/index')),
    array('label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('menuitem/admin')),
    //@formatter:on
);
?>

<h1><?php echo Yii::t('menu', 'Меню'); ?></h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
