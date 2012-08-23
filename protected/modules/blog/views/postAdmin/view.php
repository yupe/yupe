<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('blog', 'Записи') => array('/blog/PostAdmin/index'),
        $model->title,
    );
    $this->pageTitle = Yii::t('blog', 'Записи - просмотр');
    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление записьями'), 'url' => array('/blog/PostAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить запись'), 'url' => array('/blog/PostAdmin/create')),
        array('label' => Yii::t('blog', 'Запись')),
        array('icon' => 'pencil', 'encodeLabel' => false, 'label' => Yii::t('blog', 'Редактирование записи'), 'url' => array(
            '/blog/PostAdmin/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open white', 'encodeLabel' => false, 'label' => Yii::t('blog', 'Просмотреть запись'), 'url' => array(
            '/blog/PostAdmin/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('blog', 'Удалить запись'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id),
            'confirm' => Yii::t('blog', 'Вы уверены, что хотите удалить запись?')
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('blog', 'Просмотр') . ' ' . Yii::t('blog', 'записи'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
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
        'create_date',
        'update_date',
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
)); ?>
