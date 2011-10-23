<?php
$this->breadcrumbs = array(
    $this->getModule('contest')->getCategory() => array(''),
    Yii::t('contest', 'Конкурсы изображений') => array('admin'),
    $model->name => array('view', 'id' => $model->id),
    Yii::t('contest', 'Просмотр'),
);

$this->menu = array(
    array('label' => Yii::t('contest', 'Список конкурсов'), 'url' => array('index')),
    array('label' => Yii::t('contest', 'Добавить конкурс'), 'url' => array('create')),
    array('label' => Yii::t('contest', 'Изменить конкурс'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('contest', 'Удалить конкурс'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
    array('label' => Yii::t('contest', 'Управление конкурсами'), 'url' => array('admin')),
    array('label' => Yii::t('contest', 'Добавить изображение'), 'url' => array('addImage', 'contest_id' => $model->id)),
);

?>

<h1><?php echo Yii::t('contest', 'Просмотр конкурса');?>
    "<?php echo $model->name; ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'name',
                                                        'description',
                                                        'start_add_image',
                                                        'stop_add_image',
                                                        'start_vote',
                                                        'stop_vote',
                                                        array(
                                                            'name' => 'status',
                                                            'value' => $model->getStatus()
                                                        )
                                                    ),
                                               )); ?>

<br/>

<h1><?php echo Yii::t('contest', 'Изображения в этом конкурсе');?></h1> <?php echo CHtml::link(Yii::t('contest', 'Добавить изображение'), array('/contest/default/addImage/', 'contest_id' => $model->id)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                       'id' => 'image-to-contest',
                                                       'dataProvider' => new CActiveDataProvider('ImageToContest', array(
                                                                                                                        'criteria' => array(
                                                                                                                            'condition' => 'contest_id = :contest_id',
                                                                                                                            'params' => array(':contest_id' => $model->id),
                                                                                                                            'with' => 'image.user'
                                                                                                                        )
                                                                                                                   )),
                                                       'columns' => array(
                                                           'id',
                                                           array(
                                                               'name' => 'image_id',
                                                               'type' => 'raw',
                                                               'value' => 'CHtml::image($data->image->file,$data->image->alt,array("width" => 50,"height" => 50))'
                                                           ),
                                                           array(
                                                               'name' => Yii::t('contest', 'Название'),
                                                               'value' => '$data->image->name'
                                                           ),
                                                           array(
                                                               'name' => Yii::t('contest', 'Автор'),
                                                               'value' => '$data->image->user->getFullName()'
                                                           ),
                                                           array(
                                                               'name' => Yii::t('contest', 'Описание'),
                                                               'value' => '$data->image->description'
                                                           ),
                                                           'creation_date',
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                               'template' => '{delete}',
                                                               'deleteButtonUrl' => 'Yii::app()->request->baseUrl."/index.php/contest/default/deleteImage/id/{$data->id}"'
                                                           ),
                                                       ),
                                                  )); ?>
