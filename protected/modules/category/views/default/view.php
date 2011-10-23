<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('category', 'Категории') => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('category', 'Добавить категорию'), 'url' => array('create')),
    array('label' => Yii::t('category', 'Список категорий'), 'url' => array('index')),
    array('label' => Yii::t('category', 'Изменить категорию'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('category', 'Удалить категорию'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
    array('label' => Yii::t('category', 'Управление категориями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('category', 'Просмотр категории');?>
    "<?php echo $model->name; ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'name',
                                                        'description',
                                                        'alias',
                                                        array(
                                                            'name' => 'status',
                                                            'value' => $model->getStatus()
                                                        ),
                                                    ),
                                               )); ?>
