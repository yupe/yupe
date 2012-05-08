<?php $this->pageTitle = Yii::t('page', 'Добавление страницы'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array(''),
    Yii::t('page', 'Страницы') => array('admin'),
    Yii::t('page', 'Создать'),
);

$this->menu = array(
    array('encodeLabel'=> false, 'label' => '<i class="icon-list"></i>'.Yii::t('page', 'Управление страницами'), 'url' => array('admin')),
    array('encodeLabel'=> false, 'label' => '<i class="icon-file icon-white"></i>'.Yii::t('page', 'Добавление страницы'), 'url' => array('/page/default/create')),
);
?>
<div class="page-header"><h1><?=$this->module->getName()?> <small><?php echo Yii::t('page', 'Добавление новой страницы');?></small></h1></div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages)); ?>