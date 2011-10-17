<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array(''),
    Yii::t('gallery', 'Галереи изображений') => array('admin'),
    $model->name => array('view', 'id' => $model->id),
    Yii::t('gallery', 'Редактирование галереи'),
);

$this->menu = array(
    array('label' => Yii::t('gallery', 'Список галерей'), 'url' => array('index')),
    array('label' => Yii::t('gallery', 'Добавить галерею'), 'url' => array('create')),
    array('label' => Yii::t('gallery', 'Просмотреть галерею'), 'url' => array('view', 'id' => $model->id)),
    array('label' => Yii::t('gallery', 'Управление галереями'), 'url' => array('admin')),
    array('label' => Yii::t('gallery', 'Добавить изображение'), 'url' => array('addImage', 'galleryId' => $model->id))
);
?>

<h1><?php echo Yii::t('gallery', 'Редактирование галереи');?>
    "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>