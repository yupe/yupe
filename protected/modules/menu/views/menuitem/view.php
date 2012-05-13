<?php
$this->breadcrumbs = array(
    Yii::t('menu', 'Меню') => array('admin'),
    Yii::t('menu', 'Пункты меню') => array('adminMenuItem'),
    $model->title,
);

$this->menu = array(
    //@formatter:off
    array('label' => Yii::t('menu', 'Меню')),
    array('label' => Yii::t('menu', 'Добавить меню'), 'url' => array('create')),
    array('label' => Yii::t('menu', 'Список меню'), 'url' => array('index')),
    array('label' => Yii::t('menu', 'Управление меню'), 'url' => array('admin')),

    array('label' => Yii::t('menu', 'Пункты меню')),
    array('label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('addMenuItem')),
    array('label' => Yii::t('menu', 'Изменить пункт меню'), 'url' => array('updateMenuItem', 'id' => $model->id)),
    array('label' => Yii::t('menu', 'Удалить пункт меню'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('deleteMenuItem', 'id' => $model->id),
        'confirm' => Yii::t('menu', 'Подтверждаете удаление?')),
    ),
    array('label' => Yii::t('menu', 'Cписок пунктов меню'), 'url' => array('indexMenuItem')),
    array('label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('adminMenuItem')),
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
        // :KLUDGE: Обратить внимание, возможно сделать иначе определение корня
        array(
            'name' => 'parent_id',
            'value' => $model->parentName,
        ),
        'type',
        'sort',
        array(
            'name' => 'status',
            'value' => $model->getStatus(),
        ),
    ),
));
?>