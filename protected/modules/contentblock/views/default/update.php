<?php
$this->breadcrumbs = array(
    $this->getModule('contentblock')->getCategory() => array(''),
    Yii::t('contentblock', 'Блоки контента') => array('admin'),
    $model->name => array('view', 'id' => $model->id),
    Yii::t('contentblock', 'Редактирование блока контента'),
);

$this->menu = array(
    array('label' => Yii::t('contentblock', 'Управление блоками контента'), 'url' => array('admin')),
    array('label' => Yii::t('contentblock', 'Добавить блок контента'), 'url' => array('create')),
    array('label' => Yii::t('contentblock', 'Список блоков контента'), 'url' => array('index')),
    array('label' => Yii::t('contentblock', 'Просмотреть этот блок контента'), 'url' => array('view', 'id' => $model->id)),
);
?>

<h1><?php echo Yii::t('contentblock', 'Редактирование блока контента');?>
    "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>