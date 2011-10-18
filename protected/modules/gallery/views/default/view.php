<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('gallery', 'Галереи изображений') => array('admin'),
    $model->name,
);


$this->menu = array(
    array('label' => Yii::t('gallery', 'Список галерей'), 'url' => array('index')),
    array('label' => Yii::t('gallery', 'Добавить галерею'), 'url' => array('create')),
    array('label' => Yii::t('gallery', 'Изменить галерею'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('gallery', 'Удалить галерею'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('gallery', 'Вы уверены, что хотите удалить галерею ?'))),
    array('label' => Yii::t('gallery', 'Управление галереями'), 'url' => array('admin')),
    array('label' => Yii::t('gallery', 'Добавить изображение'), 'url' => array('addImage', 'galleryId' => $model->id))
);

?>

<h1><?php echo Yii::t('gallery', 'Просмотр галереи');?>
    "<?php echo $model->name; ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'name',
                                                        'description',
                                                        array(
                                                            'name' => Yii::t('gallery', 'Количество фото'),
                                                            'value' => $model->imagesCount
                                                        ),
                                                        array(
                                                            'name' => 'status',
                                                            'value' => $model->getStatus()
                                                        ),
                                                    ),
                                               )); ?>

<br/>

<h1><?php echo Yii::t('gallery', 'Фотографии в этой галереи');?></h1> <?php echo CHtml::link(Yii::t('gallery', 'Добавить изображение'), array('/gallery/default/addImage/', 'galleryId' => $model->id)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                       'id' => 'image-grid',
                                                       'dataProvider' => new CActiveDataProvider('ImageToGallery', array(
                                                                                                                        'criteria' => array(
                                                                                                                            'condition' => 'galleryId = :galleryId',
                                                                                                                            'params' => array(':galleryId' => $model->id),
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
                                                               'name' => Yii::t('gallery', 'Название'),
                                                               'value' => '$data->image->name'
                                                           ),
                                                           array(
                                                               'name' => Yii::t('gallery', 'Автор'),
                                                               'value' => '$data->image->user->getFullName()'
                                                           ),
                                                           array(
                                                               'name' => Yii::t('gallery', 'Описание'),
                                                               'value' => '$data->image->description'
                                                           ),
                                                           'creation_date',
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                               'template' => '{delete}',
                                                               'deleteButtonUrl' => 'Yii::app()->request->baseUrl."/index.php/gallery/default/deleteImage/id/{$data->id}"'
                                                           ),
                                                       ),
                                                  )); ?>
