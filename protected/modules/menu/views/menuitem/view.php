<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array(''),
    Yii::t('menu', 'Меню') => array('menu/admin'),
    Yii::t('menu', 'Пункты меню') => array('admin'),
    $model->title,
);

$this->menu = array(
    //@formatter:off
    array('label' => Yii::t('menu', 'Меню')),
    array('label' => Yii::t('menu', 'Добавить меню'), 'url' => array('menu/create')),
    array('label' => Yii::t('menu', 'Список меню'), 'url' => array('menu/index')),
    array('label' => Yii::t('menu', 'Управление меню'), 'url' => array('menu/admin')),

    array('label' => Yii::t('menu', 'Пункты меню')),
    array('label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('create')),
    array('label' => Yii::t('menu', 'Изменить пункт меню'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('menu', 'Удалить пункт меню'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('delete', 'id' => $model->id),
        'confirm' => Yii::t('menu', 'Подтверждаете удаление?')),
    ),
    array('label' => Yii::t('menu', 'Cписок пунктов меню'), 'url' => array('index')),
    array('label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('admin')),
    //@formatter:onn
);
?>

<h1><?php echo Yii::t('menu', 'Просмотр пункта меню'); ?> "<?php echo $model->title; ?>"</h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'title',
        'href',
        array(
            'name' => 'menu_id',
            'value' => $model->menu->name,
        ),
        array(
            'name' => 'parent_id',
            'value' => $model->parent,
        ),
        array(
            'name' => 'condition_name',
            'value' => $model->conditionName,
        ),
        'sort',
        array(
            'name' => 'status',
            'value' => $model->getStatus(),
        ),
    ),
));
?>