<?php $this->pageTitle = Yii::t('page', 'Редактирование страницы'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array(''),
    Yii::t('page', 'Страницы') => array('admin'),
    $model->title => array('view', 'id' => $model->id),
    Yii::t('page', 'Изменение'),
);

$this->menu = array(
    array('encodeLabel'=> false, 'label' => '<i class="icon-list"></i>'.Yii::t('page', 'Управление страницами'), 'url' => array('admin')),
    array('encodeLabel'=> false, 'label' => '<i class="icon-file"></i>'.Yii::t('page', 'Добавить страницу'), 'url' => array('/page/default/create')),
    array('encodeLabel'=> false, 'label' => '<i class="icon-pencil icon-white"></i>'.Yii::t('page', 'Редактирование страницы')."<br /><span class='label' style='font-size: 80%; margin-left:17px;'>".mb_substr($model-> name,0,32)."</span>", 'url' => array('/page/default/update','id'=> $model-> id)),
);
?>

<div class="page-header">
  <h1><?php echo Yii::t('page', 'Редактирование страницы')?>
  <br /><small>&laquo;<?php echo $model->title; ?>&raquo;</small>
  </h1>
</div>


<?php echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages)); ?>

