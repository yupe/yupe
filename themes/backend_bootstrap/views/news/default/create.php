<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('admin'),
    Yii::t('news', 'Добавление новости'),
);

$this->menu = array(
    array('encodeLabel'=> false, 'label' => '<i class="icon-list"></i>'.Yii::t('news', 'Управление новостями'), 'url' => array('/news/default/admin')),
    array('encodeLabel'=> false, 'label' => '<i class="icon-file icon-white"></i>'.Yii::t('news', 'Добавление новости'), 'url' => array('/news/default/create')),
);
?>
<div class="page-header"><h1><?=$this->module->getName()?> <small><?php echo Yii::t('news', 'Добавление новости');?></small></h1></div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>