<?php
$this->breadcrumbs = array(
    $this->getModule('dictionary')->getCategory() => array(''),
    Yii::t('dictionary', 'Справочники') => array('/dictionary/default/index'),
    Yii::t('dictionary', 'Просмотр'),
);

$this->menu=array(
    array('icon' => 'list-alt','label' => Yii::t('dictionary', 'Список справочников'), 'url' => array('/dictionary/default/index')),
    array('icon' => 'plus-sign','label' => Yii::t('dictionary', 'Добавить справочник'), 'url' => array('/dictionary/default/create')),
    array('icon' => 'pencil','label' => Yii::t('dictionary', 'Редактировать справочник'), 'url' => array('update', 'id' => $model->id)),
    array('icon' => 'trash','label' => Yii::t('dictionary', 'Удалить справочник'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
    array('icon' => 'list-alt','label' => Yii::t('dictionary', 'Данные справочника'), 'url' => array("/dictionary/dictionaryData/index?group_id={$model->id}")),
);
?>

<h1><?php echo Yii::t('dictionary', 'Просмотр справочника'); ?> "<?php echo $model->name; ?>"</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'code',
        'name',
        'description',
        'creation_date',
        'update_date',
        array(
            'name'  => 'create_user_id',
            'value' => $model->createUser->getFullName(),
        ),
        array(
            'name'  => 'update_user_id',
            'value' => $model->updateUser->getFullName(),
        ),
    ),
)); ?>