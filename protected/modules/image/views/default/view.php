<?php
$this->breadcrumbs = array(
    $this->getModule('image')->getCategory() => array(''),
    Yii::t('image', 'Изображения') => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('image', 'Список изображений'), 'url' => array('index')),
    array('label' => Yii::t('image', 'Добавить изображение'), 'url' => array('create')),
    array('label' => Yii::t('image', 'Редактировать изображение'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('image', 'Удалить изображение'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
    array('label' => Yii::t('image', 'Управление изображениями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('image', 'Просмотр изображения');?>
    "<?php echo $model->name; ?>"</h1>

<?php echo CHtml::image($model->file, $model->alt, array('width' => 500, 'height' => 500)); ?>

<br/><br/>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'name',
                                                        'description',
                                                        'alt',
                                                        'file',
                                                        'creation_date',
                                                        array(
                                                            'name' => 'user_id',
                                                            'value' => $model->user->getFullName()
                                                        ),
                                                        array(
                                                            'name' => 'status',
                                                            'value' => $model->getStatus()
                                                        )
                                                    ),
                                               )); ?>
