<?php
$this->breadcrumbs = array(
    $this->getModule('contentblock')->getCategory() => array(''),
    Yii::t('contentblock', 'Блоки контента') => array('admin'),
    Yii::t('contentblock', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('contentblock', 'Добавить новый блок'), 'url' => array('/contentblock/default/create')),
    array('label' => Yii::t('contentblock', 'Управление блоками контента'), 'url' => array('/contentblock/default/admin')),
);
?>

<h1><?php echo $this->module->getName();?></h1>
<?php $this->widget('bootstrap.widgets.BootGridView', array(
                                                       'id' => 'content-block-grid',
                                                       'dataProvider' => $model->search(),
                                                       'type'=>'condensed',
                                                       'columns' => array(
                                                           'id',
                                                           array(
                                                               'name' => 'name',
                                                               'type' => 'raw',
                                                               'value' => 'CHtml::link($data->name,array("/contentblock/default/update","id" => $data->id))'
                                                           ),
                                                           array(
                                                               'name' => 'type',
                                                               'value' => '$data->getType()'
                                                           ),
                                                           'code',                                                           
                                                           'description',
                                                           array(
                                                               'class' => 'bootstrap.widgets.BootButtonColumn',
                                                           ),
                                                       ),
                                                  )); ?>
