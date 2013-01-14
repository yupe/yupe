<?php
    $blog = Yii::app()->getModule('blog');
    $this->breadcrumbs = array(
        $blog->getCategory() => array('/yupe/backend/index', 'category' => $blog->getCategoryType() ),
        Yii::t('BlogModule.blog', 'Блоги') => array('/blog/defaultAdmin/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('BlogModule.blog', 'Блоги - просмотр');

    $this->menu = array(
        array('label' => Yii::t('BlogModule.blog', 'Блоги'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление блогами'), 'url' => array('/blog/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить блог'), 'url' => array('/blog/defaultAdmin/create')),
            array('label' => Yii::t('BlogModule.blog', 'Блог') . ' «' . mb_substr($model->name, 0, 32) . '»'),
            array('icon' => 'pencil', 'encodeLabel' => false, 'label' => Yii::t('BlogModule.blog', 'Редактирование блога'), 'url' => array(
                '/blog/defaultAdmin/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'encodeLabel' => false, 'label' => Yii::t('BlogModule.blog', 'Просмотреть блог'), 'url' => array(
                '/blog/defaultAdmin/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Удалить блог'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/blog/defaultAdmin/delete', 'id' => $model->id),
                'confirm' => Yii::t('BlogModule.blog', 'Вы уверены, что хотите удалить блог?'),
            )),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Записи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление записями'), 'url' => array('/blog/postAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить запись'), 'url' => array('/blog/postAdmin/create')),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Участники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление участниками'), 'url' => array('/blog/userToBlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить участника'), 'url' => array('/blog/userToBlogAdmin/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Просмотр блога'); ?><br />
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
            'name'  => Yii::t('BlogModule.blog', 'Записей'),
            'value' => $model->postsCount
        ),
        array(
            'name'  => Yii::t('BlogModule.blog', 'Участников'),
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
