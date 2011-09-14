<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('admin'),
    $model->title => array('view', 'id' => $model->id),
    Yii::t('news', 'Редактирование новости'),
);

$this->menu = array(
    array('label' => Yii::t('news', 'Список новостей'), 'url' => array('index')),
    array('label' => Yii::t('news', 'Добавить новость'), 'url' => array('create')),
    array('label' => Yii::t('news', 'Просмотреть новость'), 'url' => array('view', 'id' => $model->id)),
    array('label' => Yii::t('news', 'Управление новостями'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('news', 'Редактирование новости');?>
    "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
