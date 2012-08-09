<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('admin'),
    $model->title => array('view', 'id' => $model->id),
    Yii::t('news', 'Редактирование новости'),
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление новостями'), 'url' => array('/news/default/admin')),
    array('icon' => 'th-list', 'label' => Yii::t('news', 'Показать анонсами'), 'url' => array('/news/default/index')),
    array('icon' => 'file', 'label' => Yii::t('news', 'Добавить новость'), 'url' => array('/news/default/create')),
    array('icon' => 'pencil white', 'encodeLabel'=> false, 'label' => Yii::t('news', 'Редактирование новости')."<br /><span class='label' style='font-size: 80%;'>".mb_substr($model-> title,0,32)."</span>", 'url' => array('/news/default/update','id'=> $model-> id)),
);
?>

<div class="page-header">
   <h1>
       <?php echo Yii::t('news', 'Редактирование новости'); ?>
       <br /><small style="margin-left:-10px;">&laquo;<?php echo $model->title; ?>&raquo;</small>
   </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
