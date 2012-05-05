<?php
$this->breadcrumbs = array(
    $this->getModule('contentblock')->getCategory() => array(''),
    Yii::t('contentblock', 'Блоки контента') => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => Yii::t('contentblock', 'Добавить блок контента'), 'url' => array('create')),
    array('label' => Yii::t('contentblock', 'Управление блоками контента'), 'url' => array('admin')),
    array('label' => Yii::t('contentblock', 'Редактирование блока контента'), 'url' => array('/contentblock/default/update', 'id' => $model->id)),
    array('label' => Yii::t('contentblock', 'Просмотреть блок контента'), 'url' => array('/contentblock/default/view', 'id' => $model->id)),
    array('label' => Yii::t('contentblock', 'Удалить этот блок контента'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('contentblock', 'Удалить этот элемент ?'))),
);
?>

<h1><?php echo Yii::t('contentblock', 'Просмотр блока контента');?>
    "<?php echo $model->name; ?>"</h1>

<?php $this->widget('bootstrap.widgets.BootDetailView', array(
                                                    'data' => $model,
                                                    'attributes' => array(
                                                        'id',
                                                        'name',
                                                        'code',
                                                        array(
                                                            'name' => 'type',
                                                            'value' => $model->getType()
                                                        ),
                                                        'content',
                                                        'description',
                                                    ),
                                               )); ?>
<br/>
<div>
    <?php echo Yii::t('contentblock', 'Код для использования этого блока в шаблоне:');?>
    <br/><br/>
    <?php echo $example;?>
</div>
