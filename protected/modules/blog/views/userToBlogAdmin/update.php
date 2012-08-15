<?php
    $this->breadcrumbs = array(
        Yii::t('blog', 'Блоги')=>array('blogAdmin/admin'),
        Yii::t('blog', 'Участники')=>array('admin'),
        $model->user->getFullName()=>array('view', 'id'=>$model->id),
        Yii::t('blog', 'Редактирование'),
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

        array('label' => Yii::t('user', 'Участник')),
        array('icon' => 'pencil white', 'label' => Yii::t('user', 'Редактирование участника'), 'url' => array('/blog/userToBlogAdmin/update', 'id' => $model->id)),
        array('icon' => 'eye-open', 'label' => Yii::t('user', 'Просмотр участника'), 'url' => array('/blog/userToBlogAdmin/view', 'id' => $model->id)),
        array('icon' => 'trash', 'label' => Yii::t('user', 'Удалить участника'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/blog/userToBlogAdmin/delete', 'id' => $model->id),
            'confirm' => 'Подтверждаете удаление ?'),
        ),
    );
?>

<h1>
    <?php
        echo Yii::t('blog', 'Редактирование участника "{name}" блога "{blog}"', array(
            '{name}'=>$model->user->getFullName(),
            '{blog}'=>$model->blog->name,
        ));
    ?>
</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>