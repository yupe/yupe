<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('admin'),
    $model->title => array('view', 'id' => $model->id),
    Yii::t('news', 'Редактирование новости'),
);

$this->menu = array(
    array('encodeLabel'=> false, 'label' => '<i class="icon-list"></i>'.Yii::t('news', 'Управление новостями'), 'url' => array('/news/default/admin')),
    array('encodeLabel'=> false, 'label' => '<i class="icon-file"></i>'.Yii::t('news', 'Добавить новость'), 'url' => array('/news/default/create')),
    array('encodeLabel'=> false, 'label' => '<i class="icon-pencil icon-white"></i>'.Yii::t('news', 'Редактирование новости')."<br /><span class='label' style='font-size: 80%; margin-left:17px;'>".mb_substr($model-> title,0,32)."</span>", 'url' => array('/news/default/update','id'=> $model-> id)),
);
?>

<div class="page-header"><h1><?php echo Yii::t('news', 'Редактирование новости');?>
   <br /><small>&laquo;<?php echo $model->title; ?>&raquo;</small></h1></div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
