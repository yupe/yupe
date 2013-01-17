<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType() ),
        Yii::t('BlogModule.blog', 'Блоги') => array('/blog/defaultAdmin/index'),
        Yii::t('BlogModule.blog', 'Записи') => array('/blog/postAdmin/index'),
        $model->title,
    );

    $this->pageTitle = Yii::t('BlogModule.blog', 'Записи - просмотр');

    $this->menu = array(
        array('label' => Yii::t('BlogModule.blog', 'Блоги'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление блогами'), 'url' => array('/blog/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить блог'), 'url' => array('/blog/defaultAdmin/create')),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Записи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление записями'), 'url' => array('/blog/postAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить запись'), 'url' => array('/blog/postAdmin/create')),
            array('label' => Yii::t('BlogModule.blog', 'Запись') . ' «' . mb_substr($model->title, 0, 32) . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('BlogModule.blog', 'Редактирование записи'), 'url' => array(
                '/blog/postAdmin/update',
				'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('BlogModule.blog', 'Просмотреть запись'), 'url' => array(
                '/blog/postAdmin/view',
				'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('BlogModule.blog', 'Удалить запись'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/blog/postAdmin/delete', 'id' => $model->id),
                'confirm' => Yii::t('BlogModule.blog', 'Вы уверены, что хотите удалить запись?'),
            )),
        )),
        array('label' => Yii::t('BlogModule.blog', 'Участники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('BlogModule.blog', 'Управление участниками'), 'url' => array('/blog/userToBlogAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('BlogModule.blog', 'Добавить участника'), 'url' => array('/blog/userToBlogAdmin/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('BlogModule.blog', 'Просмотр записи'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'blog',
            'value' => $model->blog->name,
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
            'name'  => 'publish_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->publish_date, "short", "short"),
        ),
        array(
            'name'  => 'create_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_date, "short", "short"),
        ),
        array(
            'name'  => 'update_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_date, "short", "short"),
        ),
        'slug',
        'title',
        'quote',
        'content',
        'link',
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
        array(
            'name'  => 'comment_status',
            'value' => $model->getCommentStatus(),
        ),
        array(
            'name'  => 'access_type',
            'value' => $model->getAccessType(),
        ),
        'keywords',
        'description',
    ),
)); ?>