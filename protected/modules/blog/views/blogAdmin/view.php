<?php
$this->breadcrumbs = array(
    Yii::t('blog', 'Блоги') => array('admin'),
    $model->name,
);
//@formatter:off
$this->menu=array(
    array('label' => Yii::t('blog', 'Список блогов'), 'url'=>array('index')),
    array('label' => Yii::t('blog', 'Добавить блог'), 'url'=>array('create')),
    array('label' => Yii::t('blog', 'Редактировать блог'), 'url'=>array('update', 'id'=>$model->id)),
    array('label' => Yii::t('blog', 'Удалить блог'), 'url'=>'#', 'linkOptions'=>array(
        'submit'=>array('delete', 'id'=>$model->id),
        'confirm'=>Yii::t('blog', 'Подтверждаете удаление ?'),
    )),
    array('label' => Yii::t('blog', 'Управление блогами'), 'url'=>array('admin')),
);
//@formatter:on
?>

<h1><?php echo Yii::t('blog', 'Просмотр блога'); ?>
"<?php echo $model->name; ?>"</h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'description',
        array(
            'name'  => Yii::t('blog','Записей'),
            'value' => $model->postsCount
        ),
        array(
            'name'  => Yii::t('blog','Участников'),
            'value' => $model->membersCount
        ),
        'icon',
        'slug',
        array(
            'name' => 'type',
            'value' => $model->getType(),
        ),
        array(
            'name' => 'status',
            'value' => $model->getStatus(),
        ),
        array(
            'name' => 'create_user_id',
            'value' => $model->createUser->getFullName(),
        ),
        array(
            'name' => 'update_user_id',
            'value' => $model->updateUser->getFullName(),
        ),
        array(
            'name' => 'create_date',
            'value' => $model->create_date,
        ),
        array(
            'name' => 'update_date',
            'value' => $model->update_date,
        ),
    ),
));
?>
