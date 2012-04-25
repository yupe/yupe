<?php $this->pageTitle = Yii::t('page', 'Редактирование страницы'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array(''),
    Yii::t('page', 'Страницы') => array('admin'),
    $model->title => array('view', 'id' => $model->id),
    Yii::t('page', 'Изменение'),
);

$this->menu = array(
    array('label' => Yii::t('page', 'Добавить страницу'), 'url' => array('create')),
    array('label' => Yii::t('page', 'Список страниц'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('page', 'Редактирование страницы')?>
    "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages)); ?>

