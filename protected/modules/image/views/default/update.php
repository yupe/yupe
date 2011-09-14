<?php
$this->breadcrumbs = array(
    $this->getModule('image')->getCategory() => array(''),
    Yii::t('image', 'Изображения') => array('admin'),
    $model->name => array('view', 'id' => $model->name),
    Yii::t('image', 'Редактирование изображения'),
);

$this->menu = array(
    array('label' => Yii::t('image', 'Список изображений'), 'url' => array('index')),
    array('label' => Yii::t('image', 'Добавить изображение'), 'url' => array('create')),
    array('label' => Yii::t('image', 'Просмотреть изображение'), 'url' => array('view', 'id' => $model->id)),
    array('label' => Yii::t('image', 'Управление изображениями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('image', 'Редактирование изображения');?>
    "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>