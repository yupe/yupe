<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array(''),
    Yii::t('menu', 'Меню') => array('/menu/menu/index'),
    Yii::t('menu', 'Пункты меню') => array('/menu/menuitem/index'),
    $model->title => array('view', 'id' => $model->id),
    Yii::t('menu', 'Редактирование'),
);

$this->menu = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'plus-sign', 'label' => Yii::t('menu', 'Добавить меню'), 'url' => array('/menu/menu/create')),
    array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление меню'), 'url' => array('/menu/menu/index')),
    array('label' => Yii::t('menu', 'Пункты меню')),
    array('icon' => 'plus-sign', 'label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('/menu/menuitem/create')),
    array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('/menu/menuitem/index')),
    array('icon' => 'pencil', 'label' => Yii::t('menu', 'Изменить пункт меню'), 'url' => array('/menu/menuitem/update', 'id' => $model->id)),
    array('icon' => 'trash', 'label' => Yii::t('menu', 'Удалить пункт меню'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('/menu/menuitem/delete', 'id' => $model->id),
        'confirm' => Yii::t('menu', 'Подтверждаете удаление?')),
    ),
);
?>

<h1><?php echo Yii::t('menu', 'Редактирование пункта меню'); ?> "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>