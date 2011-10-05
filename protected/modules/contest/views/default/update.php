<?php
$this->breadcrumbs = array(
    $this->getModule('contest')->getCategory() => array(''),
    Yii::t('contest', 'Конкурсы изображений') => array('admin'),
    $model->name => array('view', 'id' => $model->id),
    Yii::t('contest', 'Редактирование'),
);

$this->menu = array(
    array('label' => Yii::t('contest', 'Список конкурсов'), 'url' => array('index')),
    array('label' => Yii::t('contest', 'Добавить конкурс'), 'url' => array('create')),
    array('label' => Yii::t('contest', 'Просмотр конкурса'), 'url' => array('view', 'id' => $model->id)),
    array('label' => Yii::t('contest', 'Управление конкурсами'), 'url' => array('admin')),
    array('label' => Yii::t('contest', 'Добавить изображение'), 'url' => array('addImage', 'contest_id' => $model->id)),
);
?>

<h1><?php echo Yii::t('contest', 'Редактирование конкурса');?>
    "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>