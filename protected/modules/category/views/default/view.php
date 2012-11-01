<?php
$this->breadcrumbs=array(
    $this->module->getCategory() => array(''),
    'Категории'=>array('index'),
    $model->name,
);
$this-> pageTitle ="категории - ".Yii::t('yupe','просмотр');
$this->menu=array(
    array('icon' => 'list-alt', 'label' => Yii::t('yupe', 'Управление категориями'),'url' => array('/category/default/index')),
    array('icon' => 'file', 'label' => Yii::t('yupe', 'Добавление категории'),'url' => array('/category/default/create')),
    array('icon' => 'pencil', 'encodeLabel' => false, 'label' => Yii::t('yupe', 'Редактирование категории') . ' "' . mb_substr($model->name,0,32).'"','url'=>array('/category/default/update','alias'=>$model->alias)),
    array('icon' => 'eye-open', 'encodeLabel' => false, 'label' => Yii::t('yupe', 'Просмотреть категорию'),'url' => array('/category/default/view','id'=>$model->id)),
    array('icon' => 'remove', 'label' => Yii::t('yupe', 'Удалить категорию'), 'url' => '#', 'linkOptions' => array('submit' => array('delete','id'=>$model->id),'confirm'=> Yii::t('yupe','Вы уверены, что хотите удалить?'))),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','Просмотр');?> категории<br />
     <small style='margin-left:-10px;'>&laquo;<?php echo  $model->name; ?>&raquo;</small></h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        array(
            'name'  => 'parent_id',
            'value' => $model->getParentName(),
        ),
        'name',
        'alias',
        array(
            'name'  => 'image',
            'type'  => 'raw',
            'value' => $model->image ? CHtml::image($model->imageSrc, $model->name, array('width' => 300,'height' => 300)) : '---',
        ),
        'description',
        'short_description',
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
    ),
)); ?>
