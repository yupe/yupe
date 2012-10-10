<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('blog')->getCategory() => array(),
        Yii::t('blog', 'Блоги') => array('/blog/BlogAdmin/index'),
        $model->name,
    );
    $this->pageTitle = Yii::t('blog', 'Блоги - просмотр');
    $this->menu = array(
        array('label' => Yii::t('blog', 'Блоги'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление блогами'), 'url' => array('/blog/BlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить блог'), 'url' => array('/blog/BlogAdmin/create')),
            array('label' => Yii::t('blog', 'Блог') . ' «' . $model->name . '»'),
            array('icon' => 'pencil', 'encodeLabel' => false, 'label' => Yii::t('blog', 'Редактирование блога'), 'url' => array(
                '/blog/BlogAdmin/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open white', 'encodeLabel' => false, 'label' => Yii::t('blog', 'Просмотреть блог'), 'url' => array(
                '/blog/BlogAdmin/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('blog', 'Удалить блог'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('delete', 'id' => $model->id),
                'confirm' => Yii::t('blog', 'Вы уверены, что хотите удалить блог?')
            )),
        )),
        array('label' => Yii::t('blog', 'Записи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление записьями'), 'url' => array('/blog/PostAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить запись'), 'url' => array('/blog/PostAdmin/create')),
        )),
        array('label' => Yii::t('blog', 'Участники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('blog', 'Управление участниками'), 'url' => array('/blog/UserToBlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('blog', 'Добавить участника'), 'url' => array('/blog/UserToBlogAdmin/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('blog', 'Просмотр блога'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'name',
        'description',
        array(
            'name'  => Yii::t('blog', 'Записей'),
            'value' => $model->postsCount
        ),
        array(
            'name'  => Yii::t('blog', 'Участников'),
            'value' => $model->membersCount
        ),
        'icon',
        'slug',
        array(
            'name'  => 'type',
            'value' => $model->getType(),
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
        array(
            'name'  => 'create_user_id',
            'value' => $model->createUser->getFullName(),
        ),
        array(
            'name'  => 'update_user_id',
            'value' => $model->updateUser->getFullName(),
        ),
        array(
            'name'  => 'create_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_date, "short", "short"),
        ),
        array(
            'name'  =>'update_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_date, "short", "short"),
        )
    ),
)); ?>
