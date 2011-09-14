<?php $this->pageTitle = Yii::t('page', 'Список страниц'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array(''),
    Yii::t('page', 'Страницы'),
);

$this->menu = array(
    array('label' => Yii::t('page', 'Добавить страницу'), 'url' => array('create')),
    array('label' => Yii::t('page', 'Управление страницами'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('page', 'Страницы');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>
