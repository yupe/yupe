<?php
    $this->breadcrumbs = array(
        Yii::t('blog', 'Блоги') => array('admin'),
        $model->name,
    );
    $this->menu=array(
        array('label' => Yii::t('blog', 'Блоги')),
        array('icon' => 'th-large', 'label' => Yii::t('blog', 'Управление блогами'), 'url' => array('/blog/blogAdmin/admin/')),
        array('icon' => 'th-list', 'label' => Yii::t('blog', 'Список блогов'), 'url' => array('/blog/blogAdmin/index/')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить блог'), 'url' => array('/blog/blogAdmin/create/')),

        array('label' => Yii::t('blog', 'Записи')),
        array('icon' => 'th-large', 'label' => Yii::t('blog', 'Управление записями'), 'url' => array('/blog/postAdmin/admin/')),
        array('icon' => 'th-list', 'label' => Yii::t('blog', 'Список записей'), 'url' => array('/blog/postAdmin/index/')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить запись'), 'url' => array('/blog/postAdmin/create/')),

        array('label' => Yii::t('blog', 'Участники')),
        array('icon' => 'th-large', 'label' => Yii::t('blog', 'Управление участниками'), 'url' => array('/blog/userToBlogAdmin/admin/')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить участника'), 'url' => array('/blog/userToBlogAdmin/create/')),

        array('label' => Yii::t('user', 'Блог')),
        array('icon' => 'pencil', 'label' => Yii::t('user', 'Редактирование блога'), 'url' => array('/blog/blogAdmin/update', 'id' => $model->id)),
        array('icon' => 'eye-open white', 'label' => Yii::t('user', 'Просмотр блога'), 'url' => array('/blog/blogAdmin/view', 'id' => $model->id)),
        array('icon' => 'trash', 'label' => Yii::t('user', 'Удалить блог'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/blog/blogAdmin/delete', 'id' => $model->id),
            'confirm' => 'Подтверждаете удаление ?'),
        ),
    );
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
