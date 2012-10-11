<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array(''),
    Yii::t('menu', 'Меню') => array('menu/admin'),
    Yii::t('menu', 'Пункты меню') => array('admin'),
    $model->title => array(
        'view',
        'id' => $model->id,
    ),
    Yii::t('menu', 'Редактирование'),
);

$this->menu = array(
    //@formatter:off
    array('label' => Yii::t('menu', 'Меню')),
    array('label' => Yii::t('menu', 'Добавить меню'), 'url' => array('menu/create')),
    array('label' => Yii::t('menu', 'Список меню'), 'url' => array('menu/index')),
    array('label' => Yii::t('menu', 'Управление меню'), 'url' => array('menu/admin')),
    
    array('label' => Yii::t('menu', 'Пункты меню')),
    array('label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('create')),
    array('label' => Yii::t('menu', 'Просмотр пункта меню'), 'url' => array('view', 'id' => $model->id)),
    array('label' => Yii::t('menu', 'Cписок пунктов меню'), 'url' => array('index')),
    array('label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('admin')),
    //@formatter:on
);
?>

<h1><?php echo Yii::t('menu', 'Редактирование пункта меню'); ?> "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>