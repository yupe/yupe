<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array(''),
    Yii::t('menu', 'Меню') => array('/menu/menu/index'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('menu', 'Меню')),
    array('icon' => 'plus-sign', 'label' => Yii::t('menu', 'Добавить меню'), 'url' => array('/menu/menu/create')),
    array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление меню'), 'url' => array('/menu/menu/index')),
    array('icon' => 'pencil', 'label' => Yii::t('menu', 'Изменить меню'), 'url' => array('/menu/menu/update', 'id' => $model->id)),
    array('icon' => 'trash', 'label' => Yii::t('menu', 'Удалить меню'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('/menu/menu/delete', 'id' => $model->id),
        'confirm' => Yii::t('menu', 'Подтверждаете удаление?')),
    ),
    array('label' => Yii::t('menu', 'Пункты меню')),
    array('icon' => 'plus-sign', 'label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('/menu/menuitem/create')),
    array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('/menu/menuitem/index')),
);
?>

<h1><?php echo Yii::t('menu', 'Просмотр меню'); ?> "<?php echo $model->name; ?>"</h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'name',
        'code',
        'description',
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
    ),
));
?>