<?php
    $this->breadcrumbs = array(
        Yii::t('blog', 'Блоги')=>array('blogAdmin/admin'),
        Yii::t('blog', 'Записи')=>array('postAdmin/admin'),
        $model->title=>array('view', 'id'=>$model->id),
        Yii::t('blog', 'Просмотр'),
    );

    $this->menu=array(
        array('label'=>Yii::t('blog', 'Список записей'), 'url'=>array('index')),
        array('label'=>Yii::t('blog', 'Добавить запись'), 'url'=>array('create')),
        array('label'=>Yii::t('blog', 'Редактировать запись'), 'url'=>array('update', 'id'=>$model->id)),
        array('label'=>Yii::t('blog', 'Удалить запись'), 'url'=>'#', 'linkOptions'=>array(
            'submit'=>array('delete', 'id'=>$model->id),
            'confirm'=>Yii::t('blog', 'Подтверждаете удаление ?'),
        )),
        array('label'=>Yii::t('blog', 'Управление записями'), 'url'=>array('admin')),
    );
?>

<h1><?php echo Yii::t('blog','Просмотр записи'); ?> "<?php echo $model->title; ?>"</h1>

<?php
    $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'id',
            array(
                'name'=>'blog',
                'value'=>$model->blog->name,
            ),
            array(
                'name'=>'create_user_id',
                'value'=>$model->createUser->getFullName(),
            ),
            array(
                'name'=>'update_user_id',
                'value'=>$model->updateUser->getFullName(),
            ),
            array(
                'name'=>'create_date',
                'value'=>$model->create_date,
            ),
            array(
                'name'=>'update_date',
                'value'=>$model->update_date,
            ),
            'slug',
            'publish_date',
            'title',
            'quote',
            'content',
            'link',
            array(
                'name'=>'status',
                'value'=>$model->getStatus(),
            ),
            array(
                'name'=>'comment_status',
                'value'=>$model->getCommentStatus(),
            ),
            array(
                'name'=>'access_type',
                'value'=>$model->getAccessType(),
            ),
            'keywords',
            'description',
        ),
    ));
?>
