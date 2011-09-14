<?php $this->pageTitle = Yii::t('page', 'Добавление страницы'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array(''),
    Yii::t('page', 'Страницы') => array('admin'),
    Yii::t('page', 'Создать'),
);

$this->menu = array(
    array('label' => Yii::t('page', 'Список страниц'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('page', 'Добавление новой страницы');?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages)); ?>